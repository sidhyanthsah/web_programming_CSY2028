<?php


function getReviewsByAuctionId($auction_id) {
    $reviews=null;
    try {
        // Connect to the database
        $pdo = connectToDatabase();

        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to fetch reviews along with user data for the given auction_id
        $stmt = $pdo->prepare("SELECT r.*, u.name AS user_name
                               FROM review r
                               INNER JOIN users u ON r.user_id = u.user_id
                               WHERE r.auction_id = :auction_id");

        // Bind auction_id parameter
        $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch all review data along with user data
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $reviews;

    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
        return false; // Return false or handle the error accordingly
    }

}


