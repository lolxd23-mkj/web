<?php
session_start();

// If user already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome</h1>
    <p>Please sign in or register to continue.</p>
    <a href="login.php">Sign In</a> |
    <a href="register.php">Register</a>
</body>
</html>
