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
    
    include("session.php");
    error_reporting(E_ALL); ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $snode = mysqli_real_escape_string($db,$_POST['leadsToStartingNode']);
        $rnode = mysqli_real_escape_string($db,$_POST['leadsToReachingNode']);
		$sNodeType = mysqli_real_escape_string($db,$_POST['sNodeType']);
		$rNodeType = mysqli_real_escape_string($db,$_POST['rNodeType']);
        $yesNoField = mysqli_real_escape_string($db,$_POST['yesNoField']);
        $orcId = $maxOrcID;
        $checkYesNoField = "SELECT * FROM orcLeadsToEdge WHERE orchestrations_id = '$orcId' AND startingNode = '$snode' AND yesNoType = '$yesNoField' ";
        #$ruleYesNo = "SELECT yes, no FROM orcRules WHERE id = '$snode' ";
        #$resultYesNo = $db->query($ruleYesNo);
        $resultYesNo = $db->query($checkYesNoField);
        #$rule = $resultYesNo->fetch_assoc();
        /*if($rule[$yesNoField] != NULL){
    		echo "<div class='alert alert-fail' role='alert'>
                <strong>Sorry!</strong> You can't build a new ".$yesNoField." edge between these nodes. It already exists.
            </div>";
        	header( "refresh:2; url=leadsTo.php" );
        }*/
        $res = $resultYesNo->fetch_assoc();
        if($res != NULL){
            echo "<div class='alert alert-fail' role='alert'>
                <strong>Sorry!</strong> You can't build a new ".$yesNoField." edge between these nodes. It already exists.
            </div>";
            header( "refresh:2; url=leadsTo.php" );
        }
        else{
            $sql = "INSERT INTO orcLeadsToEdge (startingNode, orchestrations_id, reachingNode, reachingNodeType, startingNodeType, yesNoType)
            VALUES ('$snode','$orcId','$rnode', '$rNodeType', '$sNodeType', '$yesNoField')";

            if ($db->query($sql) === TRUE) {
            	/*$lastLeadsToEdgeId = $db->insert_id;
            	echo $lastLeadsToEdgeId;
            	if($yesNoField == "yes"){
        			$sql2 = "UPDATE orcRules SET yes = '$lastLeadsToEdgeId' WHERE id = '$snode' ";
	        	}
	        	else if ($yesNoField == "no") {
	        		$sql2 = "UPDATE orcRules SET no = '$lastLeadsToEdgeId' WHERE id = '$snode' ";
	        	}*/
                echo "<div class='alert alert-success' role='alert'>
                    <strong>Well done!</strong> You successfully added a Leads To edge.
                </div>";
                header( "refresh:1; url=leadsTo.php" );

	        	/*if ($db->query($sql2) === TRUE) {
	        		echo "<div class='alert alert-success' role='alert'>
                    <strong>And you successfully updated orcRule table for yes/no edge
                	</div>";
	        	}*/
                
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }        
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
