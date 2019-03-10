<?php
ob_start(); 
include('header.php'); 
include('db.php');



$check_id = "";
$giveBack = "";
$myql__datetime = "";
if($_SESSION){
$username = $_SESSION["username"]; 
}
if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
{
    header("Location:login.php");
}

if  ($_GET){
    $stmt = $DBH->prepare("SELECT * FROM checkOutData");
    $stmt->execute();
    include('errordb.php');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $check_id = $row['check_id']; 
    $giveBack = $row['giveBack'];
    $checkOutOn = $row['checkOutOn'];  
}

if(isset($_POST['search'])){
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT b.*, l.*, c.* 
                        FROM books b 
                        left JOIN checkOutdata c ON b.id=c.book_id 
                        left OUTER JOIN libraryUsers l ON l.id_user=c.user_id
                        WHERE CONCAT(b.id, b.Title, b.Author, b.ISBN)  LIKE '%".$valueToSearch."%'" ;
    $search_result = filterTable($query);

    // using concat mysql function
}
else {
     $query = "SELECT b.*, l.*, c.* 
                        FROM books b 
                        left JOIN checkOutdata c ON b.id=c.book_id 
                        left OUTER JOIN libraryUsers l ON l.id_user=c.user_id;" ;
     $search_result = filterTable($query);
        
}
if(isset($_POST['submit'])){

    header("Location: addBook.php?admin=".$_SESSION["username"]);

}


function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "cctLibrary");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}   

   


?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            tr,th,td
            {
                border: 1px solid black;
            }

        table {
          border-collapse: collapse;
            border: 1px solid black;
            width: 85%;
            margin-left:10%; 
            margin-right:15%;
            background: #969696;
        }


        th, td {
            text-align: left;
            padding: 8px;
        }

tr:nth-child(even){background-color: #f2f2f2}
    </style>

<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">

    </head>
    <body class="bgimg">

        <img class="logo" src="images/logo_banner.jpg" alt="logo">
        <br></br>   
        <div style="background-color:rgba(0, 0, 0, 0.9);"> 
             
        <h3 class="probootstrap-heading"> Enjoy CCT library </h3>
       
     

        <form action="admLibrary.php" method="post">
          <input type="text" name="valueToSearch" class="myInput" placeholder="Search for book..." title="Type in a name">
          
            <input class="buttonFilter" type="submit" name="search" value="Filter"><br><br>

            
            <table>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Status</th>
                    <th style="width: 15%;">last bookde for</th>
                    <th style="width: 10%;" >Return date</th>
                    <th>Delay</th>
                    <th>Settings</th>
                    <th>Settings</th>
                    <th>Settings</th>
                    
                    
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['Title'];?></td>
                    <td><?php echo $row['Author'];?></td>
                    <td><?php echo $row['ISBN'];?></td>
                    <td ><?php if ($row['Status'] == ("Available")){
                        
                        echo "<p><font color='green'>Available</font></p>";
;
                            
                        }   
                        else {
        
                          echo "<p><font color='red'>Unvailable</font></p>";
                        }
                        ;?>
                        </td>
                    <td><?php echo $row['username']." ".$row['id_user'];?></td>
                    <td><?php echo $row['giveBack'];?></td>
                    <td><?php 

                        date_default_timezone_set("UTC"); 
                        $deadline = $row['giveBack'];
                        $now = date("Y-m-d", time());
                      
                        $start = $row['checkOutOn'];
                       // echo $start;
                        $diff = abs(strtotime($start) - strtotime($now));
                        $days = floor(($diff) / (60*60*24));
                      //  echo $days;
                        $daysInDelay = $days-7;
                        $diff2 = abs(strtotime($deadline) - strtotime($now));
                        $daysLeft = floor(($diff2) / (60*60*24));
                       
                        
                       // echo $daysLeft;

                    if (empty($deadline)){} else {
                    if (  $days > 7){
                                
                        echo "<p><font color='red'> $daysInDelay days delay</font></p>";
                            
                        } 

                        else {
        
                         echo "<p><font color='green'> $daysLeft days left</font></p>";
                            }
                        }
                        ;?>
                    </td>
                    <td><?php echo "<a href=deleteProduct.php?id=".$row['id']."> Delete </a>";?></td>
                    <td><?php echo "<a href=updateProduct.php?id=".$row['id']."> Edit </a>";?></td>
                    <td><?php echo "<a href='CheckInOutAdmin.php?id=".$row['id']."username=".$username."checkid=".$check_id."'> Check it back IN </a>";
                              

                    ?></td>


                </tr>
                <?php endwhile;?>
            </table>
             <br></br>
             
                
                <div class="center-wrap">
                    <div>
                        <input class="buttonSub" style="width: 290px" type="submit" name="submit" value="Add a New Book"/>
                    </div>
                </div>  
                     

            <br></br>
        </form>

    </div>
<br></br>  
</div>





</body>
</html>

<?php
include('footer.php'); 
?>