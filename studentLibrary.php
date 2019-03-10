<?php
ob_start(); 

include('header.php'); 
include('db.php');

date_default_timezone_set("UTC"); 

if ($_GET){
    $username = $_GET['username']; 
    $stmt = $DBH->prepare("SELECT b.id, b.Title, b.Author, b.ISBN , l.username, c.checkOutOn, c.giveBack
                        FROM checkOutData c
                        JOIN books b ON b.id=c.book_id 
                        JOIN libraryUsers l ON l.id_user=c.user_id where username=:username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    include('errordb.php');
}

//if(!(isset($_SESSION['username']) && $_SESSION['username']==$username))
if(!(isset($_SESSION['username'])))
{
    header("Location:login.php");
}

if ($_GET){
    $usernameX = $_GET['username']; 
    $stmt2 = $DBH->prepare("SELECT bk.*, l.*
                        FROM booked bk
                        JOIN libraryUsers l ON l.username=bk.username where username=:username3 ");
    $stmt2->bindValue(':username3', $usernameX);
    $stmt2->execute();
    include('errordb.php');
}
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    
    if(empty($valueToSearch)){
        header("Location: studentLibrary.php?username=".$_SESSION["username"]);
    }
    
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `books` WHERE CONCAT(`id`, `Title`, `Author`, `ISBN`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
// for create the table and take the id book via get to checkout
 else {
    $query = "SELECT b.*, l.*, c.* 
                        FROM books b 
                        left JOIN checkOutdata c ON b.id=c.book_id 
                        left OUTER JOIN libraryUsers l ON l.id_user=c.user_id;";
    $search_result = filterTable($query);
}

// function to connect and execute the query
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
        width: 70%;
        margin-left:15%; 
        margin-right:15%;
        background: #969696;
    }


    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){
    background-color: #f2f2f2
    }
    </style>

<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">

    </head>
    <body class="bgimg">

        <img class="logo" src="images/logo_banner.jpg" alt="logo">
        <br></br>   
        <div style="background-color:rgba(0, 0, 0, 0.9);"> 
             
        <h3 class="probootstrap-heading"> Enjoy CCT library </h3>


      <form action="studentLibrary.php" method="post">
          <input type="text" name="valueToSearch" class="myInput" placeholder="Search for book..." title="Type in a name">
          
            <input class="buttonFilter" type="submit" name="search" value="Filter"><br><br>
   
                 
                
 
         
            <h2 class="probootstrap-heading" style="font-size: 20px;"> Our Library </h2>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Status</th>
                    
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['Title'];?></td>
                    <td><?php echo $row['Author'];?></td>
                    <td><?php echo $row['ISBN']; ?></td>
                    <td><?php
                        
                        // If book is available in the db show link, else sign it as unvailable
                         if ($row['Status'] == ("Available")){
                        
                        echo "<a href='checkout.php?id=".$row['id']."&username=".$username ."'> Check it out  </a>";
                            
                        }   
                        else {
        
                         echo "Unvailable";
                        }

                     ?></td>

                </tr>
                <?php endwhile;?>
            </table>



                
        <?php 
        if(isset($_POST['search'])) {echo "You are searching";}
            else {  
                if ($stmt->rowCount() > 0) {
                ?> 
            
                    <h2 class="probootstrap-heading" style="font-size: 20px;"> Books you have checked out </h2>
                    <!--  First table -->
                <table>
                    <tr>
                    <th>Student Name</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Check Out On</th>
                    <th>Return Up to</th>
                    <th>Deadline(Delay)</th>


                    </tr>
                   
                <!-- populate table from mysql database -->
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['Title'] ?></td>
                    <td><?= $row['Author']  ?></td>
                    <td><?= $row['ISBN'] ?></td>
                    <td><?= $row['checkOutOn']  ?></td>
                    <td><?= $row['giveBack'] ?></td>
                     <td><?php 

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
                </tr>
                    <?php endwhile; 
                    //unset($_POST['search']);
                    ?>
                   
                 </table>
            <br>
          <?php 
            
            } else {}
         } 

            ?>


            
        </form>

    </div>
<br></br>  
</div>


</body>
</html>

<?php
include('footer.php'); 
?>