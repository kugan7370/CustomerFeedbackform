<?php
include 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

 
    $check = $conn->query("SELECT * FROM login WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email already exists!";
    } else {
       
        $conn->query("INSERT INTO login (email, password) VALUES ('$email', '$password')");
        $_SESSION['loggedin'] = true;
        header("Location: customer.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 1rem;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #218838;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Register Form</h2>
        <form method="post">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>