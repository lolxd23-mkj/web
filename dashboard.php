<?php
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        nav {
            background: #333;
            color: #fff;
            padding: 10px;
        }
        nav a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

<nav>
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <a href="dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="content">
    <h1>Dashboard</h1>
    <p>This is your main navigation hub.</p>
</div>

</body>
</html>
