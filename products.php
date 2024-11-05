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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card img {
            object-fit: cover;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Product List</h1>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="card p-2">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                            <a href="feedback.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Leave Feedback</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
