<?php
$conn = new mysqli("localhost", "root", "", "recipe", 3307);
$store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 1;
$result = $conn->query("SELECT * FROM grocery_items WHERE store_id = $store_id");
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grocery Menu</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #fff8f2;
      margin: 0;
      padding: 40px;
    }

    h2 {
      text-align: center;
      color: #ff6a00;
      margin-bottom: 20px;
    }

    table {
      margin: 0 auto;
      width: 80%;
      border-collapse: collapse;
      background-color: #ffffff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th {
      background-color: #ff6a00;
      color: white;
      padding: 15px;
    }

    td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    input[type="number"] {
      padding: 6px;
      border-radius: 4px;
      border: 1px solid #ccc;
      width: 60px;
    }

    input[type="submit"] {
      margin-top: 20px;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 10px 20px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #ff6a00;
    }

    .menu {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 40px;
    }

    .menu-item {
      background-color: #fff;
      width: 220px;
      padding: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .menu-item:hover {
      transform: translateY(-5px);
    }

    .menu-item p {
      font-weight: bold;
      color: black;
    }

    .menu-item input[type="submit"] {
      background-color: #ff6a00;
    }

    .menu-item input[type="submit"]:hover {
      background-color: black;
    }

  </style>
</head>
<body>

  <h2>Grocery Menu</h2>

  <!-- Table layout -->
  <form method="post" action="grocery_cart.php">
    <input type="hidden" name="store_id" value="<?= $store_id ?>">
    <table border="1">
      <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
      <?php foreach ($items as $row): ?>
        <tr>
          <td><?= $row['item_name'] ?></td>
          <td>₹<?= $row['price'] ?></td>
          <td><input type="number" name="qty[<?= $row['id'] ?>]" min="0" value="0"></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <input type="submit" value="Add to Cart">
  </form>
</body>
</html>
