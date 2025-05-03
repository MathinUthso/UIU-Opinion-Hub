


<?php
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav>
    <ul>
    <li><a href = "home.php">UIU OPINION HUB</a></li>
    </ul>
    <ul>
    <li><a href = "role.php">⬅️ Role Selection</a></li>
    <li><a href = "vote.php">🗳️ See votes</a></li>
    </ul>
  </nav>
</header>

<main>
<div class="container">
    <h1>🎉 Submission Successful!</h1>
    <p>Thank you for sharing your opinion with UIU Opinion Hub.</p>
</div>
</main>

<footer style = "position: fixed;">
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href = "#discord-link">Refresh</a>
</footer>
<script>
            setTimeout(function() {
                window.location.href = "home.php";
            }, 5000);
            </script>
            <?php exit ?>
        
</body>
</html>
