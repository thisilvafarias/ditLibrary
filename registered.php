<?php
include('header.php'); 



if  ($_GET){
    $username = $_GET['username'];
}
if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
{
    header("Location:login.php");
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
<img class="logo" src="images/logo_banner.png" alt="logo" style="width: 20%; height: 20%;">
<br>
	<div style="background-color:rgba(0, 0, 0, 0.9);">
		
		<h4 class="probootstrap-heading_registered"> Thank You For Joining Us <?php echo $_SESSION["username"]?> ! </h4>
		<h4 class="probootstrap-heading_registered"> Log in to continuos </h4>
		
		
		<form class='form-style' action="studentLibrary.php?username=<?php echo $username ?>" method="post">
		<input class="buttonSub" type="submit" name="submit" value="Go to Library" />
		</form>
	
	</div> 

	<br>
<?php
include('footer.php'); 
?>
</body>
</html>