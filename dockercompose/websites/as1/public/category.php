<?php
session_start();
include("database.php");
$categories = null;
$category_name = '';

if (isset($_GET['category'])) {
    $pdo = connectToDatabase();
    $category_id = $_GET['category'];
    $sql = "SELECT a.*, c.category_name FROM auction a INNER JOIN category c ON a.car_category_id = c.category_id WHERE a.car_category_id = :category_id ORDER BY a.auction_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get category name even if there are no auctions
    if (empty($categories)) {
        $sql = "SELECT category_name FROM category WHERE category_id = :category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($category) {
            $category_name = $category['category_name'];
        }
    } else {
        $category_name = $categories[0]['category_name'];
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="carbuy.css" />
</head>
<body>
    <?php include "header.php"; ?>

<main>
    <h1>Category: <?php echo htmlspecialchars($category_name); ?></h1>
    <ul class="carList">
    <?php
        if (!empty($categories)) {
            foreach ($categories as $category) {
                echo '<li>';
                echo '<img src="./images/'. htmlspecialchars($category['car_image']) .'" alt="'. htmlspecialchars($category['car_model']) . '">';
                echo '<article>';
                echo '<h2>' . htmlspecialchars($category['car_model']) . ' ' . htmlspecialchars($category['car_make']) . '</h2>';
                echo '<h3>' . htmlspecialchars($category['category_name']) . '</h3>';
                echo '<p>' . htmlspecialchars($category['car_description']) . '</p>';
                echo '<p class="price">Current bid: £' . number_format($category['amount'], 2) . '</p>';
                echo '<a href="auction.php?auction='. htmlspecialchars($category['auction_id']) .'" class="more auctionLink">More &gt;&gt;</a>';
                echo '</article>';
                echo '</li>';
            }
        } else {
            echo '<li>No auctions available in this category.</li>';
        }
    ?>
    </ul>
</main>
    
</body>
</html>
