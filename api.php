<?php
declare(strict_types=1);

/*
 * api.php — The Central JSON API for RigMarket PH.
 *
 * This file handles background AJAX calls without reloading the browser.
 * It serves two main purposes:
 *   1. ?action=support_data -> Supplies the 2-tier dropdown options for contact.php.
 *   2. ?action=contact      -> Receives the contact form via AJAX, validates it,
 *                              saves it to MySQL (rigmarket_db), and returns JSON.
 */

require_once __DIR__ . '/data/support_data.php';

// Tell the browser that every response from this file is JSON, not HTML.
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

// ---------------------------------------------------------------------------
// Action 1: Support Data (Feeds the 2-tier dropdowns via AJAX)
// ---------------------------------------------------------------------------
if ($action === 'support_data') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'message' => 'POST request required.']);
        exit;
    }

    $data     = support_categories();
    $type     = $_POST['type'] ?? '';
    $category = trim((string) ($_POST['category'] ?? ''));

    // Question A: Give me the top-level categories
    if ($type === 'categories') {
        echo json_encode([
            'ok'    => true,
            'items' => array_keys($data),
        ]);
        exit;
    }

    // Question B: Give me the specific issues under the selected category
    if ($type === 'issues') {
        $issues = $data[$category] ?? [];
        echo json_encode([
            'ok'    => true,
            'items' => $issues,
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Unknown support request type.']);
    exit;
}

// ---------------------------------------------------------------------------
// Action 2: Contact Form Submission (Saves inquiry to MySQL via AJAX)
// ---------------------------------------------------------------------------
if ($action === 'contact') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'message' => 'POST request required.']);
        exit;
    }

    // Read and sanitize form inputs
    $name     = trim((string) ($_POST['name'] ?? ''));
    $email    = trim((string) ($_POST['email'] ?? ''));
    $category = trim((string) ($_POST['category'] ?? ''));
    $issue    = trim((string) ($_POST['issue'] ?? ''));
    $message  = trim((string) ($_POST['message'] ?? ''));

    // Basic Validation
    if ($name === '' || $email === '' || $category === '' || $issue === '' || $message === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(422);
        echo json_encode(['ok' => false, 'message' => 'Please provide a valid email address.']);
        exit;
    }

    // Connect to MySQL database using PDO
    try {
        $dsn = 'mysql:host=localhost;dbname=rigmarket_db;charset=utf8mb4';
        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // Auto-create or ensure columns exist in `inquiries` table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `inquiries` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `inquiry` VARCHAR(100) DEFAULT '',
                `category` VARCHAR(100) NOT NULL,
                `issue` VARCHAR(150) NOT NULL,
                `message` TEXT NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Check if category & issue columns already exist (in case table was created from older schema)
        $columns = $pdo->query("SHOW COLUMNS FROM `inquiries`")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('category', $columns, true)) {
            $pdo->exec("ALTER TABLE `inquiries` ADD COLUMN `category` VARCHAR(100) NOT NULL AFTER `email`");
        }
        if (!in_array('issue', $columns, true)) {
            $pdo->exec("ALTER TABLE `inquiries` ADD COLUMN `issue` VARCHAR(150) NOT NULL AFTER `category`");
        }

        // Insert record securely using Prepared Statements (protects against SQL injection)
        $stmt = $pdo->prepare("
            INSERT INTO `inquiries` (`name`, `email`, `category`, `issue`, `message`)
            VALUES (:name, :email, :category, :issue, :message)
        ");

        $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':category' => $category,
            ':issue'    => $issue,
            ':message'  => $message,
        ]);

        $insertedId = (int) $pdo->lastInsertId();

        // Send back clean JSON success response
        echo json_encode([
            'ok'      => true,
            'message' => "Thank you, {$name}! Your inquiry (Ticket #{$insertedId}) has been received.",
            'id'      => $insertedId,
        ]);
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'ok'      => false,
            'message' => 'Database error: ' . $e->getMessage(),
        ]);
        exit;
    }
}

// Any other action is unrecognized
http_response_code(404);
echo json_encode(['ok' => false, 'message' => 'Action not found.']);
