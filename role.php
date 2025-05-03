<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
        $_SESSION['role'] = $role;

        if ($role == 'student' || $role == 'alumni') {
            header("Location: stu_alu.php");
            exit;
        } else if ($role == 'faculty') {
            header("Location: faculty.php");
            exit;
        } else {
            $error = "Invalid role selected.";
        }
    } else {
        $error = "Role was not set.";
    }
} else if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $error = "Invalid request method.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav>
    <ul>
    <li><a href = "home.php">UIU OPINION HUB</a></li>
    </ul>
    <ul>
      <li><a href = "vote.php">See votes</a></li>
      <li><a href = "home.php">Opinions</a></li>
    </ul>
  </nav>
</header>

<main>
<div class="container">
    <h1>UIU Opinion Hub</h1>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">

        <div class="form-group" >
            <label for="role">Who are you?</label>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="student">Student</option>
                <option value="alumni">Alumni</option>
                <option value="faculty">Faculty</option>
            </select>
        </div>
        <button type="submit" id="submit" name="submit">Submit</button>
    </form>
</div>
</main>
<footer style="position: fixed;">
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href = "#discord-link">Refresh</a>
</footer>
</body>
</html>
