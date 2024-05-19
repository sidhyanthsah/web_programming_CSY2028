<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: index.php?login_required=true");
  }
  

include ("database.php");
$pdo=connectToDatabase();
$sql= "SELECT * FROM category";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$categories=$stmt->fetchAll((PDO::FETCH_ASSOC));


if(isset($_POST['submit'])){
    $user_id=$_SESSION['user_id'];
    $car_model = $_POST['car_model'];
    $car_make = $_POST['car_make'];
    $car_description = $_POST['car_description'];
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $auction_end=$_POST['auction_end'];
    $car_image_name = $_FILES['car_image']['name'];
    $car_image_tmp=$_FILES['car_image']['tmp_name'];
    $upload_dir="images/";

    $target_file=$upload_dir.basename($car_image_name);
    move_uploaded_file($car_image_tmp,$target_file);
    
   
    try {
        // Connect to the database using PDO
        $pdo = connectToDatabase();

        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query
        $sql = "INSERT INTO auction (user_id, car_model, car_make, car_description, car_category_id, amount, auction_end, car_image)
        VALUES (:user_id, :car_model, :car_make, :car_description, :car_category_id, :amount, :auction_end, :car_image)";
$stmt = $pdo->prepare($sql);

// Bind parameters
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':car_model', $car_model);
$stmt->bindParam(':car_make', $car_make);
$stmt->bindParam(':car_description', $car_description);
$stmt->bindParam(':car_category_id', $category_id);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':auction_end', $auction_end);
$stmt->bindParam(':car_image', $car_image_name); // Save only the image filename in the database
        $stmt->execute();

        header('Location: index.php');
        exit();
    } catch(PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }


    
     
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Auction</title>
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="carbuy.css" />
</head>
<body>
    <?php
include("header.php");

?>
    <div class="container-fluid">
   
        <!-- <h1>
            <span class="C">C</span>
            <span class="a">a</span>
           <span class="r">r</span>
           <span class="b">b</span>
           <span class="u">u</span>
           <span class="y">y</span>
        </h1> -->
   <div class="container">
    <div class="box">
        <img class="lambo" src="banners/pic.png" alt="car" draggable="false"  />
      </div>
      <div class="box1">
        <h2>Add Auction</h2>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form" enctype="multipart/form-data">
               <div class="row">
                <div class="div">
                    <input class="input" type="text" placeholder="Car Model" name="car_model" required>
                </div>

                <div class="div">
                    <input class="input" type="text" placeholder="Car Year" name="car_make" required>
                </div>

                <div class="div">
                    <textarea name="car_description" placeholder="car_description" class="input" required></textarea>
                </div>

                <div class="div">
                <select class="select" name="category_id" required>
    <option disabled selected>select car model</option>
    <?php foreach ($categories as $category): ?>
        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
    <?php endforeach; ?>
</select>

                    </select>
             
               </div>
               <div class="div">
                <input type="text" placeholder="Sale Amount" name="amount" class="input" required  />  
               </div>
               <div class="div">
                <input type="file" name="car_image" id="image_input"  class="file-input" required />
                <label for="image_input" class="file-label">Select Image</label>
               </div>
               <div class="div">
                <small>select auction due date and time</small>
                <input type="datetime-local" class="input" name="auction_end" />
               </div>
               <div class="div">
                
                <input type="submit" class="btn" value="Add Auction" name="submit"  />
               </div>
           
             </form>
  
      </div>
   </div>

 </div>


</body>
<script>
    
      
    
</script>
</html>