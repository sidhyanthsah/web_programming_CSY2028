<?php
include("database.php");
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php?login_required=true");
    exit; 
} 

$user_id = $_SESSION["user_id"];
$pdo = connectToDatabase();
$sql = "SELECT a.*, c.category_name FROM auction a INNER JOIN category c ON a.car_category_id = c.category_id WHERE a.user_id = :user_id ORDER BY a.auction_id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Auctions</title>
    <link rel="stylesheet" href="carbuy.css" />
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <h1>Your Auctions</h1>
        <ul class="carList">
            <?php
            foreach ($categories as $category) {
                echo '<li>';
                echo '<img src="./images/' . $category['car_image'] . '" alt="' . $category['car_model'] . '">';
                echo '<article>';
                echo '<h2>' . $category['car_model'] . ' ' . $category['car_make'] . '</h2>';
                echo '<h3>' . $category['category_name'] . '</h3>';
                echo '<p>' . $category['car_description'] . '</p>';
                echo '<p class="price">Current bid: £' . number_format($category['amount'], 2) . '</p>';
                // Edit and delete buttons
                echo '<a href="editAuction.php?auction=' . $category['auction_id'] . '" class="more">Edit</a>';
                echo '<a href="deleteAuction.php?auction=' . $category['auction_id'] . '" style="color:red" class="more">Delete</a>';
                echo '</article>';
                echo '</li>';
            }
            ?>
        </ul>
    </main>
</body>
</html>
