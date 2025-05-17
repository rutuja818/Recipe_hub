
<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); // IST timezone

if (!isset($_SESSION['grocery_cart']) || !isset($_SESSION['store_id']) || !isset($_SESSION['grocery_total'])) {
    echo "No items in cart. Go back and add items.";
    exit;
}

$items = $_SESSION['grocery_cart'];
$store_id = $_SESSION['store_id'];
$total = $_SESSION['grocery_total'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "recipe", 3307);

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // Calculate the delivery time (30 minutes from now)
    $delivery_time = date("H:i:s", strtotime("+30 minutes"));
    $formatted_time = date("h:i A", strtotime($delivery_time)); // Display the time in AM/PM format

    // Insert the order into the 'orders' table
   $query = "INSERT INTO orders (user_id, store_id, total_amount, address, delivery_time, phone)
              VALUES (1, $store_id, $total, '$address', '$delivery_time', '$phone')";

    if ($conn->query($query) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert items into the 'order_items' table
        foreach ($items as $item) {
            $conn->query("INSERT INTO order_items (order_id, item_id, quantity) 
                          VALUES ($order_id, {$item['id']}, {$item['qty']})");
        }

        // Clear session data
        unset($_SESSION['grocery_cart']);
        unset($_SESSION['store_id']);
        unset($_SESSION['grocery_total']);
        
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Success</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    text-align: center;
                }
                .message-box {
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                }
                .message-box h2 {
                    color: #ff6a00;
                    margin-bottom: 15px;
                }
                .message-box p {
                    color: #000;
                    font-size: 18px;
                }
                .message-box button {
                    background: #ff6a00;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 18px;
                }
                .message-box button:hover {
                    background-color: #e65900;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                <h2>Order Placed Successfully!</h2>
                <p>Expected Delivery by: <strong><?= $formatted_time ?></strong></p>
                <form action="home_page.php" method="get">
                    <button type="submit">Go Back to Home</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "Error: " . $conn->error;
        exit;
    }
}
?>

<!-- Checkout form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; padding: 30px; }
        .checkout-form {
            background: #fff; max-width: 500px; margin: auto; padding: 30px;
            border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #ff6a00; }
        textarea, input[type="text"] {
            width: 100%; padding: 10px; border-radius: 6px;
            border: 1px solid #ccc; margin-bottom: 20px; font-size: 16px;
        }
        input[type="submit"] {
            width: 100%; padding: 10px;
            background: #ff6a00; color: white; border: none;
            border-radius: 6px; font-size: 18px; cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #e65900;
        }
    </style>
</head>
<body>
    <form method="post" class="checkout-form">
        <h2>Checkout</h2>
        <label for="address">Delivery Address:</label><br>
        <textarea name="address" required></textarea><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" name="phone" required><br>

        <input type="submit" value="Proceed to Place Order">
    </form>
</body>
</html>
