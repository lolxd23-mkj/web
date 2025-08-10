<?php
// db.php - database connection used site-wide
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'web';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("DB connect error: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
