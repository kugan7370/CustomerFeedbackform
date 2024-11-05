<?php
include 'db.php';
include 'navbar.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $userId = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO feedback (productId, userId, comment, rating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$productId, $userId, $comment, $rating]);

    echo "Feedback submitted!";
}

$product_id = $_GET['product_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Feedback</title>
    <link rel="stylesheet" href="css/feedback.css"> 
</head>
<body>
    <div class="mainContainer">
    <div class="container">
        <h1>Leave Feedback</h1>
        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <div class="form-group">
                <label>Comment</label>
                <textarea name="comment" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Rating</label>
                <input type="number" name="rating" min="1" max="5" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
    </div>
</body>
</html>
