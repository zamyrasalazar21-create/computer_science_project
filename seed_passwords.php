<?php
require 'db.php';

$credentials = [
    'judge1' => '1234',
    'judge2' => '1234',
    'judge3' => '1234',
    'judge4' => '1234',
    'admin'  => 'admin4321',
];

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
foreach ($credentials as $username => $plaintext) {
    $hash = password_hash($plaintext, PASSWORD_DEFAULT);
    $stmt->execute([$hash, $username]);
}

echo "Passwords seeded successfully! You can now log in.";
?>