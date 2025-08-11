<?php
// serve_image.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$imageParam = $_GET['img'] ?? ($_SESSION['username'] . '.jpg');
$baseDir = __DIR__.'/uploads/';

// Resolve the real absolute path of the requested file
$path = ($baseDir . $imageParam); //realPath

// Check if the file exists and is inside the uploads directory
//if ($path !== false && strpos($path, $baseDir) === 0 && file_exists($path)) {
if (file_exists($path)) {
    // Send correct content type header based on file MIME type
    header('Content-Type: ' . mime_content_type($path));
    // Output the file content
    readfile($path);
    exit;
} else {
    // If the file doesn't exist or is outside allowed dir
    echo 'File not found or access denied.';
}

?>
