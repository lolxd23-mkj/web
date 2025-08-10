<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $error = "Title and content are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $uid = $_SESSION['user_id'];
        $stmt->bind_param('iss', $uid, $title, $content);
        if ($stmt->execute()) {
            header('Location: find.php');
            exit();
        } else {
            $error = "DB error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Create Post</title></head>
<body>
<h2>Create a Post</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
<form method="post">
    Title: <input name="title" required><br><br>
    Content:<br>
    <textarea name="content" rows="6" cols="60" required></textarea><br><br>
    <button type="submit">Post</button>
</form>
<hr>
<a href="find.php">Find Posts</a> |
<a href="logout.php">Logout</a>
</body>
</html>
