<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];
    $_SESSION['full_name'] = $user['full_name'];

    if ($user['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: judge.php");
    }
    exit();
} else {
    echo "Invalid username or password.";
}
?>