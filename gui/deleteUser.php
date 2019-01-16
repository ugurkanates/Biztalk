<?php

include("config.php");
error_reporting(E_ALL); ini_set('display_errors', 1);

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$myDelIndex = mysqli_real_escape_string($db,$_POST['delIndex']);

	$sql = "DELETE FROM tbl_usr WHERE id='$myDelIndex'";

	if ($db->query($sql) === TRUE) {
        header("location: manageUsers.php");
	} else {
		echo "Error deleting record: " . $db->error;
	}
}
?>