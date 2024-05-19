<?php
include("getAuction.php");
include("getbid.php");
include("getReview.php");
$auction=null;
$bid=null;
$reviews=null;
if(isset($_GET['auction']) && !empty($_GET['auction'])) {
    // Sanitize the input to prevent SQL injection
    $auction_id = htmlspecialchars($_GET['auction']);

    // Call the getAuction function to fetch the auction data
    $auction = getAuction($auction_id);
    $bid=getBid($auction_id);
    $reviews = getReviewsByAuctionId($auction_id);

} else {
    // Auction ID is not provided in the URL
   header("Location: index.php");
}



function calculateTimeLeft($endDateTime) {
    $now = new DateTime();
    $end = new DateTime($endDateTime);
    $interval = $now->diff($end);

    $days = $interval->format('%a');
    $hours = $interval->format('%h');
    $minutes = $interval->format('%i');

    if ($days > 0) {
        return "$days days $hours hours $minutes minutes";
    } elseif ($hours > 0) {
        return "$hours hours $minutes minutes";
    } elseif ($minutes > 0) {
        return "$minutes minutes";
    } else {
        return "Less than a minute";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $auction['car_model']  ?></title>
    <link rel="stylesheet" href="carbuy.css" />
</head>
<body>
    <?php include "header.php";  ?>
<main>
    <h1><?php  echo $auction['car_model'] ?></h1>
    <article class="car">
        <img src="./images/<?php echo $auction['car_image']; ?>" alt="<?php echo $auction['car_model']; ?>" style="height:375px;width:375px;">
        <section class="details">
            <h2><?php echo $auction['car_model'] . ' ' . $auction['car_make']; ?></h2>
            <h3><?php echo $auction['category_name']; ?></h3>
            <p>Auction created by <a href="#"><?php echo $auction['name']; ?></a></p>
            <p class="price">
    <?php if ($bid !== null): ?>
        Current bid: £<?php echo $bid; ?>
    <?php else: ?>
        No bid is done yet
    <?php endif; ?>
</p>
            <time>Time left: <?php echo calculateTimeLeft($auction['auction_end']); ?></time>
            <form action="bid.php?auction=<?= $auction['auction_id'] ?>" method="post" class="bid">
                <input type="text" name="bid" placeholder="Enter bid amount" required />
                <input type="submit" value="Place bid" />
            </form>
        </section>
        <section class="description">
            <p><?php echo $auction['car_description']; ?></p>
        </section>
        <section class="reviews">
            <h2>Reviews of <?php echo $auction['name']; ?></h2>
             <?php
// Assuming you have already retrieved the reviews using the function getReviewsByAuctionId($auction_id)

// Let's assume $reviews is the array of reviews returned by the function

if (!empty($reviews)) {
    echo "<ul>";
    foreach ($reviews as $review) {
        $userName = htmlspecialchars($review['user_name']);
        $comment = htmlspecialchars($review['user_review']);
        $date = date('d/m/Y', strtotime($review['created_at']));

        echo "<li><strong>$userName said:</strong> $comment <em>$date</em></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No reviews found for this auction.</p>";
}
// ?> 


            <form action="review.php?auction=<?= $auction['auction_id'] ?>" method="post">
                <label>Add your review</label> <textarea name="reviewtext" required></textarea>
                <input type="submit" name="submit" value="Add Review" />
            </form>
        </section>
    </article>
</main>



					<!-- <hr />
					<h1>Sample Form</h1>

					<form action="#">
						<label>Text box</label> <input type="text" />
						<label>Another Text box</label> <input type="text" />
						<input type="checkbox" /> <label>Checkbox</label>
						<input type="radio" /> <label>Radio</label>
						<input type="submit" value="Submit" />

					</form> -->





</body>
</html>