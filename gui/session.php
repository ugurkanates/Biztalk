<?php
   include('config.php');
	  
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 

	$wdslIP = "10.1.90.19";

   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select id,username,type from tbl_usr where username = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['username'];
   $login_type = $row['type'];
   $login_id = $row['id'];

   $orc_sql = mysqli_query($db,"SELECT * FROM orchestrations WHERE owner=$login_id ORDER BY id DESC LIMIT 1");
   $row2 = mysqli_fetch_array($orc_sql,MYSQLI_ASSOC);

   $maxOrcID = $row2['id'];
   $exStartJobId = $row2['startJobId'];

   if(!isset($_SESSION['login_user'])){
      header("location:index.html");
   }
?>