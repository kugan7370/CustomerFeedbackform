<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$detailsSaved = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (isset($_POST['save'])) {
        $conn->query("INSERT INTO customers (Name, Email, ContactInfo) VALUES ('$name', '$email', '$contact')");
        $message = "Customer details saved successfully!";
        $detailsSaved = true;
    } elseif (isset($_POST['update'])) {
        $conn->query("UPDATE customers SET Name='$name', Email='$email', ContactInfo='$contact' WHERE CustomerID='$id'");
        $message = "Customer details updated successfully!";
        $detailsSaved = true;
    } elseif (isset($_POST['delete'])) {
        $conn->query("DELETE FROM customers WHERE CustomerID='$id'");
        $message = "Customer details deleted successfully!";
        $detailsSaved = false; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Form</title>
    <style>
      
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
        }
        button {
            flex: 1;
            padding: 0.7rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        button[name="save"] {
            background-color: #28a745;
            color: #fff;
        }
        button[name="save"]:hover {
            background-color: #218838;
        }
        button[name="update"] {
            background-color: #ffc107;
            color: #fff;
        }
        button[name="update"]:hover {
            background-color: #e0a800;
        }
        button[name="delete"] {
            background-color: #dc3545;
            color: #fff;
        }
        button[name="delete"]:hover {
            background-color: #c82333;
        }
        button[name="product"] {
            background-color: #007bff;
            color: #fff;
            display: none; 
        }
        button[name="product"].active {
            display: block; 
        }
        .message {
            color: green;
            text-align: center;
            margin-top: 1rem;
            font-weight: bold;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 1rem;
            }
            button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Customer Form</h2>
        <form method="post">
            <input type="hidden" name="id">
            <label>Customer ID:</label>
            <input type="text" name="id">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Contact Info:</label>
            <input type="tel" name="contact" maxlength="10" pattern="\d{10}" title="Please enter a 10-digit contact number" required>
            <div class="button-group">
                <button type="submit" name="save">Save</button>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
                <button type="button" name="product" onclick="window.location.href='product.php';" 
                        class="<?php echo $detailsSaved ? 'active' : ''; ?>">Product</button>
            </div>
        </form>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
    <script>
       
        const productButton = document.querySelector("button[name='product']");
        <?php if ($detailsSaved): ?>
            productButton.classList.add("active");
        <?php endif; ?>
    </script>
</body>
</html>
