<?php
include 'db.php';

$product_id = $_GET['product_id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

$feedback_stmt = $conn->prepare("SELECT f.comment, f.rating, u.email FROM feedback f JOIN users u ON f.userId = u.id WHERE f.productId = ?");
$feedback_stmt->execute([$product_id]);
$feedbacks = $feedback_stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $product['name']; ?></h1>
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <hr>
        <h2>Feedback</h2>
        <?php foreach ($feedbacks as $feedback) { ?>
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title">Rating: <?php echo $feedback['rating']; ?>/5</h5>
                    <p class="card-text"><?php echo $feedback['comment']; ?></p>
                    <p class="card-text"><small>By: <?php echo $feedback['email']; ?></small></p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
