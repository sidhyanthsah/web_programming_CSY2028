<?php
// Start session to access session variables if needed
session_start();
include("database.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $category_name = isset($_POST['category']) ? trim($_POST['category']) : '';

    // Ensure category_id and category_name are set
    if ($category_id && !empty($category_name)) {
        // Connect to the database
        $pdo = connectToDatabase();

        // Prepare and execute the update query
        $sql = "UPDATE category SET category_name = :category_name WHERE category_id = :category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect or display a success message
            header('Location: /categories.php');
            exit;
        } else {
            $error_message = "Failed to update the category. Please try again.";
        }
    } else {
        $error_message = "Invalid category ID or category name.";
    }
} else {
    $error_message = "Invalid request method.";
}

// Handle error messages (optional)
if (isset($error_message)) {
    echo '<p>Error: ' . htmlspecialchars($error_message) . '</p>';
}
