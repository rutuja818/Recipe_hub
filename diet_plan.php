<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe";
$port = 3307; // Correct MySQL port
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = ""; // Default value

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $health_issue = $_POST['health_issue'];

    // Retrieve diet plan
    $sql = "SELECT diet_plan FROM diet_plans WHERE health_issue = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $health_issue);
    $stmt->execute();
    $stmt->bind_result($diet_plan);
    $stmt->fetch();
    $stmt->close();
    
    if (!empty($diet_plan)) {
        $result = $diet_plan;

        // ✅ Save into diet_history table
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];

            $insert = "INSERT INTO diet_history (user_id, health_condition, diet_plan_name)
                       VALUES ('$user_id', '$health_issue', '$diet_plan')";
            $conn->query($insert);
        }
    } else {
        $result = "No diet plan available for this health issue.";
    }
}
$conn->close();
include 'header.php'; 
?>

<!-- Redirect back to the HTML page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan</title>
    <link rel="stylesheet" href="style diet.css">
</head>
<body>

<div class="diet-plan-section">
    <div class="container">
        <h2>Select Your Health Issue</h2>
        
        <form method="POST" action="diet_plan.php">
            <select name="health_issue" required>
                <option value="">--Select Health Issue--</option>
                <option value="High Blood Pressure">High Blood Pressure (BP)</option>
                <option value="Diabetes">Diabetes (Sugar)</option>
                <option value="Thyroid Issues">Thyroid Issues</option>
                <option value="Kidney Issues">Kidney Issues</option>
                <option value="Heart Disease">Heart Disease</option>
                <option value="Anemia">Anemia</option>
            </select>
            <button type="submit">Get Diet Plan</button>
        </form>

        <?php if (!empty($result)): ?>
            <div class="diet-result">
                <h3>Recommended Diet Plan:</h3>
                <p><?= nl2br(htmlspecialchars($result)) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
