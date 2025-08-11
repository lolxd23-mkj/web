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
    <a href="find.php">Find</a>
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="content">
    <h1>Dashboard</h1>
    <p>This is your main navigation hub.</p>
    <h2>Upload Profile Image</h2>
    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_image" accept="image/*" required>
        <button type="submit">Upload Image</button>
    </form>

    <?php
    // Display uploaded image if exists
    $imageParam = $_GET['img'] ?? ('default' . '.jpg');
    $imagePath = 'uploads/' . $imageParam;

    if (file_exists($imagePath)) {
    echo '<h3>Your Profile Image:</h3>';
    // Note: no escaping of $imagePath here
    $image = htmlspecialchars($_SESSION['username'] , ENT_QUOTES);
    echo '<img src="view_image.php?img='.$image.'.jpg" alt="Profile Image">
';
    } else {
    echo "Image not found.";
    }
    ?>

    <?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    /* Mitigation: only allow filenames with safe characters (no ../)
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $page)) {
        die('Invalid file name.');
    }
    */
    $filepath = __DIR__ . '/' . $page;

    if (file_exists($filepath)) {
        include $filepath;
    } else {
        echo "File not found.";
    }
    echo '<img src="view_image.php?img='.$filepath.'" alt="Profile Image">';
}
?>

<h2>Load Page</h2>
<form method="GET" action="">
    <input type="text" name="page" placeholder="Enter file path or page name">
    <button type="submit">Load</button>
</form>
</div>



</body>
</html>
