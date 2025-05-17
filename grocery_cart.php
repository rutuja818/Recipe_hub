<?php
session_start();

$store_id = $_POST['store_id'];
$qtys = $_POST['qty'];
$total = 0;
$items = [];

$conn = new mysqli("localhost", "root", "", "recipe", 3307);

foreach ($qtys as $item_id => $qty) {
  if ($qty > 0) {
    $res = $conn->query("SELECT * FROM grocery_items WHERE id = $item_id AND store_id = $store_id");
    if ($res->num_rows > 0) {
      $item = $res->fetch_assoc();
      $subtotal = $item['price'] * $qty;
      $total += $subtotal;

      $items[] = [
        'id' => $item_id,
        'name' => $item['item_name'],
        'qty' => $qty,
        'price' => $item['price'],
        'subtotal' => $subtotal
      ];
    }
  }
}

// Save to session
$_SESSION['grocery_cart'] = $items;
$_SESSION['store_id'] = $store_id;
$_SESSION['grocery_total'] = $total;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; }
    .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h2 { text-align: center; color: #ff6a00; }
    ul { list-style: none; padding: 0; }
    li { padding: 10px 0; border-bottom: 1px solid #ddd; }
    .total { font-size: 20px; font-weight: bold; text-align: right; margin-top: 20px; }
    .checkout-btn {
      display: block;
      text-align: center;
      background-color: #ff6a00;
      color: white;
      padding: 10px 20px;
      margin: 20px auto 0;
      border-radius: 5px;
      text-decoration: none;
      font-size: 18px;
    }
    .checkout-btn:hover { background-color: #e65900; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Your Cart</h2>
    <ul>
      <?php foreach ($items as $item): ?>
        <li>
          <?= $item['name'] ?> (x<?= $item['qty'] ?>) - ₹<?= $item['subtotal'] ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="total">Total: ₹<?= $total ?></div>
    <a href="grocery_checkout.php" class="checkout-btn">Proceed to Checkout</a>
  </div>
</body>
</html>
