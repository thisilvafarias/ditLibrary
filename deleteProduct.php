<?php include('header.php'); ?>





<?php

if(!(isset($_SESSION['username'])))
{
    header("Location:login.php");
}

include('db.php');
if($_GET){
$id = $_GET['id']; // from link in products.php
$stmt = $DBH->prepare("SELECT * FROM books WHERE id= :id");
$stmt->bindValue(':id', $id);
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
 $id = $_POST['id']; // from hidden input field
$stmt = $DBH->prepare("DELETE FROM books WHERE id= :id");
$stmt->bindValue(':id', $id);
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
<body>
<h2>Delete Book</h2><br></br>
<form class='form-style' action="deleteProduct.php" method="post">

Id: <input type="text" name="id" value="<?php echo $id; ?>" readonly/>

Title: <input type="text" name="Title" value="<?php echo $Title; ?>" readonly/>

Author: <input type="text" name="Author" value="<?php echo $Author; ?>" readonly/>

ISBN: <input type="text" name="ISBN" value="<?php echo $ISBN; ?>" readonly/>

Status: <input type="text" name="Status" value="<?php echo $Status; ?>" readonly/>

<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" name="submit" value="Delete" class='button'/>
</form>


<?php include 'footer.php'; ?>

</body>
</html>