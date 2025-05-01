<?php
$host     = 'localhost';
$dbname   = 'mysocialapp';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Step 1: Get total count of votes
$sqlTotal = "SELECT COUNT(*) as total FROM (
    SELECT vote FROM student
    UNION ALL
    SELECT vote FROM faculty
) as all_votes";

$resultTotal = $conn->query($sqlTotal);
$totalVotes  = $resultTotal->fetch_assoc()["total"];

// Step 2: Get counts per vote
$sql = "SELECT vote, COUNT(*) AS count FROM (
    SELECT vote FROM student
    UNION ALL
    SELECT vote FROM faculty
) as all_votes GROUP BY vote";

$result     = $conn->query($sql);
$dataPoints = array();

while($row = $result->fetch_assoc()){
    $percentage = (floatval($row["count"]) / $totalVotes) * 100;
    $dataPoints[] = array(
        "label" => $row["vote"],
        "y"     => round($percentage, 2)
    );
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset = "UTF-8">
  <meta name    = "viewport" content = "width=device-width, initial-scale=1.0">
  <title>Vote Results</title>
  <link rel  = "stylesheet" href = "style.css">
  <script src = "https://cdn.canvasjs.com/canvasjs.min.js" defer></script>
  <script defer>
    window.onload = function () {
      var chart = new CanvasJS.Chart("chartContainer", {
        theme           : "light2",
        animationEnabled: true,
        title           : {
          text: "What Everyone Thinks"
        },
        data: [{
          type                : "pie",
          indexLabel          : "{label}: {y}%",
          yValueFormatString  : "#,##0.00\"%\"",
          indexLabelPlacement : "inside",
          indexLabelFontColor : "#36454F",
          indexLabelFontSize  : 18,
          indexLabelFontWeight: "bolder",
          showInLegend        : true,
          legendText          : "{label}",
          dataPoints          : <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
      });
      chart.render();
    };
  </script>
</head>
<body class="vote-page">

<header>
  <nav>
    <ul>
      <li><a href="home.php">UIU OPINION HUB</a></li>
    </ul>
    <ul>
      <li><a href="role.php">🔙 Role Selection</a></li>
      <li><a href="vote.php">See votes</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="chart-section">
    <h2 class="chart-title">Vote Distribution</h2>
    <div id="chartContainer" aria-label="Pie chart showing vote distribution"></div>
  </section>
</main>

<footer>
  <p>&copy; 2025 UIU Opinion Hub. All rights reserved.</p>
  <a href="role.php">Back to Role Selection</a>
</footer>

</body>
</html>
