<!doctype html>
<html class="no-js" lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BizTalk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
<?php
	include('session.php');
	// echo '<pre>'; print_r($_POST); echo '</pre>';
    error_reporting(E_ALL); ini_set('display_errors', 1);
    
    if(isset($_FILES['fileUrl'])){
        $errors= array();
       // $target = $_POST['fileUrl'];
        $file_name = $_FILES['fileUrl']['name'];
        $file_size = $_FILES['fileUrl']['size'];
        $file_tmp = $_FILES['fileUrl']['tmp_name'];
        $file_type = $_FILES['fileUrl']['type'];
    
        //$file_ext=strtolower(end(explode('.',$file_name)));

        /*$expensions= array("jpeg","jpg","png","pdf");

        if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        */
        if($file_size > 2097152) {
            $errors[]='File size must be excately 2 MB';
        }

        if(empty($errors)==true) {
            move_uploaded_file($file_tmp,"IncomingFiles/".$file_name);
            /* echo "Success";
            echo "Stored in: " . $_SERVER['SERVER_NAME'] ."/incomingFile/" . $_FILES["file"]["name"];*/
            $fileURL = "http://" .$_SERVER['SERVER_NAME'] ."/BiztalkGUI/IncomingFiles/" . $_FILES["fileUrl"]["name"];
           // echo "debug1";
            //echo '<a href='.$fileURL.'>'.$fileURL.'</a>';
            
        }else{
            print_r($errors);
        }


    }


    if($_SERVER["REQUEST_METHOD"] == 'POST') {


        if (isset($_POST['ipNum']))
            $ipNum = $_POST['ipNum'];
        if (isset($_POST['relatives']))
           $relatives = $_POST['relatives']; 
        if (isset($_POST['jobDescription']))
            $jobDescription = $_POST['jobDescription']; 

        $fileUrl = $fileURL; 
        if (isset($_POST['isStartJob']))
            $startJob = $_POST['isStartJob'];

        if (isset($_POST['ip']))
            $ips = $_POST['ip'];
        if (isset($_POST['message']))
            $messages = $_POST['message'];
                

        $ipString = "";

        foreach( $ips as $key => $n ) {
			$ipString = $ipString.$n.",";
		} 

		$ipString = rtrim($ipString, ',');

        $messageString = "";
        foreach( $messages as $key => $n ) {
            $messageString = $messageString.$n."~";
        } 
        $messageString = rtrim($messageString, '~');
		
        //For current job id of current orchestration
        //echo "THE NEW ORCHID = ".$maxOrcID."<br>";

        $sqlJobId = "SELECT * FROM orcJobs WHERE orchestrations_id = $maxOrcID";
        $resSqlJobId = mysqli_query($db, $sqlJobId);
        $resSqlJobIdArr = mysqli_fetch_all($resSqlJobId, MYSQLI_ASSOC);
        $jobId = 0;
        if($resSqlJobId->num_rows == 0){
            $jobId = 1;
        }
        else{
            $jobId = $resSqlJobIdArr[($resSqlJobId->num_rows)-1]['jobId'] + 1;
        }

        $sql = "INSERT INTO orcJobs (jobId, orchestrations_id, owner, description, destination, fileUrl,relatives,messages)
        VALUES ('$jobId', '$maxOrcID', '$login_id', '$jobDescription', '$ipString', '$fileUrl','$relatives','$messageString')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong>Job has been successfully added.
            </div>";

        if ($startJob == "yes") {
            $startJobID_sql = mysqli_query($db,"SELECT * FROM orcJobs ORDER BY id DESC LIMIT 1");
            $job_row = mysqli_fetch_array($startJobID_sql,MYSQLI_ASSOC);
            $startJobId = $job_row['jobId'];
            $insert_startJobID_sql = mysqli_query($db,"UPDATE orchestrations SET startJobId=$startJobId WHERE id=$maxOrcID");
        }
            //header( "refresh:1; url=addOrcJob.php" );
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