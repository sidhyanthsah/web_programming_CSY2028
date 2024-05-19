<?php
ob_start();
session_start();
if(isset($_SESSION["user_id"])){
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="home.css" />
    <style>
        .box1{
  box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
  width: 45%;
  height: 98%;
  display: flex;
  flex-direction: column;  
  align-items: center;
  }
    </style>
</head>
<body>
    
<?php

include("database.php");
try {
  if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $hashedPassword=password_hash($password,PASSWORD_DEFAULT);
    $pdo=connectToDatabase();
    if($pdo){
      $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
      $checkStmt->bindParam(':email', $email);
      $checkStmt->execute();
      $count = $checkStmt->fetchColumn();
      if($count>0){
        echo "user with email '$email' already exists.";
      }else{
        $stmt=$pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$hashedPassword);
        $stmt->execute();
        if($stmt->rowCount() > 0) { 
          $user_id=$pdo->lastInsertId(); 
          $_SESSION['user_id']=$user_id;
          header("Location: index.php");
          exit;
      } else {
          echo "Failed to insert record";
      }
    }
     
} else {
    echo "Failed to connect to the database";
}
      
    }
     


} catch (PDOException $e) {
    echo "Error: ".$e->getMessage();
}


?>

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
        <h2>Register</h2>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form">
            <input  type="text" placeholder="Name" class="input" name="name" />
            <br>
                <input  type="text" placeholder="Email" class="input" name="email" />
                <br>
                <input  type="text" placeholder="Password" class="input" name="password" />

                <input type="submit" name="submit" value="Register" class="btn">
                <p style="margin-top:10px;">already have an account? <a href="login.php">Login</a></p>

                <p style="margin-top:10px;"> see auctions without login  <a href="/">Home</a></p>
             </form>
        
       
  
      </div>
   </div>

 </div>
    
</body>
</html>

