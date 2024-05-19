<?php


function getBid($auction_id){
    try {
        // Create a new PDO instance
        $pdo = connectToDatabase();

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to fetch the highest bid amount for the given auction ID
        $stmt = $pdo->prepare("SELECT MAX(amount) AS max_bid FROM bid WHERE auction_id = :auction_id");

        // Bind parameter
        $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the maximum bid amount
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the maximum bid amount
        return $result['max_bid'];

    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }

}


