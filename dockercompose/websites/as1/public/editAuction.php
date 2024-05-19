<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: index.php?login_required=true");
    exit; // Stop further execution
}

include ("database.php");
$pdo = connectToDatabase();

// Check if the auction ID is provided in the URL
if(isset($_GET['auction'])) {
    $auction_id = $_GET['auction'];

    // Fetch auction data from the database
    $sql = "SELECT * FROM auction WHERE auction_id = :auction_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $stmt->execute();
    $auction = $stmt->fetch(PDO::FETCH_ASSOC);

    // If auction data is found, pre-fill the form fields
    if($auction) {
        // Fetch categories for dropdown
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


    }

}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auction</title>
    <link rel="stylesheet" href="home.css" />
</head>
<body>
    
    <div class="container-fluid">
   
        <h1>
            <span class="C">C</span>
            <span class="a">a</span>
           <span class="r">r</span>
           <span class="b">b</span>
           <span class="u">u</span>
           <span class="y">y</span>
        </h1>
   <div class="container">
    <div class="box">
        <img class="lambo" src="banners/pic.png" alt="car" draggable="false"  />
      </div>
      <div class="box1">
        <h2>Edit Auction</h2>
            <form method="post" action="manageEditAuction.php?auction=<?php echo $auction_id  ?>" class="form" enctype="multipart/form-data">
               <div class="row">
                <div class="div">
                    <input class="input" type="text" placeholder="Car Model" name="car_model" value="<?php echo $auction['car_model']; ?>" required>
                </div>

                <div class="div">
                    <input class="input" type="text" placeholder="Car Year" name="car_make" value="<?php echo $auction['car_make']; ?>" required>
                </div>

                <div class="div">
                    <textarea name="car_description" placeholder="Car Description" class="input" required><?php echo $auction['car_description']; ?></textarea>
                </div>

                <div class="div">
                    <select class="select" name="category_id" required>
                        <option disabled selected>select car model</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']; ?>" <?php if($category['category_id'] == $auction['car_category_id']) echo "selected"; ?>><?php echo $category['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="div">
                    <input type="text" placeholder="Sale Amount" name="amount" class="input" value="<?php echo $auction['amount']; ?>" required  />  
                </div>

                <div class="div">
                    <img src="./images/<?php echo $auction['car_image'];  ?>" style="height:100px;width:100px;margin-bottom:5px;" />
                     
                </div>

                <div class="div">
                    <small>Select auction due date and time</small>
                    <input type="datetime-local" class="input" name="auction_end" value="<?php echo date('Y-m-d\TH:i', strtotime($auction['auction_end'])); ?>" />
                </div>

                <div class="div">
                    <input type="submit" class="btn" value="Update Auction" name="submit"  />
                </div>
            </form>
        </div>
    </div>
</div>

</body>
<script>
    
</script>
</html>


