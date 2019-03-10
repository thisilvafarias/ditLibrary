<?php

include('header.php'); 
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE>
<html>
<head>
<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">
</head>


<body class="bgimg">
<img class="logo" src="images/logo_banner.jpg" alt="logo">
<br></br>   
<div style="background-color:rgba(0, 0, 0, 0.9);">
	   <div>
	      <h1 class="probootstrap-heading"> Welcome to CCT Library </h1>
	      	
	  	         <div class="center-wrap">
	  	         	<div>
                    	<input class="buttonSub" type="submit" name="submit" value="Log in" onclick="location.href='login.php';" />
	            	 </div>
	             </div>
	             <div class="center-wrap">
	                <div>
	                	<input class="buttonSub" type="submit" name="submit" value="Sign Up" onclick="location.href='register.php';" />   
	                </div>
	             </div>
	             <br></br>            
	   </div>
   
</div>
 <?php
include('footer.php'); 
?> 
</body>
</html>
