<?php
session_start();

if(!isset($_SESSION['role'])){
    if($_SESSION['role']!="Faculty"){
    header("Location:role.php");
    exit;
}
}
$role = $_SESSION['role'];
 //==============DB Connection=============================     
  $host     = "localhost";
  $db       = "mysocialapp";
  $username = "root";
  $password = "";
  
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

    $s_name      = $_POST["name"] ?? null;
    $s_department = $_POST["department"] ?? null;
    $s_vote  = $_POST["vote"] ?? null;
    $s_reason = $_POST["reason"] ?? null;
    $s_opinion = $_POST["opinion"] ?? null;
    
    if ($s_name && $s_vote && $s_reason && $s_opinion && $role&&$s_department) {
        $stmt = $conn->prepare("INSERT INTO faculty (name,department, vote, reason, opinion,submitted_at,role) VALUES (?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("sssssss", $s_name,$s_department, $s_vote, $s_reason, $s_opinion, $currentTime, $role);
        
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
    <title>Faculty form</title>
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
 <!-- Faculty Fields -->
      <div id="faculty-fields" class="form-section">
        <div class="name">
          <label for="name">Faculty name:</label>
          <input type="text" id="name" name="name" placeholder="Enter your name" maxlength="20" pattern="[A-Za-z ]+" title="Only alphabets allowed">
        </div>

        <div    class = "form-group">
        <label  for   = "department-faculty">Your department:</label>
        <select id    = "vote-department" name = "department" required>
        <option value = "">-- Select Option --</option>
        <option value = "CSE">CSE</option>
        <option value = "EEE">EEE</option>
        <option value = "BBA">BBA</option>
        <option value = "Economics">Economics</option>
        <option value = "Pharmacy">Pharmacy</option>
        <option value = "CE">Civil Eng.</option>
        <option value = "GE">Gentical Eng.</option>
          </select>
        </div>

        <div class="form-group">
          <label for="vote-faculty">Your Vote:</label>
          <select id="vote-faculty" name="vote" required>
            <option value="">-- Select Option --</option>
            <option value="both">Agree with resignation of Kashem Sir and Huda Sir</option>
            <option value="kashem">Only Kashem Sir</option>
            <option value="huda">Only Huda Sir</option>
          </select>
        </div>

        <div class="form-group">
          <label for="reason-faculty">Reason for Your Vote:</label>
          <textarea id="reason-faculty" name="reason" rows="3" placeholder="Explain your vote..." maxlength="500"></textarea>
        </div>

        <div class="form-group">
          <label for="opinion-faculty">How can we resolve current issues:</label>
          <textarea id="opinion-faculty" name="opinion" rows="3" placeholder="State the issue and possible solution..." maxlength="500"></textarea>
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