<?php
// session_start();
include 'db.php';
include 'navbar.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch all purchased products for the logged-in user
$stmt = $conn->prepare("
    SELECT products.id, products.name, products.description, products.image, products.price, purchased.purchase_date 
    FROM purchased 
    JOIN products ON purchased.productId = products.id 
    WHERE purchased.userId = ?
    ORDER BY purchased.purchase_date DESC
");
$stmt->execute([$userId]);
$purchases = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchased Products</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* padding: 20px; */
            background-color: #f8f9fa;
        }
        /* Container Styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header and Button Styles */
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-logout {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #d9534f;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        /* Row and Column Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col {
            flex: 1 1 22%;
            max-width: 22%;
            box-sizing: border-box;
        }

        /* Card Styles */
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            padding: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 10px 0;
        }

        .card-title {
            font-size: 18px;
            color: #333;
            margin: 0;
        }

        .card-text {
            color: #555;
            font-size: 14px;
            margin: 8px 0;
        }

        .purchase-date {
            font-size: 12px;
            color: #888;
        }
        .btn-primary {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: auto;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .col {
                flex: 1 1 45%;
                max-width: 45%;
            }
        }

        @media (max-width: 768px) {
            .col {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchased Products</h1>
        <div class="row">
            <?php if (count($purchases) > 0) { ?>
                <?php foreach ($purchases as $purchase) { ?>
                    <div class="col">
                        <div class="card">
                                <img src="<?php echo $purchase['image']; ?>" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($purchase['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($purchase['description']); ?></p>
                                <p class="card-text">Price: $<?php echo htmlspecialchars($purchase['price']); ?></p>
                                <p class="purchase-date">Purchased on: <?php echo date("F j, Y", strtotime($purchase['purchase_date'])); ?></p>
                                <a href="feedback.php?product_id=<?php echo $purchase['id']; ?>" class="btn-primary">Leave Feedback</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No purchases found.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
