<?php
	include('dashboard_user.php');
	// echo '<pre>'; print_r($_POST); echo '</pre>';
    error_reporting(E_ALL); ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $ipNum = mysqli_real_escape_string($db,$_POST['ipNum']);
        $jobID = mysqli_real_escape_string($db,$_POST['jobID']);
        $jobDescription = mysqli_real_escape_string($db,$_POST['jobDescription']); 
        $fileUrl = mysqli_real_escape_string($db,$_POST['fileUrl']); 
    	$ips = $_POST['ip'];
        $jobOwner = mysqli_real_escape_string($db,$_POST['jobOwner']);

        $ipString = "";
        foreach( $ips as $key => $n ) {
			$ipString = $ipString.$n.",";
		} 
		$ipString = rtrim($ipString, ',');

        $ruleID = mysqli_real_escape_string($db,$_POST['RuleID']);
        
        if($_POST['EntryText'] != "")
            $query = mysqli_real_escape_string($db,$_POST['EntryText']);
        else{
            $fileName = realpath($_FILES['inputGroupFile02']['tmp_name']);
            $queryFile = fopen($fileName, "r") or die("Unable to open file!");
            $query = fread($queryFile,filesize($fileName));
            fclose($queryFile);
        }
		
        $sql = "INSERT INTO tbl_jobs (id, owner, description, destination, fileUrl, ruleID, query)
        VALUES ('$jobID', '$login_session', '$jobDescription', '$ipString', '$fileUrl','$ruleID','$query')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully added a Job.
            </div>"; 
            echo "<a href='addUsrJob.php'><button class='btn btn-primary mb-3'>Add New Job</button></a>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

?>
<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>

<!-- others plugins -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>

</body>