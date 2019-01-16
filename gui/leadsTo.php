<?php
   include('session.php');  
   if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 


    $orcId = $maxOrcID;


	$sqlJob = "SELECT id,jobId,description FROM orcJobs WHERE orchestrations_id = '".$orcId."'";
	$sqlRule = "SELECT id,ruleId,ruleName FROM orcRules WHERE orchestrations_id = '".$orcId."'";
	$sqlEnd = "SELECT id,endNode FROM orcEndNode WHERE orchestrations_id = '".$orcId."'";
	
	$resultJob = $db->query($sqlJob);
	$resultRule = $db->query($sqlRule);
	$resultEnd = $db->query($sqlEnd);
	
    $db->close();
?>

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


<!-- basic form start -->

<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <form action="addLeadsTo.php" method="POST" onsubmit="return validateMyForm();">
                <div class="form-group">
					<label class="col-form-label">Starting Node</label>
						<select class="custom-select" id="leadsToStartingNode" name="leadsToStartingNode" >
						<option value="-1" selected="true" disabled="disabled">Choose Node</option> 
						<?php						
						
							if ($resultRule->num_rows > 0) {
								while($row = $resultRule->fetch_assoc()) {
                                    $pivot = $row['ruleId'];
									echo "<option value= '$pivot'>(RULE) ".$pivot." - ".$row["ruleName"]."</option>";
								}
							}
						?>
						</select>
						<input type='hidden' id='sNodeType' name='sNodeType' value='R'>
				</div>
				<div class='form-group'>
					<label class='col-form-label'>Reaching Node</label>				
						<select class="custom-select" id="leadsToReachingNode" name="leadsToReachingNode" onchange="val(this)">
						<option value="-1" selected="true" disabled="disabled">Choose Node</option> 
						<?php
							
							if ($resultJob->num_rows > 0) {
								while($rowJob = $resultJob->fetch_assoc()) {
                                    $pivot1 = $rowJob['jobId'];
									echo "<option Ntype='J' value= '$pivot1'>(JOB) ".$pivot1." - ".$rowJob['description']."</option>";
								}
							}

							if ($resultEnd->num_rows > 0) {
								while($rowEnd = $resultEnd->fetch_assoc()) {
                                    $pivot3 = $rowEnd['id'];
                                    $endValue = $rowEnd['endNode'];
									echo "<option Ntype='E' value= '$endValue'>(END) ".$pivot3."</option>";
								}
							}					
						?>
						</select>
						<label class='col-form-label'>Reaching Node Type</label>
									<br>	
                                    <input type="radio" name='yesNoField' id='yesNoField' value="yes""/> Yes
                                    <input type="radio" name='yesNoField' id='yesNoField' value="no""/> No
						<input type="hidden" id="rNodeType" name="rNodeType" value="-">
				</div>
				<input class="btn btn-primary mt-4 pl-4 pr-4" type="submit" value="Add Leads To Edge" name="sbtn" id="sbtn" onclick="check(this)">
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
	
    function val(fth){
        var res=fth.value;
		var type = fth.options[fth.selectedIndex].getAttribute("Ntype");
        document.getElementById("rNodeType").value = type;
	}
	
	function validateMyForm(){
		var res1 = document.getElementById("leadsToStartingNode").value;
		var res2 = document.getElementById("leadsToReachingNode").value;
		if(res1 == -1 || res2 ==-1){			
			alert("Choose Nodes!")
			return false;
		}
		return true;
	}
</script>

<!-- basic form end -->

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
</html>