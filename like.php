<?php
session_start();
require_once 'config/database.php';

var_dump($_POST);

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    echo "Invalid request.";
    exit;
}

$userId = $_SESSION['user_id'];
$postId = (int) $_POST['post_id'];
$role   = $_POST['role'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user already liked the post
    $check = $pdo->prepare("SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?");
    $check->execute([$postId, $userId]);

    if ($check->rowCount() > 0) {
        echo "You have already liked this post!";
        exit;
    }

    // Insert into post_likes table
    $insert = $pdo->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
    $insert->execute([$postId, $userId]);

    // Update the total_like count
    $update = $pdo->prepare("UPDATE posts SET total_like = total_like + 1 WHERE post_id = ?");
    $update->execute([$postId]);

    header("Location: home.php");
    exit;

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
