<?php
session_start();

if(!isset($_SESSION['role'])){
    if($_SESSION['role']!="student"||$_SESSION['role']!='alumni'){
    header("Location:role.php");
    exit;
}
}
$role = $_SESSION['role'];
 //==============DB Connection=============================     
 require_once 'config/database.php';
  
  $conn = new mysqli($host,$username,$password,$db);
  
  if($conn->connect_error){
    die("connection failed!");
    exit;
    }
  //========================================================= 
  date_default_timezone_set("Asia/Dhaka");
$now         = new DateTime();
$currentTime = $now->format("Y-m-d H:i:s");


  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["button1"])) {

    $s_id     = $_POST["studentId"] ?? null;
    $s_vote   = $_POST["vote"] ?? null;
    $s_reason = $_POST["reason"] ?? null;
    $s_opinion = $_POST["opinion"] ?? null;

    if ($s_id && $s_vote && $s_reason && $s_opinion && $role) {
        $stmt = $conn->prepare("INSERT INTO student (student_id, role, vote, reason, opinion,submitted_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $s_id, $role, $s_vote, $s_reason, $s_opinion, $currentTime);
        
        try {
            if ($stmt->execute()) {
                // Success message for users 
                $successMessage = "Your response has been recorded. Thank you!";
                header("Location: success.php");
                exit;
            } else {
                // Log the error instead of showing it
                error_log("Database insert failed: " . $stmt->error);
                $errorMessage = "Something went wrong while saving your response. Please try again later.";
            }
        } catch (Exception $e) {
            error_log("Exception during DB insert: " . $e->getMessage());
            $errorMessage = "A system error occurred. Please try again later.";
        }
        

        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="form">

 <main>
 <div class="container">
    <h1>UIU Opinion Hub</h1>
    <?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
 <!-- Student & Alumni Fields -->
      <div id="student-alumni-fields" class="form-section">
        <div class="form-group">
          <label for="studentId">Student ID:</label>
          <input type="text" id="studentId" name="studentId" placeholder="Enter your ID" maxlength="10" pattern="[A-Za-z0-9]+" title="Only alphanumeric characters allowed">
        </div>

        <div class="form-group">
          <label for="vote-student">Your Vote:</label>
          <select id="vote-student" name="vote" required>
            <option value="">-- Select Option --</option>
            <option value="both">Agree with resignation of Kashem Sir and Huda Sir</option>
            <option value="kashem">Only Kashem Sir</option>
            <option value="huda">Only Huda Sir</option>
          </select>
        </div>

        <div class="form-group">
          <label for="reason-student">Reason for Your Vote:</label>
          <textarea id="reason-student" name="reason" rows="3" placeholder="Explain your vote..." maxlength="500"></textarea>
        </div>

        <div class="form-group">
          <label for="opinion-student">How can we resolve current issues:</label>
          <textarea id="opinion-student" name="opinion" rows="3" placeholder="State the issue and possible solution..." maxlength="500"></textarea>
        </div>
      </div>
      <label for='button1'></label>
         <button type="submit" id="button1" name="button1">Submit</button>
    </form>
    <a href = "role.php" class="back-link">Wrong role? Back to Role Selection</a>
  </div>
 </main>
 
</body>
</html>