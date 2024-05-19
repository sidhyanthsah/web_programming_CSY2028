<?php
include("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Get the category name from the form
        $category_name = $_POST['category'];
        
        // Insert the new category into the database
        $pdo = connectToDatabase();
        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to a success page or reload the current page
        header("Location: categories.php");
        exit;
    }
}

