<?php
require_once 'init.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$q = ($_GET['q'] ?? '');


$sql = "
        SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE posts.title LIKE '%".$q."%' OR posts.content LIKE '%".$q."%'
        ORDER BY posts.created_at DESC
";

try {
    $res = $conn->query($sql);
} catch (mysqli_sql_exception $e) {
    // Display SQL error (this is what makes it error-based injectable)
    echo '<h2>SQL Error:</h2><pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    exit;
}

// ------------------------------------------
// ✅ Secure version using prepared statements (Mitigation)
// Uncomment to use safely:
//
// if ($q !== '') {
//     $like = "%$q%";
//     $stmt = $conn->prepare("
//         SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
//         FROM posts
//         JOIN users ON posts.user_id = users.id
//         WHERE posts.title LIKE ? OR posts.content LIKE ?
//         ORDER BY posts.created_at DESC
//     ");
//     $stmt->bind_param('ss', $like, $like);
// } else {
//     $stmt = $conn->prepare("
//         SELECT posts.id, posts.title, posts.content, posts.created_at, users.username
//         FROM posts
//         JOIN users ON posts.user_id = users.id
//         ORDER BY posts.created_at DESC
//     ");
// }
// $stmt->execute();
// $res = $stmt->get_result();
// ------------------------------------------
?>

<!-- all echo are htmlspecialchars-->
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Find Posts</title></head>
<body>
<h2>Find Posts</h2>
<p>Welcome, <?php echo ($_SESSION['username']); ?> — <a href="logout.php">Logout</a></p>

<form method="get">
    <input type="text" name="q" value="<?php echo ($q); ?>" placeholder="Search posts">
    <button type="submit">Find</button>
</form>
<hr>


<?php if ($res === false): ?>
    <p><strong>SQL error:</strong> <?php echo ($conn->error); ?></p>
<?php elseif ($res->num_rows === 0): ?>
    <p>No posts found.</p>
<?php else: ?>
    <?php while ($row = $res->fetch_assoc()): ?>
        <article>
            <h3>
                <a href="view_posts.php?id=<?php echo (int)$row['id']; ?>">
                    <?php echo ($row['title']); ?>
                </a>
            </h3>
            <p><?php echo nl2br((substr($row['content'], 0, 300))); ?><?php if (strlen($row['content'])>300) echo '...'; ?></p>
            <small>Posted by <?php echo ($row['username']); ?> on <?php echo $row['created_at']; ?></small>
            <hr>
        </article>
    <?php endwhile; ?>
<?php endif; ?>

<p><a href="post.php">Create Post</a></p>
</body>
</html>
