<?php
session_start();
// db.php
require_once 'config/database.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
$query = ("SELECT
    p.post_id,
    p.opinion,
    p.submitted_at,
    p.total_like,
    p.vote,
    CASE 
        WHEN p.student_id IS NOT NULL THEN 
             s.role
        WHEN p.faculty_id IS NOT NULL THEN 
            'faculty'  
        ELSE 
            'Unknown'  
    END AS posted_by
FROM posts p
LEFT JOIN student s ON p.student_id = s.student_id
LEFT JOIN faculty f ON p.faculty_id = f.id
ORDER BY p.submitted_at DESC");

// Fetch opinions from student table
$stmt = $pdo->query($query);
$allOpinions = $stmt->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Asia/Dhaka');
function timeAgo($timestamp) {
  $diff = abs(time() - $timestamp);

  if ($diff < 60)
      return "$diff seconds ago";
  elseif ($diff < 3600)
      return floor($diff / 60) . " minutes ago";
  elseif ($diff < 86400)
      return floor($diff / 3600) . " hours ago";
  else
      return floor($diff / 86400) . " days ago";
}


?>



<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset = "UTF-8">
  <meta name    = "viewport" content = "width=device-width, initial-scale=1.0">
  <title>UIU Opinion Hub - Home</title>
  <link rel = "stylesheet" href = "home.css">
</head>
<body>

<header>
  <nav>
    <ul>
    <li><a href  = "home.php">UIU OPINION HUB</a></li>
    </ul>
    <ul>
    <li><a href="role.php">⬅️ Role Selection</a></li>
      <li><a href = "vote.php">🗳️See votes</a></li>
    </ul>
  </nav>
</header>

<main>
  <section id = "opinions" class = "container">
    <h1>Latest Opinions</h1>

    <?php foreach ($allOpinions as $opinion): ?>
      <div  class = "post">
      <div  class = "post-header">
      <div  class = "user-info">
      <span class = "username">
              <?php
              if (isset($opinion['posted_by'])) {
                echo htmlspecialchars($opinion['posted_by']) . '_' . rand(11,999);
                
              }
              ?>
      
            

            </span>
            <span class = "timestamp"><?php echo timeAgo(strtotime($opinion['submitted_at'])?? ''); ?></span>
          </div>
        </div>
        <div class = "post-content">
          <p><?php echo htmlspecialchars($opinion['opinion']); ?></p>
        </div>
    <div    class       = "post-meta">
    <span   class       = "vote-tag">Vote: <?php echo htmlspecialchars($opinion['vote'] ?? ''); ?></span>
    <form   method      = "POST" action  = "like.php" style = "display: inline;">
    <input  type        = "hidden" name  = "post_id" value  = "<?php echo htmlspecialchars($opinion['post_id']); ?>">
    <input  type        = "hidden" name  = "role" value     = "<?php echo htmlspecialchars($opinion['posted_by']); ?>">
    <button type        = "submit" class = "like-btn" name  = "like_button">
    👍      <span class = "like-count"><?php echo $opinion['total_like']; ?></span>
</button>

          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</main>

<footer>
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href = "sendTicket.php">Got any suggestions or query?</a>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
      button.addEventListener('click', function () {
        let countSpan = button.querySelector('.like-count');
        let currentCount = parseInt(countSpan.textContent);
        countSpan.textContent = currentCount + 1;
      });
    });
  });
</script>


</body>
</html>






