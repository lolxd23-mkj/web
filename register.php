<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username and password are required.";
    } else {
        // create user (hashed password)
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hash);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            if ($conn->errno === 1062) $error = "Username already exists.";
            else $error = "DB error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
<h2>Register</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
<form method="post">
    Username: <input name="username" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    <button type="submit">Register</button>
</form>
<hr>
<a href="login.php">Login</a>
</body>
</html>
