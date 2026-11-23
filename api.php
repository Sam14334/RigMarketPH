<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/data/support_data.php';

// Tell the browser that every response from this file is JSON, not HTML.
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

// Action 1: Current Session Info
if ($action === 'session') {
    echo json_encode([
        'ok'   => true,
        'user' => $_SESSION['user'] ?? null,
    ]);
    exit;
}

// Action 2: Get All Products (Live Feed for Marketplace & Homepage)
if ($action === 'products') {
    $rows = supabase_request('products?select=*,categories(name)&order=id.desc') ?? [];

    // Flatten category name for backwards compatibility with frontend filter scripts
    $formatted = array_map(function ($p) {
        if (isset($p['categories']['name'])) {
            $p['category'] = $p['categories']['name'];
        } elseif (!isset($p['category'])) {
            $p['category'] = 'Other';
        }
        return $p;
    }, $rows);

    echo json_encode([
        'ok'   => true,
        'data' => $formatted,
    ]);
    exit;
}

// Action 3: Get Single Product by ID (With Gallery Images for details.php)
if ($action === 'product') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'message' => 'Invalid product ID.']);
        exit;
    }

    $rows = supabase_request("products?id=eq.{$id}&select=*,categories(name),listing_images(*)&limit=1") ?? [];
    if (empty($rows)) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'message' => 'Product not found.']);
        exit;
    }

    $product = $rows[0];
    if (isset($product['categories']['name'])) {
        $product['category'] = $product['categories']['name'];
    }

    echo json_encode([
        'ok'   => true,
        'data' => $product,
    ]);
    exit;
}

// Action 4: Create a New Listing
if ($action === 'create_listing') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'message' => 'POST request required.']);
        exit;
    }

    // Check authentication
    $currentUser = $_SESSION['user'] ?? null;
    if (!$currentUser) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'message' => 'You must be logged in to post a listing.']);
        exit;
    }

    // Support both application/json payload and multipart/url-encoded POST
    $rawInput = file_get_contents('php://input');
    $body = json_decode($rawInput, true);
    if (!is_array($body)) {
        $body = $_POST;
    }

    $title       = trim((string)($body['title'] ?? ''));
    $price       = (int)($body['price'] ?? 0);
    $category    = trim((string)($body['category'] ?? ''));
    $condition   = trim((string)($body['condition'] ?? ''));
    $location    = trim((string)($body['location'] ?? ''));
    $specs       = trim((string)($body['specs'] ?? ''));
    $description = trim((string)($body['description'] ?? ''));
    $customImg   = trim((string)($body['image'] ?? ''));

    if ($title === '' || $price <= 0 || $category === '' || $condition === '' || $location === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Map Category name to category_id
    $categoryMap = [
        'Processors'           => 1,
        'Graphics Cards (GPU)' => 2,
        'Laptops'              => 3,
        'Monitors'             => 4,
        'Peripherals'          => 5,
    ];
    $categoryId = $categoryMap[$category] ?? null;

    $defaultImage = 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=400&h=300';
    $finalImage   = $customImg !== '' ? $customImg : $defaultImage;

    $newProduct = supabase_insert('products', [
        'user_id'     => (int)$currentUser['id'],
        'title'       => $title,
        'price'       => $price,
        'category_id' => $categoryId,
        'condition'   => $condition,
        'brand'       => 'Other',
        'location'    => $location,
        'specs'       => $specs,
        'description' => $description !== '' ? $description : 'No additional description provided.',
        'image'       => $finalImage,
        'status'      => 'Available',
        'seller_name' => $currentUser['name'],
        'date_posted' => date('M d, Y'),
    ]);

    if ($newProduct === null || empty($newProduct['id'])) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'Failed to save product in database.']);
        exit;
    }

    // Save corresponding primary image record in listing_images
    supabase_insert('listing_images', [
        'product_id'    => (int)$newProduct['id'],
        'image_url'     => $finalImage,
        'storage_path'  => null,
        'is_primary'    => true,
        'display_order' => 1,
        'alt_text'      => $title,
    ]);

    echo json_encode([
        'ok'      => true,
        'message' => 'Listing successfully posted!',
        'data'    => $newProduct,
    ]);
    exit;
}

// Action 5: Support Data (Feeds 2-tier dropdowns on contact.php)
if ($action === 'support_data') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'message' => 'POST request required.']);
        exit;
    }

    $data     = support_categories();
    $type     = $_POST['type'] ?? '';
    $category = trim((string) ($_POST['category'] ?? ''));

    // Question A: Top-level categories
    if ($type === 'categories') {
        echo json_encode([
            'ok'    => true,
            'items' => array_keys($data),
        ]);
        exit;
    }

    // Question B: Specific issues under selected category
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

// Action 6: Contact Support Form Submission (Saves to Supabase inquiries)
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

    // Validation
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

    // Insert into Supabase inquiries table
    $inserted = supabase_insert('inquiries', [
        'name'     => $name,
        'email'    => $email,
        'category' => $category,
        'issue'    => $issue,
        'message'  => $message,
    ]);

    if ($inserted !== null && !empty($inserted['id'])) {
        $ticketId = $inserted['id'];
        echo json_encode([
            'ok'      => true,
            'message' => "Thank you, {$name}! Your inquiry (Ticket #{$ticketId}) has been received.",
            'id'      => $ticketId,
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'ok'      => false,
            'message' => 'Failed to save inquiry to the database. Please try again.',
        ]);
    }
    exit;
}

// Any other action is unrecognized
http_response_code(404);
echo json_encode(['ok' => false, 'message' => 'Action not found.']);
