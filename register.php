<?php
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profileImage = "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, contactNumber, password,profileImage) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$email, $contactNumber, $password,$profileImage])) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <div class="alert"><?php echo htmlspecialchars($error); ?></div> 
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contactNumber" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php" class="btn">Login</a></p>
        </div>

    </div>
</body>
</html>
