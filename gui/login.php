<?php
   include("config.php");
   session_start();
   //error_reporting(E_ALL); ini_set('display_errors', 1);
   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
   //   $passwordHash = sha1($_POST['mypassword']);
      $sql = "SELECT id,type FROM tbl_usr WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         if ($row["type"] == "user")
            header("location: dashboard_user.php");
         if ($row["type"] == "manager")
            header("location: dashboard_manager.php");
         else if ($row["type"] == "admin")
            header("location: home.php");
      }else {
            header("location: access_denied.html");
      }
   }
?>
