<?php
session_start();
include("database.php");
if(!isset($_SESSION["user_id"])){
    header("Location: index.php?login_required=true");
    exit; 
}
$bid = $_POST['bid'];
$auction_id = htmlspecialchars($_GET['auction']);
$user_id = $_SESSION['user_id'];

try {
    // Connect to the database
    $pdo = connectToDatabase();

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to insert bid data into the bid table
    $stmt = $pdo->prepare("INSERT INTO bid (user_id, auction_id, amount) VALUES (:user_id, :auction_id, :amount)");

    // Bind parameters
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt->bindParam(':amount', $bid, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();


    header("Location: auction.php?auction=$auction_id");


} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
