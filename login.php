<?php
ob_start(); 
include('db.php'); 
include('header.php'); 

$username = "";
$password = "";

$usernameErr = "";
$passwordErr = "";



if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password'];


	if (empty($username) || strlen($username) < 4 ) 
               $usernameErr = "*Username is required, at least 4 chars";
	if (strlen($password) < 4 ) {
				$passwordErr = "*password 8 or more chars";  
	}	   
	if (empty($usernameErr) && empty($passwordErr)) {		   

      try {
		

		$q = $DBH->prepare("select * from libraryUsers where username = :username LIMIT 1");
		$q->bindValue(':username', $username);

		$q->execute();
		
		$row = $q->fetch(PDO::FETCH_ASSOC);
		


		if ($q->rowCount() > 0) {
			$phash = $row['password']; //$row['password'] is in my database, and now I am hasing it

				if ( $row['username'] == ("admin") && password_verify($password,$phash)) { //$password :
					$_SESSION["user_id"] = $row['user_id'];
					$_SESSION["username"] = $username;
					header("Location: admLibrary.php?username=".$_SESSION["username"]);
					exit;
	
			}
				else if (password_verify($password,$phash)) {
					
					
					$_SESSION["user_id"] = $row['user_id'];
					$_SESSION["username"] = $username;
					
					header("Location: studentLibrary.php?username=".$_SESSION["username"]);
					exit;
			
					
			}
			else {
				$message = 'Invalid password.';
				
			}
			
		} else {
		    $message = 'Sorry your log in details are not correct';
		}
	} catch(PDOException $e) {echo $e->getMessage();}
	}
	
}




?>

<!DOCTYPE>
<html>
    <style>
  .error {display: block;color: #FF0000; }
  </style>

<head>
<link rel="stylesheet" href="css/style.css">
</head>


<body class="bgimg">
<img class="logo" src="images/logo_banner.jpg" alt="logo">
<br></br>   
	<div style="background-color:rgba(0, 0, 0, 0.9);">
		
		<form class='form-style' action="login.php" method="post">  
		

		Username <input type="text" name="username" value="<?php echo $username; ?>"/>
		         <span class = "error"><?php echo $usernameErr;?></span>

		Password <input type="password" name="password" value="<?php echo $password; ?>"/>
		       	 <span class = "error"><?php echo $passwordErr;?></span>	

		<input class="buttonSub" type="submit" name="submit" value="Log in"/>
			<?php
			if(!empty($message)){  echo '<br>';
	        	echo $message;
			}
			?>

			
		</form>
	
	</div> 

	<br></br> 

</body>
</html>
