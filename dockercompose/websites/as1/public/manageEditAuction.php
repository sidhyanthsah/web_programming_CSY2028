<?php
session_start();
include("database.php");
$auction_id=null;
$user_id = $_SESSION['user_id'];
if(isset($_GET['auction']) && !empty($_GET['auction'])) {
    $auction_id = $_GET['auction'];
}

if(isset($_POST['submit'])) {




    // Retrieve form data
    $car_model = $_POST['car_model'];
    $car_make = $_POST['car_make'];
    $car_description = $_POST['car_description'];
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $auction_end = $_POST['auction_end'];

    // Update auction in the database
    $sql = "UPDATE auction SET car_model = :car_model, car_make = :car_make, car_description = :car_description, car_category_id = :category_id, amount = :amount, auction_end = :auction_end, user_id = :user_id WHERE auction_id = :auction_id";
    $pdo=connectToDatabase();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':car_model', $car_model, PDO::PARAM_STR);
    $stmt->bindParam(':car_make', $car_make, PDO::PARAM_STR);
    $stmt->bindParam(':car_description', $car_description, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
    $stmt->bindParam(':auction_end', $auction_end, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to a success page or do any other actions as needed
    header("Location: auction.php?auction=" . $auction_id);
    exit;
}


