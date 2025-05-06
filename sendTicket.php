<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageContent = trim($_POST['message'] ?? '');
    $email= trim($_POST['Email'] ?? '');

    if ($messageContent !== '') {
        $webhookUrl = "Your webhook URL here";

        $payload = [
            "content" => "📩 New message from '$email': \n" . $messageContent
        ];

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        file_put_contents("log.txt", "HTTP $httpCode - $response");
          // Redirect back after sending
    header("Location: home.php");
    exit;
    }

    
} else {
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta name    = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Submit a Ticket</title>
</head>
<body>
<header>
  <nav>
    <ul>
    <li><a href = "home.php">UIU OPINION HUB</a></li>
    </ul>
    <ul>
      <li><a href = "vote.php">🗳️ See votes</a></li>
      <li><a href = "home.php">🗣 Opinions</a></li>
    </ul>
  </nav>
</header>
<main>
<div class = "container">
<h2>Add your suggestions or Questions</h2>
<form action = "sendTicket.php" method = "POST">
  <input type="text" name="Email" placeholder="Your E-mail">
  <textarea name="message" rows="4" cols="50" placeholder="Type your feedback here..." required></textarea><br>
  <button type="submit">Send to Developer 💬</button>
</form>
</div>
</main>
<footer style = "position: fixed;">
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href = "https://discord.gg/3cYBz6Kg">Still not satisfied? Submit quries directly</a>
</footer>
</body>
</html>
