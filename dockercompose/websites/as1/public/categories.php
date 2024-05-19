<?php
// Include the database connection file
include("database.php");
// if(isset($_GET['category_id'])){
//     $category_id = $_GET['category_id'];
//     // Assume you fetch the category details from the database using the category_id
//     $pdo = connectToDatabase();
//     $stmt = $pdo->prepare("SELECT category_name FROM category WHERE category_id = :category_id");
//     $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
//     $stmt->execute();
//     $category = $stmt->fetch(PDO::FETCH_ASSOC);

// }

// Start the session
session_start();

// Check if the user is logged in and get the user_id from the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Fetch user data to check if the user is an admin
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['is_admin'] == 1) {
        // User is an admin, continue with admin actions
        // Fetch all categories from the database
        $stmt = $pdo->query("SELECT * FROM category");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
        // Proceed with displaying categories or performing admin actions
    } else {
        // User is not an admin, handle accordingly (e.g., redirect or display an error)
        header("Location: index.php?admin_required=true");
    }
} else {
    // User is not logged in, handle accordingly (e.g., redirect to login page)
    header("Location: index.php?login_required=true");
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="carbuy.css" />
</head>
<body>
    <?php include("header.php") ?>
    
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
    <h2>All Categories</h2>
<ul class="category-list">
    <?php foreach($categories as $category): ?>
    <li>
        <span><?php echo $category['category_name']; ?></span>
        <div class="actions">
            <a href="categories.php?category_id=<?php echo $category['category_id']  ?>" class="edit">Edit</a>
            <a href="deleteCategory.php?category_id=<?php echo $category['category_id']  ?>" class="delete">Delete</a>
        </div>
    </li>
    <?php endforeach; ?>
</ul>



      </div>
      

      <div class="box1">
      <?php
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    // Assume you fetch the category details from the database using the category_id
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare("SELECT category_name FROM category WHERE category_id = :category_id");
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $category['category_name'];
    echo '<h2>Edit Category</h2>
    <form method="post" action="editCategory.php" class="form">
        <input type="hidden" name="category_id" value="' . htmlspecialchars($category_id) . '">
        <input type="text" placeholder="Edit Category" class="input" name="category" value="' . htmlspecialchars($category_name) . '" required />
        <input type="submit" name="submit" value="Save" class="btn">
    </form>';
} else {
    echo '<h2>Add Category</h2>
    <form method="post" action="addCategory.php" class="form">
        <input type="text" placeholder="Add Category" class="input" name="category" required />
        <input type="submit" name="submit" value="Add" class="btn">
    </form>';
    
}



?>
         
      </div>
   </div>

 </div>
    
</body>
</html>