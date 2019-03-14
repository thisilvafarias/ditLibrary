<?php
session_start();
?>

<!DOCTYPE html> <html>
<head>
</head>
<body>
<link rel="stylesheet" href="css/menu.css"> 
 
 <ul>
		<li><a href="index.php">DIT</a></li>
		<li><a href="index.php">About us</a></li>
		<li><a href="index.php">DIT Library</a></li>
		<li><a
		
		<?php
		if (isset ($_SESSION['username'])){
			$user = $_SESSION['username'];
			if ($user == "admin"){
					echo "<a href=admLibrary.php?username=".$_SESSION['username']."> Enjoy the CCT Library </a>";
			}else{
			 echo "<a href=studentLibrary.php?username=".$_SESSION['username']."> Enjoy the CCT Library </a>";
		     }

		     echo '<a </a>' .$_SESSION['username'];
			 echo "<a href=logout.php> Log out </a>";

		 } else {
		 	echo "<a href=login.php> Log in </a>";
		 }
		?>

		</li>
</ul>
</body>
</html>

