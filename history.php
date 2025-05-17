<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "recipe", 3307);

// Start session to get user ID
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to view your history.'); window.location.href='login_page.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's diet history
$sql = "SELECT * FROM diet_history WHERE user_id = '$user_id' ORDER BY date_viewed DESC";
$result = $conn->query($sql);

// Fetch user's recipe history
$sql_recipe_history = "SELECT r.title, r.ingredients, r.instructions, rh.submission_date 
                       FROM recipe_history rh 
                       JOIN recipes r ON rh.recipe_id = r.id 
                       WHERE rh.user_id = '$user_id' 
                       ORDER BY rh.submission_date DESC";
$result_recipe_history = $conn->query($sql_recipe_history);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Diet Plan and Recipe History</title>
    <style>
        body {
            background-color: rgb(3, 3, 3);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ff6600;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #575757;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }

        h2 {
            color: rgb(239, 116, 22);
            margin-bottom: 20px;
        }

        .diet-card {
            background-color: #ffffff;
            border: 1px solid rgb(230, 236, 70);
            box-shadow: 0 4px 8px rgba(2, 2, 2, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            width: 90%;
            max-width: 600px;
        }

        .diet-card h3 {
            color: rgb(11, 6, 2);
            margin-bottom: 10px;
        }

        .diet-card p {
            margin: 8px 0;
            color: #424242;
        }

        .diet-card small {
            color: #757575;
        }

        hr {
            width: 90%;
            border: 1px solid rgb(224, 239, 60);
            margin: 40px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Recipe Hub</h1>
    <p>Track your health and culinary journey!</p>
</header>

<nav>
<a href="home_page.php">Home</a>
            <a href="diet_plan.php">Diet Plan</a>
            <a href="submit_recipe.html">Submit Recipe</a>
            <a href="search.html">Add Ingredient</a>
            <a href="grocery_home.php">Grocery Order</a>
            <a href="history.php">History</a>
            

    <a href="logout.php" style="float:right;">Logout</a>
</nav>

<div class="container">
    <h2>Your Diet Plan History</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='diet-card'>";
            echo "<h3>Health Condition: " . htmlspecialchars($row['health_condition']) . "</h3>";
            echo "<p><strong>Diet Plan:</strong><br>" . nl2br(htmlspecialchars($row['diet_plan'])) . "</p>";
            echo "<p><small>Viewed on: " . $row['date_viewed'] . "</small></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No diet plans viewed yet.</p>";
    }
    ?>

    <hr>
    <h2>Your Submitted Recipes</h2>

    <?php
    if ($result_recipe_history->num_rows > 0) {
        while ($row = $result_recipe_history->fetch_assoc()) {
            echo "<div class='diet-card'>";
            echo "<h3>Recipe Title: " . htmlspecialchars($row['title']) . "</h3>";
            echo "<p><strong>Ingredients:</strong><br>" . nl2br(htmlspecialchars($row['ingredients'])) . "</p>";
            echo "<p><strong>Instructions:</strong><br>" . nl2br(htmlspecialchars($row['instructions'])) . "</p>";
            echo "<p><small>Submitted on: " . $row['submission_date'] . "</small></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No recipes submitted yet.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
