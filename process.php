<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // connect to database
    $conn = new mysqli("localhost", "root", "", "rigmarket_db");

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // check which form was submitted
    $action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : "contact";

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>RigMarket PH - Process</title>";
    echo "<script src='https://cdn.tailwindcss.com'></script>";
    echo "</head>";
    echo "<body class='bg-slate-900 text-white min-h-screen flex items-center justify-center font-sans p-4'>";
    echo "<div class='bg-slate-800 border border-slate-700 rounded-lg p-8 max-w-md w-full text-center shadow-lg'>";

    // contact form
    if ($action === "contact") {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $inquiry = htmlspecialchars($_POST["inquiry"]);
        $message = htmlspecialchars($_POST["message"]);

        $sql = "INSERT INTO inquiries (name, email, inquiry, message) VALUES ('$name', '$email', '$inquiry', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "<h2 class='text-2xl font-bold text-green-400 mb-2'>Inquiry Sent!</h2>";
            echo "<p class='text-slate-300 mb-6'>Thank you, " . $name . ". Your inquiry has been saved to the database.</p>";
            echo "<a href='contact.php' class='inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition'>Back to Contact Support</a>";
        } else {
            echo "<h2 class='text-2xl font-bold text-red-500 mb-2'>Error</h2>";
            echo "<p class='text-slate-300 mb-6'>" . $conn->error . "</p>";
            echo "<a href='contact.php' class='inline-block bg-slate-700 hover:bg-slate-600 text-white font-semibold px-4 py-2 rounded transition'>Back to Contact Support</a>";
        }

    // register form
    } elseif ($action === "register") {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        // check if user already exists
        $check = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($check->num_rows > 0) {
            echo "<h2 class='text-2xl font-bold text-yellow-400 mb-2'>Registration Failed</h2>";
            echo "<p class='text-slate-300 mb-6'>An account with that email already exists.</p>";
            echo "<a href='login.php' class='inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition'>Back to Login / Register</a>";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "<h2 class='text-2xl font-bold text-green-400 mb-2'>Account Created!</h2>";
                echo "<p class='text-slate-300 mb-6'>Welcome, " . $name . "! Your account has been successfully created.</p>";
                echo "<a href='login.php' class='inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition'>Sign In Now</a>";
            } else {
                echo "<h2 class='text-2xl font-bold text-red-500 mb-2'>Error</h2>";
                echo "<p class='text-slate-300 mb-6'>" . $conn->error . "</p>";
                echo "<a href='login.php' class='inline-block bg-slate-700 hover:bg-slate-600 text-white font-semibold px-4 py-2 rounded transition'>Back to Login / Register</a>";
            }
        }

    // login form
    } elseif ($action === "login") {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            echo "<script>";
            echo "localStorage.setItem('currentUser', JSON.stringify({ name: " . json_encode($user["name"]) . ", email: " . json_encode($user["email"]) . " }));";
            echo "</script>";

            echo "<h2 class='text-2xl font-bold text-green-400 mb-2'>Login Successful!</h2>";
            echo "<p class='text-slate-300 mb-6'>Welcome back, " . $user["name"] . "!</p>";
            echo "<a href='index.php?login=success' class='inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition'>Go to Home</a>";
        } else {
            echo "<h2 class='text-2xl font-bold text-red-500 mb-2'>Login Failed</h2>";
            echo "<p class='text-slate-300 mb-6'>Invalid email or password.</p>";
            echo "<a href='login.php' class='inline-block bg-slate-700 hover:bg-slate-600 text-white font-semibold px-4 py-2 rounded transition'>Try Again</a>";
        }
    }

    echo "</div>";
    echo "</body>";
    echo "</html>";

    // close connection
    $conn->close();
}

?>