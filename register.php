<?php
ob_start(); // Start output buffering
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $error = "Email already exists. Try another.";
    } else {
        $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $name, $email, $password);

        if ($insert->execute()) {
            // Redirect only after successful registration
            header("Location: user_login.php");
            exit();
        } else {
            $error = "Registration failed: " . $conn->error;
        }
    }

    $checkEmail->close();
    $insert->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Recipe Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fdfdfd;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .register-container input, .register-container button {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 12px;
            font-size: 14px;
        }
        .register-container input {
            border: 1px solid #ccc;
        }
        .register-container button {
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #218838;
        }
        .message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Recipe Hub</h2>
        <h2>Create Account</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="message"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php ob_end_flush(); // Flush output at the very end ?>
