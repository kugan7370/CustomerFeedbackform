<?php
session_start();
include 'db.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Fetch user details if logged in
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT email, profileImage FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    // Fetch order count for the user
    $stmtCount = $conn->prepare("SELECT COUNT(*) AS order_count FROM purchased WHERE userId = ?");
    $stmtCount->execute([$userId]);
    $orderCount = $stmtCount->fetchColumn();
} else {
    $orderCount = 0; 
}
?>
<link rel="stylesheet" href="css/navbar.css">

<nav class="navbar">
    <div class="navbar-container">
        <a href="products.php" class="nav-link">Products</a>
        <?php if ($isLoggedIn): ?>
            <a href="purchaseList.php" class="nav-link">Orders 
                <?php if ($orderCount > 0): ?>
                    <span class="order-count"><?php echo $orderCount; ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <div class="user-info">
                <img src="<?php echo $user['profileImage']; ?>" alt="User profileImage" class="user-profileImage">
                <span class="user-name"><?php echo htmlspecialchars($user['email']); ?></span>
                <a href="logout.php" class="nav-link logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <div class="user-info">
                <a href="login.php" class="nav-link">Login</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
