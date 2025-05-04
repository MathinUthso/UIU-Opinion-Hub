<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    echo "Invalid request.";
    exit;
}

$userId = (int) $_SESSION['user_id'];
$postId = (int) $_POST['post_id'];

if ($postId <= 0) {
    echo "Invalid post ID.";
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();

    // Check if the user has already liked the post
    $check = $pdo->prepare("SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?");
    $check->execute([$postId, $userId]);

    if ($check->rowCount() > 0) {
        $pdo->rollBack();
        header("Location: home.php?liked=exists");
        exit;
    }

    // Insert into post_likes
    $insert = $pdo->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
    $insert->execute([$postId, $userId]);

    // Update total like count
    $update = $pdo->prepare("UPDATE posts SET total_like = total_like + 1 WHERE post_id = ?");
    $update->execute([$postId]);

    $pdo->commit();

    header("Location: home.php?liked=1");
    exit;

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Database error: " . $e->getMessage());
}
?>
