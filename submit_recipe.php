<?php
session_start(); // Must be at the very top

// Database Connection
$conn = new mysqli("localhost", "root", "", "recipe", 3307);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $ingredients = $conn->real_escape_string($_POST['ingredients']);
    $instructions = $conn->real_escape_string($_POST['instructions']);

    // Insert into recipes table
    $sql = "INSERT INTO recipes (title, ingredients, instructions) VALUES ('$title', '$ingredients', '$instructions')";

    if ($conn->query($sql) === TRUE) {
        $recipe_id = $conn->insert_id;
        $user_id = $_SESSION['user_id'];

        // Insert into recipe_history table
        $insert_history = "INSERT INTO recipe_history (user_id, recipe_id, submission_date) 
                         VALUES ('$user_id', '$recipe_id', NOW())";
        $conn->query($insert_history);

        echo "<script>alert('Recipe submitted successfully!'); window.location.href='home_page.php';</script>";
        exit(); // Important after redirect
    } else {
        echo "<script>alert('Error submitting recipe!'); window.history.back();</script>";
        exit(); // Important after redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Recipe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main class="submit-recipe-container">
        <h1>Submit Your Recipe</h1>
        <form method="POST">
            <div class="form-group">
                <label for="title">Recipe Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea id="ingredients" name="ingredients" rows="5" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="instructions">Instructions</label>
                <textarea id="instructions" name="instructions" rows="10" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Submit Recipe</button>
        </form>
    </main>
</body>
</html>