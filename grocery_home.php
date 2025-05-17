<?php
session_start(); // Only added this line at top
$conn = new mysqli("localhost", "root", "", "recipe", 3307);
$result = $conn->query("SELECT * FROM grocery_stores");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<header>
        <div class="logo">Recipe Hub</div>
        <nav>
            <a href="home_page.php">Home</a>
            <a href="diet_plan.php">Diet Plan</a>
            <a href="submit_recipe.html">Submit Recipe</a>
            <a href="search.html">Add Ingredient</a>
            <a href="grocery_home.php">Grocery Order</a>
            <a href="history.php">History</a>
            
        </nav>
        <div class="search-icons">
            <i class="fa-solid fa-search"></i>
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

  <meta charset="UTF-8">
  <title>Grocery Stores</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background:rgb(249, 240, 225);
      padding: 40px;
      text-align: center;
      margin-top: 80px; /* Added to prevent header overlap */
    }
    h1 {
      color: #ff6a00;
      margin-bottom: 30px;
    }
    .store-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .store-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      width: 220px;
      padding: 25px;
      transition: transform 0.3s;
    }
    .store-card:hover {
      transform: translateY(-5px);
    }
    .store-name {
      font-size: 20px;
      color: #333;
      margin-bottom: 15px;
    }
    .view-btn {
      background: #ff6a00;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      text-decoration: none;
    }
    .view-btn:hover {
      background: #e65900;
    }
    
    /* Add these header styles if not in your style.css */
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: white;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      font-weight: bold;
      color: #ff6a00;
      font-size: 1.5rem;
    }
    nav {
      display: flex;
      gap: 20px;
    }
    .search-icons {
      display: flex;
      gap: 15px;
    }
  </style>
</head>
<body>
  <h1>Select a Grocery Store</h1>
  <div class="store-container">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="store-card">
        <div class="store-name"><?= $row['name'] ?></div>
        <a href="grocery_menu.php?store_id=<?= $row['id'] ?>" class="view-btn">View Items</a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>