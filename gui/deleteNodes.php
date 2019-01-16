<?php
include ('config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){  

    $del_follows_key = $_POST['del_follows_id'];
    $del_LeadsTo_key = $_POST['del_LeadsTo_id'];

    $del_job_key =     $_POST['del_job_id'];
    $del_rule_key =    $_POST['del_rule_id'];
    $del_end_key =     $_POST['del_end_id'];

    $sql_del_F = "DELETE FROM orcFollowsEdge WHERE id='".$del_follows_key."'";
    $sql_del_L = "DELETE FROM orcLeadsToEdge WHERE id='".$del_LeadsTo_key."'";

    $sql_del_J = "DELETE FROM orcJobs WHERE id='".$del_job_key."'";
    $sql_del_R = "DELETE FROM orcRules WHERE id='".$del_rule_key."'";
    $sql_del_end = "DELETE FROM orcEndNode WHERE id='".$del_end_key."'";

    if ($db->query($sql_del_F) === TRUE ) {

	
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    if ($db->query($sql_del_L) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    if ($db->query($sql_del_J) === TRUE) {
    	if ($exStartJobId == $del_job_key){
    		$remove_start_job_sql = "UPDATE `orchestrations` SET `startJobId`= NULL";
    		if ($db->query($remove_start_job_sql) === TRUE){
    			echo "<div class='alert alert-info' role='alert'>
             <strong>Notice !</strong> Starting Job has been REMOVED.
         </div>";
    		}
    	}

	
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    if ($db->query($sql_del_R) === TRUE) {
	
    }else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    if ($db->query($sql_del_end) === TRUE) {
 
    }else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

}
?>