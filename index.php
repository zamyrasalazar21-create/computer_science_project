<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: judge.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Computer Science Project Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Computer Science Project Login</h2>

<form action="login.php" method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>