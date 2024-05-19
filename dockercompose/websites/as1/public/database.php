<?php



function connectToDatabase() {
//     $host = 'localhost'; // Assuming the database is running on the same host
// $port = '3306'; // Port mapped in Docker-compose file
// $dbname = 'assignment1'; // Database name
$username = 'student'; // Database username
$password = 'student'; // Database password
$pdo=null;
    try {
        $pdo = new PDO('mysql:dbname=assignment1;host=mysql', $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        // Log the error message to a file or log management system
        error_log("Connection failed: " . $e->getMessage());
        return null;
    }
}


// $host = 'v.je'; // Assuming the database is running on the same host
// $port = '3306'; // Port mapped in Docker-compose file
// $dbname = 'assignment1'; // Database name
// $username = 'student'; // Database username
// $password = 'student';
