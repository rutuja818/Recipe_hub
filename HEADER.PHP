<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">Recipe Hub</div>
        <nav class="main-nav">
            <a href="home_page.php">Home</a>
            <a href="diet_plan.php">Diet Plan</a>
            <a href="submit_recipe.html">Submit Recipe</a>
            <a href="search.html">Add Ingredient</a>
            <a href="grocery_home.php">Grocery Order</a>
            <a href="history.php">History</a>
        </nav>
        <div class="user-actions">
            <?php if(isset($_SESSION["user_id"])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="user_login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>