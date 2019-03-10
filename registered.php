<?php
include('header.php'); 

$username = "";
$password = "";

$usernameErr = "";
$passwordErr = "";

if  ($_GET){
    $username = $_GET['username']; 
}
if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
{
    header("Location:login.php");
}

if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (empty($id) || strlen($id) < 4 || !is_numeric($id)) 
               $idErr = "ID is required, at least 4 chars and only number";
	if (empty($username) || strlen($username) < 4 ) 
               $usernameErr = "Username is required, at least 4 chars";
	if (strlen($password) < 4 ) {
			$passwordErr = 'password 8 or more chars';  
	}	   
	if (empty($usernameErr) && empty($passwordErr)) {		   
    
      try {
        $host = '127.0.0.1';
        $dbname = 'cctLibrary';
        $user = 'root';
        $pass = '';
		# MySQL with PDO_MYSQL
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

		$q = $DBH->prepare("select * from libraryUsers where username = :username LIMIT 1");
		$q->bindValue(':username', $username);
		$q->execute();
		
		$row = $q->fetch(PDO::FETCH_ASSOC);
		 
		if ($q->rowCount() > 0) {
			$phash = $row['password'];

			if (password_verify($password,$phash)) {
				$_SESSION["user_id"] = $row['user_id'];
				$_SESSION["username"] = $username;

				header("Location: studentLibrary.php?username=".$_SESSION["username"]);
				exit();
			}
			else 
				$message= 'Invalid password.';
			
		} else {
		    $message= 'Sorry your log in details are not correct';
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
		
		<h4 class="probootstrap-heading_registered"> Thank You For Joining Us <?php echo $_SESSION["username"]?> ! </h4>
		<h4 class="probootstrap-heading_registered"> Log in to continuos </h4>
		
		
		<form class='form-style' action="registered.php" method="post">  
		Username <input type="text" name="username" required minlength='4' maxlength='40'/> 
			<span class = "error"><?php echo $usernameErr;?></span> 
		Password <input type="password" name="password" required required minlength='4' maxlength='10'/>
			<span class = "error"><?php echo $passwordErr;?></span>


		<input class="buttonSub" type="submit" name="submit" value="Log in" />
			<?php
			if(!empty($message)){  echo '<br>';
			echo $message;
			}
			?>

			
		</form>
	
	</div> 

	<br></br> 
<?php
include('footer.php'); 
?>
</body>
</html>