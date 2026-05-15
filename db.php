<?php
// db.php — connects to PostgreSQL using Render's DATABASE_URL environment variable

$url = getenv('DATABASE_URL');

if (!$url) {
    die("<p style='color:red;font-family:sans-serif'>DATABASE_URL environment variable is not set. Make sure your Render PostgreSQL database is linked to this service.</p>");
}

// Parse the URL: postgres://user:password@host:port/dbname
$parts = parse_url($url);

$host   = $parts['host'];
$port   = $parts['port'] ?? 5432;
$dbname = ltrim($parts['path'], '/');
$user   = $parts['user'];
$pass   = $parts['pass'];

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("<p style='color:red;font-family:sans-serif'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>");
}