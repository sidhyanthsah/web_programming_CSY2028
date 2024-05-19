<?php
if(isset($_GET["login_required"]) && $_GET["login_required"] === "true"){
	echo '<p style="color: red;">You need to be logged in to access this page. <a href="login.php">Login</a></p>';
}else if(isset($_GET["admin_required"]) && $_GET["admin_required"] === "true"){
	echo '<p style="color: red;">You need to be admin  to access this page.</p>';
}

$pdo=connectToDatabase();
$sql="SELECT * FROM category";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$categoryes=$stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<header>
			<h1><span class="C">C</span>
 			<span class="a">a</span>
			<span class="r">r</span>
			<span class="b">b</span>
			<span class="u">u</span>
			<span class="y">y</span></h1>

			<form action="index.php?search" method="post">
				<input type="text" name="search" placeholder="Search for a car" />
				<input type="submit" name="submit" value="Search" />
			</form>
			
		</header>
         <nav class="nav" style="display:flex;justify-content:end;">
		 <a href="/" style="color:blue;">Home</a>
		 <a href="addAuction.php" style="color:blue; margin-left:5px;">Add Auction</a>
		 <a href="yourAuction.php" style="color:blue; margin-left:5px;">your Auctions</a>

		   <a href="categories.php" style="color:blue;margin-left:5px;margin-right:5px;">Categories</a>
		   
		   <?php
    echo isset($_SESSION['user_id']) ? '<a href="logout.php" style="color:red; margin-right:5px;">Logout</a>' : '<a href="login.php" style="color:blue; margin-right:5px;">Login</a>';
?>

		 </nav>
		<nav>
			<ul>
			<?php foreach ($categoryes as $category): ?>
        <li><a class="categoryLink" href="category.php?category=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a></li>
    <?php endforeach; ?>

			</ul>
		</nav>
		