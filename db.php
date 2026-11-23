<?php
declare(strict_types=1);

/**
 * db.php — Central Supabase Connection for RigMarket PH.
 * 
 * Connected to Sam's Project in Sam Org (bwtggiazgqmcwxxrzswl).
 * Supports both:
 *   1. Supabase REST API (Instant, zero password needed, uses publishable anon key).
 *   2. Direct PostgreSQL PDO (pdo_pgsql) if SUPABASE_DB_PASSWORD is provided in .env.
 */

// Load .env variables if .env exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $val] = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            putenv("{$key}={$val}");
            $_ENV[$key] = $val;
        }
    }
}

// Supabase Configuration
define('SUPABASE_URL', getenv('SUPABASE_URL') ?: 'https://bwtggiazgqmcwxxrzswl.supabase.co');
define('SUPABASE_KEY', getenv('SUPABASE_KEY') ?: 'sb_publishable_BinwVUxgUz3tFjG0q1iCNQ__F2ze6jf');
define('SUPABASE_DB_HOST', getenv('SUPABASE_DB_HOST') ?: 'db.bwtggiazgqmcwxxrzswl.supabase.co');
define('SUPABASE_DB_PORT', getenv('SUPABASE_DB_PORT') ?: '5432');
define('SUPABASE_DB_NAME', getenv('SUPABASE_DB_NAME') ?: 'postgres');
define('SUPABASE_DB_USER', getenv('SUPABASE_DB_USER') ?: 'postgres');
define('SUPABASE_DB_PASSWORD', getenv('SUPABASE_DB_PASSWORD') ?: '');

/**
 * Make a direct REST API call to Supabase PostgREST.
 *
 * Example:
 *   $products = supabase_request('products?select=*&order=id.asc');
 *   $new = supabase_request('products', 'POST', ['title' => 'RTX 4070', ...]);
 */
function supabase_request(string $endpoint, string $method = 'GET', ?array $data = null): ?array
{
    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . ltrim($endpoint, '/');
    $ch  = curl_init($url);

    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

    if ($data !== null && in_array(strtoupper($method), ['POST', 'PATCH', 'PUT'], true)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $status >= 400) {
        return null;
    }

    $decoded = json_decode((string)$response, true);
    return is_array($decoded) ? $decoded : null;
}

/**
 * Convenience wrapper for a Supabase REST POST insert.
 * Returns the inserted row array or null on failure.
 */
function supabase_insert(string $table, array $data): ?array
{
    $result = supabase_request($table, 'POST', $data);
    return is_array($result) ? ($result[0] ?? null) : null;
}

/**
 * Get direct PostgreSQL PDO connection (requires DB password).
 */
function get_pdo_connection(): PDO
{
    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s;sslmode=require",
        SUPABASE_DB_HOST,
        SUPABASE_DB_PORT,
        SUPABASE_DB_NAME
    );

    return new PDO($dsn, SUPABASE_DB_USER, SUPABASE_DB_PASSWORD, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
