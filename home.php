<?php
// db.php
$host = 'localhost';
$dbname = 'mysocialapp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch opinions from student table
$stmt = $pdo->query("SELECT id,student_id, opinion,vote, role,total_likes,submitted_at FROM student ORDER BY submitted_at DESC");
$studentOpinions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch opinions from faculty table
$stmt            = $pdo->query("SELECT id, name,vote, opinion,role, total_likes, submitted_at FROM faculty ORDER BY submitted_at DESC");
$facultyOpinions = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
      <li><a href = "role.php">🔙 Role Selection</a></li>
      <li><a href = "vote.php"></a></li>
    </ul>
  </nav>
</header>

<main>
  <section id = "opinions" class = "container">
    <h1>Latest Opinions</h1>

    <?php foreach (array_merge($studentOpinions, $facultyOpinions) as $opinion): ?>
      <div  class = "post">
      <div  class = "post-header">
      <div  class = "user-info">
      <span class = "username">
              <?php
              if (isset($opinion['role'])) {
                echo htmlspecialchars($opinion['role']) . '_' . htmlspecialchars($opinion['id']);
              }
              ?>
            </span>
            <span class = "timestamp"><?php echo htmlspecialchars(timeAgo(strtotime($opinion['submitted_at'])) ?? ''); ?></span>
          </div>
        </div>
        <div class = "post-content">
          <p><?php echo htmlspecialchars($opinion['opinion']); ?></p>
        </div>
        <div    class  = "post-meta">
        <span   class  = "vote-tag">Vote: <?php echo htmlspecialchars($opinion['vote'] ?? ''); ?></span>
        <form   method = "POST" action  = "like.php" style = "display: inline;">
        <input  type   = "hidden" name  = "post_id" value  = "<?php echo htmlspecialchars($opinion['id']); ?>">
        <input  type   = "hidden" name  = "role" value     = "<?php echo htmlspecialchars($opinion['role']); ?>">
        <button type   = "submit" class = "like-btn">👍 <?php echo $opinion['total_likes']; ?></button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</main>

<footer>
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href = "role.php">Back to Role Selection</a>
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






