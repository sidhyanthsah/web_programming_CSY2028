<?php
include("database.php");


if(isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $category_id = $_GET['category_id'];


$pdo=connectToDatabase();

 // SQL to delete a row from the category table
 $sql = "DELETE FROM category WHERE category_id = :category_id";

 // Prepare the SQL statement
 $stmt = $pdo->prepare($sql);
 $stmt->bindParam(':category_id', $category_id);

 $stmt->execute();
 header("Location: categories.php");
}else{
    header("Location: index.php");
}