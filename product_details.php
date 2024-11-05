<?php
// session_start();
include 'db.php';
include 'navbar.php'; 

$product_id = $_GET['product_id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Get feedback count and average rating
$count_stmt = $conn->prepare("SELECT COUNT(*) AS feedback_count, AVG(rating) AS average_rating FROM feedback WHERE productId = ?");
$count_stmt->execute([$product_id]);
$result = $count_stmt->fetch();
$feedback_count = $result['feedback_count'];
$average_rating = $result['average_rating'] ? round($result['average_rating'], 1) : 0; // Round to 1 decimal place if exists

$feedback_stmt = $conn->prepare("SELECT f.comment, f.rating, u.email FROM feedback f JOIN users u ON f.userId = u.id WHERE f.productId = ?");
$feedback_stmt->execute([$product_id]);
$feedbacks = $feedback_stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .product-container {
            display: flex;
            margin-bottom: 20px;
        }
        .product-image {
            max-width: 300px; 
            height: auto; 
            margin-right: 20px; 
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }
        .product-details {
            flex: 1; 
        }
        .feedback-section {
            margin-top: 20px;
        }
        .stars {
            color: gold; 
        }
        .feedback-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .feedback-card h5 {
            margin: 0;
        }
        .feedback-card small {
            color: #555;
        }
        .no-feedback {
            color: #777;
            font-style: italic;
            margin-top: 20px;
        }
.btn-primary {
    display: inline-block;
    padding: 8px 16px;
    background-color: #28a745; 
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #218838; 
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Product Container for Image and Details -->
        <div class="product-container">
            <!-- Display the product image -->
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">

            <!-- Product details section -->
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p>
                    <span class="stars">
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $average_rating ? '★' : '☆'; 
                        }
                        ?>
                    </span>
                    <?php echo htmlspecialchars($average_rating); ?>/<?php echo htmlspecialchars($feedback_count); ?>
                </p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>

                 <!-- Purchase button -->
                 <a href="purchase.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Purchase</a>
            </div>
        </div>

        <hr>
        <h2>Feedback</h2>
        <div class="feedback-section">
            <?php if (empty($feedbacks)) { ?>
                <p class="no-feedback">No feedback available for this product yet.</p>
            <?php } else {
                foreach ($feedbacks as $feedback) { ?>
                    <div class="feedback-card">
                        <h5>Rating: <?php echo htmlspecialchars($feedback['rating']); ?>/5</h5>
                        <p><?php echo htmlspecialchars($feedback['comment']); ?></p>
                        <p><small>By: <?php echo htmlspecialchars($feedback['email']); ?></small></p>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</body>
</html>
