<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = isset($_POST['action']) ? htmlspecialchars((string)$_POST['action']) : 'contact';

function render_page_start(string $title = 'RigMarket PH'): void
{
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>" . htmlspecialchars($title) . "</title>";
    echo "<script src='https://cdn.tailwindcss.com'></script>";
    echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' />";
    echo "<script>tailwind.config = { theme: { extend: { colors: { brand: '#D2232A', brandDark: '#A81C21' } } } }</script>";
    echo "</head>";
    echo "<body class='bg-slate-900 text-white min-h-screen flex items-center justify-center font-sans p-4'>";
    echo "<div class='bg-slate-800 border border-slate-700 rounded-lg p-8 max-w-md w-full text-center shadow-xl'>";
}

function render_page_end(): void
{
    echo "</div>";
    echo "</body>";
    echo "</html>";
}

function render_result_card(string $heading, string $type, string $message, string $buttonText, string $buttonUrl): void
{
    $colors = [
        'success' => 'text-green-400',
        'error'   => 'text-red-500',
        'warning' => 'text-yellow-400',
    ];
    $colorClass = $colors[$type] ?? 'text-white';

    echo "<h2 class='text-2xl font-bold {$colorClass} mb-2'>" . htmlspecialchars($heading) . "</h2>";
    echo "<p class='text-slate-300 mb-6 leading-relaxed'>" . htmlspecialchars($message) . "</p>";
    echo "<a href='" . htmlspecialchars($buttonUrl) . "' class='inline-block bg-brand hover:bg-brandDark text-white font-semibold px-6 py-2.5 rounded transition shadow-md'>" . htmlspecialchars($buttonText) . "</a>";
}

// 1. Logout Action
if ($action === 'logout') {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();

    render_page_start('RigMarket PH - Logged Out');
    echo "<script>localStorage.removeItem('currentUser'); window.location.href = 'index.php';</script>";
    render_result_card('Signed Out', 'success', 'You have been successfully logged out.', 'Go to Home', 'index.php');
    render_page_end();
    exit;
}

// 2. Contact Support Form Submission (Fallback)
if ($action === 'contact') {
    $name     = trim((string)($_POST['name'] ?? ''));
    $email    = trim((string)($_POST['email'] ?? ''));
    $category = trim((string)($_POST['category'] ?? 'General Inquiry'));
    $issue    = trim((string)($_POST['issue'] ?? ''));
    $message  = trim((string)($_POST['message'] ?? ($_POST['inquiry'] ?? '')));

    render_page_start('RigMarket PH - Contact Support');

    if ($name === '' || $email === '' || $message === '') {
        render_result_card('Error', 'error', 'Please fill in all required fields.', 'Back to Contact Support', 'contact.php');
        render_page_end();
        exit;
    }

    $inserted = supabase_insert('inquiries', [
        'name'     => $name,
        'email'    => $email,
        'category' => $category,
        'issue'    => $issue ?: 'General',
        'message'  => $message,
    ]);

    if ($inserted !== null) {
        render_result_card('Inquiry Sent!', 'success', "Thank you, {$name}. Your inquiry has been saved.", 'Back to Home', 'index.php');
    } else {
        render_result_card('Error', 'error', 'Could not save your inquiry to the cloud database. Please try again.', 'Back to Contact Support', 'contact.php');
    }

    render_page_end();
    exit;
}

// 3. Registration Action
if ($action === 'register') {
    $name     = trim((string)($_POST['name'] ?? ''));
    $email    = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    render_page_start('RigMarket PH - Register');

    if ($name === '' || $email === '' || $password === '') {
        render_result_card('Registration Failed', 'error', 'All fields are required.', 'Back to Register', 'login.php');
        render_page_end();
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        render_result_card('Registration Failed', 'error', 'Please provide a valid email address.', 'Back to Register', 'login.php');
        render_page_end();
        exit;
    }

    // Check if user already exists in Supabase
    $existing = supabase_request('users?email=eq.' . urlencode($email) . '&select=id&limit=1');

    if (!empty($existing)) {
        render_result_card('Registration Failed', 'warning', 'An account with that email already exists.', 'Sign In Instead', 'login.php');
        render_page_end();
        exit;
    }

    // Securely hash password with bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $newUser = supabase_insert('users', [
        'name'     => $name,
        'email'    => $email,
        'password' => $hashedPassword,
    ]);

    if ($newUser !== null) {
        render_result_card('Account Created!', 'success', "Welcome, {$name}! Your account has been registered. You can now log in.", 'Sign In Now', 'login.php');
    } else {
        render_result_card('Error', 'error', 'Could not create your account. Please try again later.', 'Back to Register', 'login.php');
    }

    render_page_end();
    exit;
}

// 4. Login Action
if ($action === 'login') {
    $email    = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    render_page_start('RigMarket PH - Login');

    if ($email === '' || $password === '') {
        render_result_card('Login Failed', 'error', 'Please enter your email and password.', 'Try Again', 'login.php');
        render_page_end();
        exit;
    }

    // Fetch user from Supabase
    $users = supabase_request('users?email=eq.' . urlencode($email) . '&select=id,name,email,password&limit=1');

    if (!empty($users)) {
        $user = $users[0];
        $storedPassword = (string)$user['password'];

        // Verify password: checks bcrypt hash, or plaintext fallback for legacy seed users
        $passwordValid = password_verify($password, $storedPassword) || ($password === $storedPassword);

        if ($passwordValid) {
            // Save authenticated session in PHP
            $_SESSION['user'] = [
                'id'    => (int)$user['id'],
                'name'  => (string)$user['name'],
                'email' => (string)$user['email'],
            ];

            // If user had plaintext password, automatically upgrade to bcrypt in Supabase
            if ($password === $storedPassword && !str_starts_with($storedPassword, '$2y$')) {
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                supabase_request('users?id=eq.' . (int)$user['id'], 'PATCH', ['password' => $newHash]);
            }

            // Sync localStorage for backwards compatibility with existing frontend scripts
            $userDataJson = json_encode([
                'id'    => (int)$user['id'],
                'name'  => (string)$user['name'],
                'email' => (string)$user['email'],
            ]);

            echo "<script>";
            echo "localStorage.setItem('currentUser', JSON.stringify(" . $userDataJson . "));";
            echo "window.location.href = 'index.php?login=success';";
            echo "</script>";

            render_result_card('Login Successful!', 'success', "Welcome back, " . $user['name'] . "!", 'Go to Marketplace', 'index.php?login=success');
            render_page_end();
            exit;
        }
    }

    render_result_card('Login Failed', 'error', 'Invalid email or password.', 'Try Again', 'login.php');
    render_page_end();
    exit;
}

// Any other action
header('Location: index.php');
exit;
