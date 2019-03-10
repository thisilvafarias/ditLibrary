<?php 

include('header.php'); 
include('db.php');

date_default_timezone_set("UTC"); 
$weekstr = date ('Y-m-d', strtotime (' + 7 days'));
$codate = $weekstr;

if  ($_GET){
	$username = $_GET['username']; 
	$stmt = $DBH->prepare("SELECT * FROM libraryUsers WHERE username= :username");
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	include('errordb.php');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$username = $row['username'];
	$id_user= $row['id_user'];
}
if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
{
    header("Location:login.php");
}
if  ($_GET){
	$id = $_GET['id']; 
	$stmt = $DBH->prepare("SELECT * FROM books WHERE id= :id");
	$stmt->bindValue(':id', $id);
	$stmt->execute();
	include('errordb.php');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $row['id'] ;
	$Title = $row['Title'];
	$Author = $row['Author'];
	$ISBN = $row['ISBN'];	
}

if ($_GET){
    $username = $_GET['username']; 
    $stmt = $DBH->prepare("SELECT l.*, c.*
                        FROM checkOutData c
                        JOIN libraryUsers l ON l.id_user=c.user_id where username=:username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    include('errordb.php');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $check_id = $row['check_id']; 
   

}

if (isset($_POST['no'])) {
	header("Location: studentLibrary.php?username=".$_SESSION["username"]);
}else
	{
if  ($_POST){
	$id = $_POST['id']; 
	$Status = $_POST['Status'];
	$stmt = $DBH->prepare("UPDATE books set id = :id, 
							Status = :Status
							WHERE id = :id");
	$stmt->bindValue(':id', $id);
	$stmt->bindValue(':Status', $Status);
	$stmt->execute();
	include('errordb.php');
}
if ($_POST) {
			$username = $_POST['username'];
			$check_id_in_booked = $_POST['check_id_in_booked'];
			$stmt = $DBH->prepare("INSERT INTO  booked 
				(check_id_in_booked, username)
				Values(:check_id_in_booked, :username )");
			$stmt->bindValue(':check_id_in_booked', $check_id_in_booked);
			$stmt->bindValue(':username', $username);
			$stmt->execute();
			include('errordb.php');
		}

		if ($_POST) {
			$book_id2 = $_POST['book_id1'];
		    $user_id = $_POST['user_id'];
			$giveBack = $_POST['giveBack'];
			$checkOutOn = $_POST['checkOutOn'];
			$stmt = $DBH->prepare("INSERT INTO  checkOutdata 
				(book_id,user_id,giveBack,checkOutOn)
				Values(:book_id2,:user_id,:giveBack,:checkOutOn)");

			$stmt->bindValue(':book_id2', $book_id2);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->bindValue(':giveBack', $giveBack);
			$stmt->bindValue(':checkOutOn', $checkOutOn);
			$stmt->execute();
			include('errordb.php');
		
		 	header("Location: studentLibrary.php?username=".$_SESSION["username"]);
	       exit;
		}
		
		
}



?>


<html>
<style>
h2 {
  text-align: center;
}
body  {  
    background-color: #cccccc;
}
.center {
    text-align:center;
}
</style>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<form class='form-style' action="checkout.php" method="post">
<h2>Do you want to check "<?php echo $Title; ?>" out?</h2>
<div class="center">

<?php
	$myql__datetime = date("Y-m-d", time());
	

?> 




<input  type="hidden" name="username" value="<?php echo $username ?>" /> 
<input  type="hidden" name="check_id_in_booked" value="<?php echo $check_id ?>" /> 
<input  type="hidden" name="checkOutOn" value="<?php echo $myql__datetime ?>" />
<input  type="hidden" name="giveBack" value="<?php echo  $codate; ?>" /> 
<input  type="hidden" name="user_id" value="<?php echo $id_user ?>" />
<input  type="hidden" name="book_id1" value="<?php echo $id; ?>" />
<input  type="hidden" name="Status" value="Unavailable" />
<input  class="w3-button w3-ripple w3-black" type="submit" name="yes" value="Yes" />
<input  class="w3-button w3-ripple w3-black" type="submit" name="no" value="No" />

</div>
<h4> Details of the book </h4>


Id: <input type="text" name="id" value="<?php echo $id; ?>" />

Title: <input type="text" name="Title" value="<?php echo $Title; ?>" />

Author: <input type="text" name="Author" value="<?php echo $Author; ?>" />

ISBN: <input type="text" name="ISBN" value="<?php echo $ISBN; ?>" />
<br></br>

<br>
<?php
	date_default_timezone_set("UTC"); 
    echo 'Today is ', date("Y-m-d h:i:s", time());
    echo "</br>";
	echo 'This book must be returned on ', $codate;



?>


</form>


<?php include 'footer.php'; ?>
</body>
</html>