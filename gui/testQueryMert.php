<?php 
include('session.php');

$jobIdSql = "SELECT `description` FROM `tbl_jobs` WHERE `id` = 1";

$resultDesc = $db->query($jobIdSql);
if ($resultDesc->num_rows > 0) {
	$row = $resultDesc->fetch_assoc();
	echo "Specified id's Description : ".$row['description']."<br>";

}

?>


