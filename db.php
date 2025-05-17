<?php
$conn = new mysqli("localhost", "root", "", "recipe",3307); // Change 'recipe_hub' to 'recipe'

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
