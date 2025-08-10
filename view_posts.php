<?php
require_once 'init.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid post id.";
    exit();
}
$id = (int) $_GET['id'];

$stmt = $conn->prepare("
    SELECT posts.*, users.username
    FROM posts
    JOIN users ON posts.user_id = users.id
    WHERE posts.id = ?
");
$stmt->bind_param('i', $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    exit();
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title><?php echo htmlspecialchars($post['title']); ?></title></head>
<body>
<h2><?php echo ($post['title']); ?></h2>

<p><?php echo nl2br($post['content']); ?></p>

<small>Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?></small>
<hr>
<a href="find.php">Back to posts</a> | <a href="post.php">Create Post</a> | <a href="logout.php">Logout</a>
</body>
</html>
