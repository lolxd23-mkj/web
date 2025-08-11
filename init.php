<?php
// init.php - start session and include database
session_start();

// Include database connection
require_once 'db.php';

// Optionally load current user data if logged in
if (!empty($_SESSION['user_id'])) {
    $sql = "SELECT * FROM users WHERE id = " . $_SESSION['user_id'];
    $result = $conn->query($sql);

    if ($result && $user = $result->fetch_assoc()) {
        $currentUser = $user;
    }
}