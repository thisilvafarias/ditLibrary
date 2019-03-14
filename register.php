<?php
//ob_start();

include('header.php'); 


$usernameErr = "";
$username = "";
$studentIDErr = "";
$studentID = "";
$password = "";
$passwordErr = "";
$alreadyExit = "";
$captchaErr = "";





if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $studentID = $_POST['studentID'];

      if (strlen($username) < 4 ) {
               $usernameErr = "* Username is required, at least 3 chars and Alphabetic characters only";
             }

      if (empty($studentID) || strlen($studentID) != 7 || !is_numeric($studentID)) {       
      $studentIDErr= '* Sorry you did not enter a correct Student ID. 7 number requered';
      }

      if (strlen($password) < 6) {
      $passwordErr = '* password is too short, it must be a combination of characters and digits between 6 and 10 max!!';
      }

      if (strlen($password) > 10) {
      $passwordErr = '* password is too long, it must be a combination of characters and digits between 6 and 10 max!';
      }



              if (empty($usernameErr) && empty($studentIDErr) && empty($passwordErr)) {
              
              try {
                  include('db.php'); 
              
                  $checkUserStmt = $DBH->prepare("select * from libraryUsers where username = ?" );
                  $checkUserStmt->bindParam(1, $username);
                  $checkUserStmt->execute();
                                
                    //test
                    if(isset($_POST['submit'])) {


                        if ($checkUserStmt->rowCount() == 0) { //no user with this $name exists

                            //hash the password entered by the user
                            $phash = password_hash($password, PASSWORD_BCRYPT);

                            $sql = "INSERT INTO libraryUsers (username, password, id_user) VALUES (?, ?, ?);";
                            $sth = $DBH->prepare($sql);

                            $sth->bindParam(1, $username);
                            $sth->bindParam(2, $phash);
                            $sth->bindParam(3, $studentID);

                            $sth->execute();
                            $_SESSION["username"] = $username;
                            $_SESSION["user_id"] = $studentID;
                            header("Location: registered.php?username=" . $_SESSION["username"]);
                            exit();
                        } else{
                            $alreadyExit = 'Username already taken, please enter another username';
                         }
                    }
                 } catch(PDOException $e) {echo $e->getMessage();}
              }  

 } //if_$post




?>



<!DOCTYPE>
<html>

<head>
<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
  .error {display: block;color: #FF0000; }
  </style>
</head>
<body class="bgimg">
<img class="logo" src="images/logo_banner.png" alt="logo" style="width: 20%; height: 20%;">
<br>
<div style="background-color:rgba(0, 0, 0, 0.9);">
   <div>
      <h1 class="probootstrap-heading"> Registration Form </h1>
        <form class='form-style'  action="register.php" method="post" >
            <h2> Username </h2> <input type="text" name="username" value="<?php echo $username; ?>" required minlength='4' maxlength='40'/>
                                <span class = "error"><?php echo $usernameErr;?></span>

            <h2> Student ID </h2> <input type="text" name="studentID" value="<?php echo $studentID; ?>" required minlength='7' maxlength='7'/>
                              <span class = "error"><?php echo $studentIDErr;?></span>
            
            <h2> Password  </h2><input type="password" name="password" value="<?php echo $password; ?>" 
            required required minlength='6' maxlength='10' />
                                <span class = "error"><?php echo $passwordErr;?></span>

                         <input class="buttonSub" type="submit" name="submit" value="Sign up"/>

                         <span class = "error"><?php echo $alreadyExit;?></span>

            
        </form>    	
   </div>
   <br>
</div>
<?php
include('footer.php'); 
?>
</body>
</html>