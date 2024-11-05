<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
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

        .btn-primary {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: auto;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
        <h1>Product List</h1>
        <a href="logout.php" class="btn-logout">Logout</a>
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col">
                    <div class="card">
                    <a href="product_details.php?product_id=<?php echo $product['id']; ?>">
                            <img src="<?php echo $product['image']; ?>" alt="Product Image">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                            <a href="feedback.php?product_id=<?php echo $product['id']; ?>" class="btn-primary">Leave Feedback</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
