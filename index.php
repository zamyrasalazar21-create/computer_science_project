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
    <style>
        .login-wrapper {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
        }
        .login-box {
            width: 340px;
            background-color: #cfcfcf;
            font-family: Arial, Helvetica, sans-serif;
        }
        .login-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border-bottom: 3px solid white;
        }
        .login-body {
            padding: 24px 20px;
        }
        .login-body label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .login-body input {
            width: 100%;
            padding: 8px;
            font-size: 13px;
            border: none;
            background-color: white;
            box-sizing: border-box;
            margin-bottom: 14px;
            outline: none;
        }
        .login-body button {
            width: 100%;
            padding: 9px;
            font-size: 13px;
            font-weight: bold;
            background-color: #b0b0b0;
            border: 2px solid #777;
            cursor: pointer;
        }
        .login-body button:hover {
            background-color: #a0a0a0;
        }
        .error-msg {
            color: #cc0000;
            font-size: 12px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <div class="login-title">Computer Science Project</div>
        <div class="login-body">

            <!-- Show error if login failed -->
            <?php if (isset($_GET['error'])): ?>
                <p class="error-msg">Invalid username or password.</p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <label>Username:</label>
                <input type="text" name="username" required>

                <label>Password:</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>