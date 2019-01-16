<?php


   $db_user = "localhost:3306";
   $db_username = "root";
   $db_password ="my-secret-pw";
   $db_database="biztalk_gui";

	// Create connection
	$db = new mysqli($db_user, $db_username,$db_password, $db_database);
	// Check connection
	if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
} ?>
