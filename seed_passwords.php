<?php
require 'db.php';

$credentials = [
    'judge1' => 'Judge1Pass',
    'judge2' => 'Judge2Pass',
    'judge3' => 'Judge3Pass',
    'judge4' => 'Judge4Pass',
    'admin'  => 'AdminPass',
];

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
foreach ($credentials as $username => $plaintext) {
    $hash = password_hash($plaintext, PASSWORD_DEFAULT);
    $stmt->execute([$hash, $username]);
}

echo "Passwords seeded successfully! You can now log in.";
?>