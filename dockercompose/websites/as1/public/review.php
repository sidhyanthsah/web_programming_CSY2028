<?php
include("database.php");
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: index.php?login_required=true");
    exit; 
}


// Get auction ID from the URL
$auction_id = htmlspecialchars($_GET['auction']);

// Get review text from the form submission
$review = $_POST['reviewtext'];

// Get user ID from the session
$user_id=$_SESSION['user_id'];

try {
    // Connect to the database
    $pdo = connectToDatabase();

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to insert review into the review table
    $stmt = $pdo->prepare("INSERT INTO review (user_id, auction_id, user_review) VALUES (:user_id, :auction_id, :review)");

    // Bind parameters
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt->bindParam(':review', $review, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Redirect back to the auction page with the same auction ID
    header("Location: auction.php?auction=$auction_id");
    exit;

} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
