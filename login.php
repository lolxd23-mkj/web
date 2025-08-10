<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username and password required.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $u = $stmt->get_result()->fetch_assoc();

        if ($u && password_verify($password, $u['password'])) {
            // Good login: regenerate session id
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$u['id'];
            $_SESSION['username'] = $username;
            header('Location: find.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h2>Login</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
<form method="post">
    Username: <input name="username" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    <button type="submit">Login</button>
</form>
<hr>
<a href="register.php">Register</a>
</body>
</html>
