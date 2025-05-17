<!-- grocery_stores.php -->
<?php
$conn = new mysqli("localhost", "root", "", "recipe",3307);
$result = $conn->query("SELECT * FROM grocery_stores");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Grocery Store</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background:rgb(246, 231, 182);
      margin: 0;
      padding: 0;
    }
    .store-list {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      padding: 40px;
    }
    .store-item {
      display: block;
      width: 200px;
      margin: 10px;
      padding: 20px;
      background-color: #ff6a00;
      color: white;
      text-align: center;
      font-size: 18px;
      text-decoration: none;
      border-radius: 8px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .store-item:hover {
      background-color: #e65900;
      transform: translateY(-5px);
    }
  </style>
</head>
<body>
  <div class="store-list">
    <?php while ($row = $result->fetch_assoc()): ?>
      <a href="grocery_menu.php?store_id=<?= $row['id'] ?>" class="store-item">
        <?= $row['name'] ?>
      </a>
    <?php endwhile; ?>
  </div>
</body>
</html>