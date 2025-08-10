<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Make sure uploads directory exists
$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    // Get filename from user input (vulnerable!)
    $filename = $_POST['filename'] ?? 'default.jpg';

    // Here you directly use the user-controlled filename without validation
    $targetPath = $uploadDir . '/' . $filename;

    // Then move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Failed to move uploaded file.";
    }
}


/*
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    // Basic validation: check for errors and file type
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes)) {
            // Save file as username.jpg (you can adjust to keep extension)
            $targetPath = $uploadDir . '/' . $_SESSION['username'] . '.jpg';

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Success, redirect back to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Only JPG, PNG, and GIF images are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
} 
*/ else {
    echo "No file uploaded.";
}
