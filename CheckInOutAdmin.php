<?php 
include('header.php'); 
include('db.php');

if($_SESSION){
$username = $_SESSION["username"];

}

if  ($_GET){
	$stmt = $DBH->prepare("SELECT * FROM libraryUsers WHERE username= :username");
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	include('errordb.php');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$username = $row['username'];
	$id_user= $row['id_user'];
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
if  ($_GET){
	$id = $_GET['id']; 
	$stmt = $DBH->prepare("SELECT b.*, c.* 
								FROM books b
								JOIN checkOutData c ON c.book_id=b.id WHERE id= :id");
	$stmt->bindValue(':id', $id);
	$stmt->execute();
	include('errordb.php');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $row['id'] ;
	$Title = $row['Title'];
	$Author = $row['Author'];
	$ISBN = $row['ISBN'];
	$check_id = $row['check_id'];
	
}

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



if (isset($_POST['no'])) {
	header("Location: admLibrary.php?username=".$username);
}else
{
		if ($_POST) {
			//$check_id = $_POST['check_id']; 
		    $book_id = $_POST['book_id'];
			$user_id = $_POST['user_id'];
			$giveBack = $_POST['giveBack'];
			$stmt = $DBH->prepare("INSERT INTO  checkOutdata 
				(book_id, user_id,giveBack)
				Values(:book_id,:user_id,:giveBack)");
			//$stmt->bindValue(':check_id', $check_id);
			$stmt->bindValue(':book_id', $book_id);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->bindValue(':giveBack', $giveBack);
			$stmt->execute();
			include('errordb.php');

				header("Location: admLibrary.php?username=".$username);
				
			}
			if ($_POST) {
			$check_id = $_POST['check_id']; 
			$stmt = $DBH->prepare("DELETE FROM checkOutdata WHERE check_id= :check_id");
			$stmt->bindValue(':check_id', $check_id);
			$stmt->execute();
			include('errordb.php');
			header("Location: admLibrary.php");
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

<form class='form-style' action="CheckInOutAdmin.php" method="post">
<h2>Do you want to check "<?php echo $Title; ?>" in?</h2>
<div class="center">

<?php
	date_default_timezone_set('UTC');
	 $dt = time();
	 $myql__datetime = strftime("%Y-%m-%d %H:%M:%S", $dt);
	 $giveBack = $myql__datetime;
?>


<input  type="hidden" name="check_id" value="<?php echo $check_id ?>" />
<input  type="hidden" name="giveBack" value="<?php echo $myql__datetime ?>" />
<input  type="hidden" name="user_id" value="<?php echo $Title; ?> returned " />
<input  type="hidden" name="Status" value="Available" />
<input  class="w3-button w3-ripple w3-black" type="submit" name="yes" value="Yes" />
<input  class="w3-button w3-ripple w3-black" type="submit" name="no" value="No" />

</div>


<h4> Details of the book </h4>

Id: <input type="text" name="id" value="<?php echo $id; ?>" />

Title: <input type="text" name="Title" value="<?php echo $Title; ?>" />

Author: <input type="text" name="Author" value="<?php echo $Author; ?>" />

ISBN: <input type="text" name="ISBN" value="<?php echo $ISBN; ?>" />


</form>


<?php include 'footer.php'; ?>
</body>
</html>