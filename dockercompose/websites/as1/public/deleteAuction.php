<?php
include("database.php");

// Check if auction ID is provided in the request parameters
if(isset($_GET['auction']) && !empty($_GET['auction'])) {
    $auction_id = $_GET['auction'];

    // Check if the auction ID is valid (e.g., numeric and exists in the database)
    if(!isValidAuctionId($auction_id)) {
        // Handle invalid auction ID, perhaps redirect to an error page
        header("Location: index.php");
        exit;
    }

    // Delete rows from related tables (review and bid) first
    $pdo = connectToDatabase();
    
    // Delete rows from the review table
    $sql_review = "DELETE FROM review WHERE auction_id = :auction_id";
    $stmt_review = $pdo->prepare($sql_review);
    $stmt_review->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt_review->execute();

    // Delete rows from the bid table
    $sql_bid = "DELETE FROM bid WHERE auction_id = :auction_id";
    $stmt_bid = $pdo->prepare($sql_bid);
    $stmt_bid->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt_bid->execute();

    // Now, delete the auction from the database
    $sql_delete_auction = "DELETE FROM auction WHERE auction_id = :auction_id";
    $stmt_delete_auction = $pdo->prepare($sql_delete_auction);
    $stmt_delete_auction->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt_delete_auction->execute();

    // Redirect to a success page or any other desired action after deletion
    header("Location: yourAuction.php");
    exit;
} else {
    // Handle the case where auction ID is not provided
    header("Location: index.php");
    exit;
}

// Function to validate auction ID (replace this with your own validation logic)
function isValidAuctionId($auction_id) {
    // Implement your validation logic here (e.g., check if the auction ID exists in the database)
    // Return true if valid, false otherwise
    // Example: return is_numeric($auction_id);
    return true; // Placeholder
}
