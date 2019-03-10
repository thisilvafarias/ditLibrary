<?php 
include('header.php'); 
include('db.php');




if  ($_GET){
	$pid = $_GET['id']; 
	$stmt = $DBH->prepare("SELECT * FROM books WHERE id= :pid");
	$stmt->bindValue(':pid', $pid);
	$stmt->execute();
	include('errordb.php');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $row['id'];
	$Title = $row['Title'];
	$Author = $row['Author'];
	$ISBN = $row['ISBN'];
	$Status = $row['Status'];

}

if ($_POST) {
	$pid = $_POST['pid']; 
	$id = $_POST['id'];
	$Title = $_POST['Title'];
	$Author = $_POST['Author'];
	$ISBN = $_POST['ISBN'];
	$Status = $_POST['Status'];
	$stmt = $DBH->prepare("UPDATE books set id = :id, 
							Title = :Title, 
							Author = :Author,
							ISBN = :ISBN, 
							Status = :Status
							WHERE id = :pid");
	$stmt->bindValue(':pid', $pid);
	$stmt->bindValue(':id', $id);
	$stmt->bindValue(':Title', $Title);
	$stmt->bindValue(':Author', $Author);
	$stmt->bindValue(':ISBN', $ISBN);
	$stmt->bindValue(':Status', $Status);
	$stmt->execute();
	include('errordb.php');
	header("Location: admLibrary.php?username=".$_SESSION["username"]);
}
?>

<html>
<style>
body  {  
    background-color: #cccccc;
}
</style>
</head>
<body>
<h2>Update Book</h2><br></br>
<form class='form-style' action="updateProduct.php" method="post">

Id: <input type="text" name="id" value="<?php echo $id; ?>" />

Title: <input type="text" name="Title" value="<?php echo $Title; ?>" />

Author: <input type="text" name="Author" value="<?php echo $Author; ?>" />

ISBN: <input type="text" name="ISBN" value="<?php echo $ISBN; ?>" />



<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
<input type="submit" name="submit" value="Update" class='button'/>
</form>


<?php include 'footer.php'; ?>
</body>
</html>