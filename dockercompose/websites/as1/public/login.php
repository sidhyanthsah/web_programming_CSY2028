<?php
include ("database.php");
ob_start();
session_start();
if(isset($_SESSION["user_id"])){
  header("Location: index.php");
}

?>

<?php
if(isset($_POST["submit"])){
  $email=$_POST['email'];
  $password=$_POST['password'];
  $pdo=connectToDatabase();
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if user exists
  if ($user) {
      // Verify password
      if (password_verify($password, $user['password'])) {
          // Passwords match, user is authenticated
          $_SESSION['user_id'] = $user['user_id'];
          header("Location: index.php");
      } else {
          // Passwords don't match
          echo "Incorrect password.";
      }
  } else {
      // User not found
      echo "User not found.";
  }
  
   


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Login</h2>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form">
           
                <input  type="text" placeholder="Email" class="input" name="email" required />
                <br>
                <input  type="text" placeholder="Password" class="input" name="password" required />

                <input type="submit" name="submit" value="Login" class="btn">
             </form>
     
             <br>
             <p style="margin-top:10px;">create an account? <a href="register.php">Signup</a></p>
            <p style="margin-top:10px;"> see auctions without login  <a href="/">Home</a></p>
      </div>
   </div>

 </div>
    
</body>
</html>