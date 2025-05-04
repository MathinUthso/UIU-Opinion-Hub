


<?php
  session_start(); // Required to access $_SESSION
  
  $Message = $_SESSION['Message'] ?? '';
  unset($_SESSION['Message']); // Clear after showing
  
  
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
<?php if (!empty($Message) && $Message=="Your response has been recorded. Thank you!"): ?>
  <h1>Submission Succesful</h1>
  <p style = "color: green; text-align:center;"><?php echo $Message; ?></p>
<?php endif; ?>
<?php if (!empty($Message)&&$Message=="Something went wrong while saving your response. Please try again later."): ?>
  <h1>Submission Failed</h1>
  <p style="color: red;"><?php echo $Message; ?></p>
<?php endif; ?>

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
