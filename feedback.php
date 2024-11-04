<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}


$message = "";
$detailsSaved = false;

$customer_id = $_SESSION['customer_id'] ?? null; 
$product_id = $_SESSION['product_id'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback_id = $_POST['feedback_id'] ?? null;
    $date = $_POST['date'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    if (isset($_POST['save'])) {
        $conn->query("INSERT INTO feedback (CustomerID, ProductID, FeedbackDate, Rating, Comments) VALUES ('$customer_id', '$product_id', '$date', '$rating', '$comments')");
        $message = "Feedback details saved successfully.";
        $detailsSaved = true;
    } elseif (isset($_POST['update'])) {
        $conn->query("UPDATE feedback SET FeedbackDate='$date', Rating='$rating', Comments='$comments' WHERE FeedbackID='$feedback_id'");
        $message = "Feedback details updated successfully.";
        $detailsSaved = true;
    } elseif (isset($_POST['delete'])) {
        $conn->query("DELETE FROM feedback WHERE FeedbackID='$feedback_id'");
        $message = "Feedback details deleted successfully.";
        $detailsSaved = false;
    }
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
    <style>
       
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
        }

        .form-container {
            background: #fff7ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 1.5rem;
            justify-content: center;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
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

        /* button[name="logout"] {
            background-color: #007bff;
            color: #fff;
        }
        button[name="logout"]:hover {
            background-color: #0056b3;
        } */

        .star-rating {
            direction: rtl; 
            display: flex;
            justify-content: center;
        }
        .star-rating input {
            display: none; 
        }
        .star-rating label {
            font-size: 40px; 
            color: lightgray; 
            cursor: pointer; 
        }
        .star-rating input:checked ~ label {
            color: gold; 
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
        .radio-group {
            margin-top: 20px;
        }
        .radio-group label {
            margin-right: 10px;
        }
        button[name="logout"] {
            background-color: #007bff;
            color: #fff;
            display: none; 
        }
        button[name="logout"].active {
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

       
        @media (max-width: 768px) {
            .form-container {
                width: 100%;
                padding: 15px;
            }
            button {
                flex: 1 1 45%;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 10px;
            }
            h2 {
                font-size: 1.5rem;
            }
            label, button {
                font-size: 0.9rem;
            }
        
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Feedback Form</h2>
        <form method="post">
            <input type="hidden" name="feedback_id">
            
            <label>Customer ID:</label>
            <input type="text" name="customer_id" value="<?php htmlspecialchars($customer_id)?>" required>
            
            <label>Product ID:</label>
            <input type="text" name="product_id" value="<?php htmlspecialchars($product_id)?>" required >
            
            <label>Date:</label>
            <input type="date" name="date" required>
            
            <label>Rating:</label>
            <div class="star-rating">
                <input type="radio" name="rating" value="5" id="star5" required>
                <label for="star5">★</label>
                <input type="radio" name="rating" value="4" id="star4">
                <label for="star4">★</label>
                <input type="radio" name="rating" value="3" id="star3">
                <label for="star3">★</label>
                <input type="radio" name="rating" value="2" id="star2">
                <label for="star2">★</label>
                <input type="radio" name="rating" value="1" id="star1">
                <label for="star1">★</label>
            </div>
            
        

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" rows="4" cols="50" required></textarea>
            <!-- <div class="radio-group">
                <label>Please give the comment</label>
                
                <label for="ratingExcellent"> <input type="radio" name="rating" value="excellent" id="ratingExcellent" required>Excellent</label>

               
                <label for="ratingGood"> <input type="radio" name="rating" value="good" id="ratingGood">Good</label>

                
                <label for="ratingAverage"><input type="radio" name="rating" value="average" id="ratingAverage">Average</label>

                
                <label for="ratingPoor"><input type="radio" name="rating" value="poor" id="ratingPoor">Poor</label>

                
                <label for="ratingTerrible"><input type="radio" name="rating" value="terrible" id="ratingTerrible">Terrible</label>
            </div> -->
            
            
            
            <div class="button-group">
                <button type="submit" name="save">Save</button>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
                <button type="button" name="logout" onclick="window.location.href='login.php';" 
                        class="<?php echo $detailsSaved ? 'active' : ''; ?>">logout</button>
            </div>
        </form>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
    <script>
   
        const productButton = document.querySelector("button[name='logout']");
        <?php if ($detailsSaved): ?>
            productButton.classList.add("active");
        <?php endif; ?>
    </script>
</body>
</html>
