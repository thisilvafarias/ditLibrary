<?php 
include('header.php');
include('db.php');

// if  ($_GET){
//     $username = $_GET['username']; 
// }
// if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
// {
//     header("Location:login.php");
// }

$Title = "";
$Author = "";
$Title = "";

$TitleErr = "";
$AuthorErr = "";
$ISBNErr = "";
if ($_POST) {
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $ISBN = $_POST['ISBN'];

      if (empty($Title)) {
               $TitleErr = "* Title cannot be blank ";
             }

      if (empty($Author)) {       
      			$AuthorErr= '* Author cannot be blank';
      		}

      if (strlen($ISBN) != 10 ) {
      			$ISBNErr = '* ISBN has to use exactly 10 digits';
      		}
             
      if (empty($TitleErr) && empty($AuthorErr) && empty($ISBNErr)) { 

	$id = $_POST['id'];
	$Title = $_POST['Title'];
	$Author = $_POST['Author'];
	$ISBN = $_POST['ISBN'];
	$Status = $_POST['Status'];
	$stmt = $DBH->prepare("INSERT into books 
		(id, Title, Author, ISBN, Status)
		Values(:id,:Title,:Author,:ISBN,:Status)");
	$stmt->bindValue(':id', $id);
	$stmt->bindValue(':Title', $Title);
	$stmt->bindValue(':Author', $Author);
	$stmt->bindValue(':ISBN', $ISBN);
	$stmt->bindValue(':Status', $Status);
	$stmt->execute();
	include('errordb.php');
	header("Location: admLibrary.php");
}
}


?>

<html>
    <style>
  .error {display: block;color: #FF0000; }
  </style>

<body class="bgimg">
<h2>Save Book</h2><br></br>
<form class='form-style' action="addBook.php" method="post">



Title: <input type="text" name="Title" value="" required minlength='1' maxlength='40' />
		<span class = "error"><?php echo $TitleErr;?></span>

Author: <input type="text" name="Author" value="" required minlength='1' maxlength='40' />
		<span class = "error"><?php echo $AuthorErr;?></span>

ISBN: <input type="text" name="ISBN" value="" required minlength='10' maxlength='10' />
		<span class = "error"><?php echo $ISBNErr;?></span>


<input  type="hidden" name="Status" value="Available" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" name="submit" value="Save" class='button'/>
</form>

<?php include 'footer.php'; ?>
</body>
</html>