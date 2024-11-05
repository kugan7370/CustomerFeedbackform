<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $userId = $_SESSION['user_id'];

    // Insert the purchase record
    $stmt = $conn->prepare("INSERT INTO purchased (productId, userId) VALUES (?, ?)");
    if ($stmt->execute([$productId, $userId])) {
        echo "<script>alert('Product purchased successfully!'); window.location.href = 'products.php';</script>";
    } else {
        echo "<script>alert('Error purchasing product. Please try again.'); window.location.href = 'products.php';</script>";
    }
} else {
    header("Location: products.php");
}
?>
