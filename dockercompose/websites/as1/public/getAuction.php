<?php
include("database.php");

function getAuction($auction_id) {
    $auction = null;

    try {
        // Create a new PDO instance
        $pdo = connectToDatabase();

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to fetch auction data by ID
        $stmt = $pdo->prepare("SELECT a.*, c.category_name, u.name
                                FROM auction a 
                                INNER JOIN category c ON a.car_category_id = c.category_id 
                                INNER JOIN users u ON a.user_id = u.user_id 
                                WHERE a.auction_id = :auction_id");

        // Bind parameter
        $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the row
        $auction = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Connection failed: " . $e->getMessage();
    }

    return $auction;
}

// Example usage:
// $auction_id = 123; // Replace with the actual auction ID
// $auction = getAuction($auction_id);
// print_r($auction);
?>
