<?php
   include('session.php');  
   if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 

    $orcId = $maxOrcID;
	$sqlJob = "SELECT id,jobId,description FROM orcJobs WHERE orchestrations_id = '".$orcId."'";
	$sqlRule = "SELECT id,ruleId,ruleName FROM orcRules WHERE orchestrations_id = '".$orcId."'";
	$sqlEnd = "SELECT id,endNode FROM orcEndNode WHERE orchestrations_id = '".$orcId."'";
	$sqlOrc = "SELECT startJobId FROM orchestrations WHERE id = '".$orcId."'";
	$sql_f_edges = "SELECT * FROM orcFollowsEdge WHERE orchestrations_id = '".$orcId."'";
	$sql_f_edges2 = "SELECT * FROM orcFollowsEdge";
	$sqlTst1 = "SELECT * FROM orcJobs WHERE orchestrations_id = 52";
	$sqlTst2 = "SELECT id,ruleId,ruleName FROM orcRules WHERE orchestrations_id = 48";


	$resultJob = $db->query($sqlJob);
	$resultJob2 = $db->query($sqlJob);
	$resultRule = $db->query($sqlRule);
	$resultEnd = $db->query($sqlEnd);
	$resultOrc = $db->query($sqlOrc);
	$resultFollows = $db->query($sql_f_edges);
	$testJobs = $db->query($sqlTst1);
	$testJobs2 = $db->query($sqlTst1);
	$testRules = $db->query($sqlTst2);
	
	$data = array();
	if ($resultFollows->num_rows > 0) {
		while($rowFollows = $resultFollows->fetch_assoc()) {    
			$data[] = $rowFollows;
		}
	}

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
            <form action="addFollows.php" method="POST" onsubmit="return validateMyForm();">
                <div class="form-group">
					<label class="col-form-label">Starting Node</label>
						<select class="custom-select" id="followsStartingNode" onchange="avoidDpt(this)" name="followsStartingNode" >
						<option value="-1" selected="true" disabled="disabled">Choose Node</option> 
						<?php		
							if ($resultJob->num_rows > 0) {
								while($row = $resultJob->fetch_assoc()) {
									$existJob = false;		
									$sJob = $row["jobId"];
									foreach ($data as $key => $value) {
										if($value['startingNode'] == $sJob){
											$existJob = true;
										}
									}

									if($existJob == false){
										echo "<option value='$sJob'>(JOB) ".$sJob." - ".$row["description"]."</option>";
									}
								}
							}

							if ($resultOrc->num_rows > 0) {
								while($orc = $resultOrc->fetch_assoc()) {
									$startJobId = $orc["startJobId"];
								}
							}
							
							
						?>
						</select>
						<input type='hidden' id='sNodeType' name='sNodeType' value='J'>
				</div>
				<div class='form-group'>
					<label class='col-form-label'>Reaching Node</label>
						<select class="custom-select" id="followsReachingNode" name="followsReachingNode" onchange="val(this)">
						<option value="-1" selected="true" disabled="disabled">Choose Node</option> 
						<?php
							if ($resultJob2->num_rows > 0) {
								while($row = $resultJob2->fetch_assoc()) {
									$pivot = $row['jobId'];
									$jobId = $row['id'];

									if($startJobId != $jobId){
										echo "<option Ntype='J' value= '$pivot'>(JOB) ".$pivot." - ".$row["description"]."</option>";
									}
								}
							}

							if ($resultRule->num_rows > 0) {
								while($rowRule = $resultRule->fetch_assoc()) {
                                    $pivot2 = $rowRule['ruleId'];
									echo "<option Ntype='R' value= '$pivot2'> (RULE) ".$pivot2." - ".$rowRule["ruleName"]."</option>";
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
						<input type="hidden" id="rNodeType" name="rNodeType" value="-"> 
				</div>
				<input class="btn btn-primary mt-4 pl-4 pr-4" type="submit" value="Add Follows Edge" name="sbtn" id="sbtn">				
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
	
	function avoidDpt(uc){
		
		var res=uc.value;
		var select = document.getElementById("followsReachingNode").getElementsByTagName("option");
		
		select[0].selected = true;
		for (var i = 0; i < select.length; i++){
			var type = select[i].getAttribute("Ntype");
			console.log(select[i].value +" - "+ type);
			if(type == "J"){
				(select[i].value == res)
					? select[i].disabled = true
					: select[i].disabled = false;
			}
		}
		/*select.forEach(function(element){
			alert(element);
			if(element.value == res){
				element.disabled = true;
			}
		});*/
	}
	
	
    function val(fth){
                                                                                       
		
		var type = fth.options[fth.selectedIndex].getAttribute("Ntype");
        document.getElementById("rNodeType").value = type;
	}
	
	function validateMyForm(){
		var res1 = document.getElementById("followsStartingNode").value;
		var res2 = document.getElementById("followsReachingNode").value;
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