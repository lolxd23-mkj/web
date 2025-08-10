<?php
// init.php - start session and include database
session_start();

// Include database connection
require_once 'db.php';

// Optionally load current user data if logged in
if (!empty($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $currentUser = $stmt->get_result()->fetch_assoc();
}
