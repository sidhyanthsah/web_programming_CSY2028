<?php
// Assuming you have already established the database connection and the necessary functions

// Check if category parameter is set in the URL
include("database.php");
$pdo=connectToDatabase();
$title=null;
// if (isset($_GET['category'])) {
//     $category_id = $_GET['category'];
//     $sql = "SELECT a.*, c.category_name FROM auction a INNER JOIN category c ON a.car_category_id = c.category_id WHERE a.car_category_id = :category_id ORDER BY a.auction_id DESC LIMIT 5";
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
// } 
// Check if search parameter is set in the URL
if (isset($_GET['search'])) {
	$title="Search Results";
    $search_string = '%' . $_POST['search'] . '%';
    $sql = "SELECT a.*, c.category_name FROM auction a INNER JOIN category c ON a.car_category_id = c.category_id WHERE a.car_model LIKE :search_string";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':search_string', $search_string, PDO::PARAM_STR);
} 
// Default: Fetch latest 5 cars
else {
	$title="Latest Car Listings";
    $sql = "SELECT a.*, c.category_name FROM auction a INNER JOIN category c ON a.car_category_id = c.category_id ORDER BY a.auction_id DESC LIMIT 5";
    $stmt = $pdo->prepare($sql);
}

// Execute the statement
$stmt->execute();

// Fetch all rows
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now you have $auctions array containing the required data based on the parameters passed in the URL
session_start();
?>




<!DOCTYPE html>
<html>
	<head>
		<title>Carbuy Auctions</title>
		<link rel="stylesheet" href="carbuy.css" />
	</head>

	<body>

		<?php include 'header.php' ?>
		<img src="banners/1.jpg" alt="Banner" />

		<main>
			<h1><?php echo $title  ?></h1>
			
			
	
			<ul class="carList">
				<?php
				foreach ($auctions as $auction) {
					echo '<li>';
					echo '<img src="./images/'. $auction['car_image'].'" alt="'.$auction['car_model'] . '">';
					echo '<article>';
					echo '<h2>' . $auction['car_model'] . ' ' . $auction['car_make'] . '</h2>';
					// Assuming you have a separate table for car categories
					echo '<h3>' .$auction['category_name'].'</h3>';
					echo '<p>' . $auction['car_description'] . '</p>';
					echo '<p class="price">Current bid: £' . number_format($auction['amount'], 2) . '</p>';
					echo '<a href="auction.php?auction='.$auction['auction_id'].'" class="more auctionLink">More &gt;&gt;</a>';
					echo '</article>';
					echo '</li>';
				}

				?>
			</ul>

			<hr />

			

					

<?php include 'footer.php' ?>

			
		</main>
	</body>
</html>