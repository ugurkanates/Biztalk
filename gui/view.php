<?php
   include('session.php');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
	$orcId = $maxOrcID;

	$sql_jobs = "SELECT * FROM orcJobs WHERE orchestrations_id = '".$orcId."'";
	$sql_rules = "SELECT * FROM orcRules WHERE orchestrations_id = '".$orcId."'";
	$sql_ends = "SELECT * FROM orcEndNode WHERE orchestrations_id = '".$orcId."'";
	$sql_f_edges = "SELECT * FROM orcFollowsEdge WHERE orchestrations_id = '".$orcId."'";
	$sql_l_edges = "SELECT * FROM orcLeadsToEdge WHERE orchestrations_id = '".$orcId."'";
	
    $resultJob = $db->query($sql_jobs);
	$resultRule = $db->query($sql_rules);
	$resultEnd = $db->query($sql_ends);
	$resultFollows = $db->query($sql_f_edges);
	$resultLeadsTo = $db->query($sql_l_edges);
	
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
	<!-- Flush start -->
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">Information</h4>
				<ul class="list-group list-group-flush">
					<?php
						$i=1;
						
						if ($resultJob->num_rows == 0 && $resultRule->num_rows == 0 && $resultEnd->num_rows == 0 && $resultFollows->num_rows == 0 && $resultLeadsTo->num_rows == 0){
							echo "<div class='alert alert-primary' role='alert'>
							    <h4 class='alert-heading'>Whopps !</h4>
							    <p>You Don't have any Node nor Edges to Delete yet.</p>
							    <hr>
							    <p class='mb-0'>Please add some then come back here.</p>
							</div>";
						}

						if ($resultJob->num_rows > 0) {
							while($rowJob = $resultJob->fetch_assoc()) {
								$del_job_key = $rowJob['id'];

								echo "<form method='POST' action='deleteJobNode.php'>";
										echo "<div class='col-md-6'>";
											echo "<div class='row'>";
												echo "<table style='width:100%'>";
													$value = $rowJob["jobId"];
													$Node[$i] = "J".$value;
													echo "<tr>";
														echo "<td style='width:80%;'>";
															echo'<li class="list-group-item">Node'.$i.': JOB<'.$value.'></li>';
														echo "</td>";
														$i++;
														echo "<input type='hidden' name='del_job_id' id='del_job_id' value='$del_job_key'/>";
														echo "<td>";
															echo "<button type='submit' class='btn btn-danger'>Delete</button>";
														echo "</td>";
													echo "</tr>";
														
												echo "</table>";
											echo "</div>";
										echo "</div>";
								echo "</form>";								
							}
						}
						
						if ($resultRule->num_rows > 0) {
							while($rowRule = $resultRule->fetch_assoc()) {
								$del_rule_key = $rowRule['id'];
								echo "<form method='POST' action='deleteRuleNode.php'>";
										echo "<div class='col-md-6'>";
											echo "<div class='row'>";
												echo "<table style='width:100%'>";
													echo "<tr>";
															$value = $rowRule["ruleId"];
															$Node[$i] = "R".$value;
															echo "<td style='width:80%;'>";
																echo'<li class="list-group-item">Node'.$i.': RULE<'.$value.'></li>';
															echo "</td>";
															$i++;
															echo "<input type='hidden' name='del_rule_id' id='del_rule_id' value='$del_rule_key'/>";
															echo "<td>";
																echo "<button type='submit' class='btn btn-danger'>Delete</button>";
															echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</div>";
										echo "</div>";
								echo "</form>";														
							}
						}
						if ($resultEnd->num_rows > 0) {
							while($rowEnd = $resultEnd->fetch_assoc()) {
								$del_end_key = $rowEnd['id'];
								echo "<form method='POST' action='deleteEndNode.php'>";
										echo "<div class='col-md-6'>";
											echo "<div class='row'>";
												echo "<table style='width:100%'>";
													echo "<tr>";
															$value = $rowEnd["id"];
															$Node[$i] = "E".$value;
															echo "<td style='width:80%;'>";
																echo'<li class="list-group-item">Node'.$i.': END<'.$value.'></li>';
															echo "</td>";
															$i++;
															echo "<input type='hidden' name='del_end_id' id='del_end_id' value='$del_end_key'/>";
															echo "<td>";
																echo "<button type='submit' class='btn btn-danger'>Delete</button>";
															echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</div>";
										echo "</div>";
								echo "</form>";
							}
						}
						$k = 1;
						if ($resultFollows->num_rows > 0) {
							while($rowFollows = $resultFollows->fetch_assoc()) {
								echo "<form method='POST' action='deleteFollowsNode.php'>";

								$del_follows_key = $rowFollows['id'];
								$value1 = $rowFollows["startingNodeType"].$rowFollows["startingNode"];
								$value2 = $rowFollows["reachingNodeType"].$rowFollows["reachingNode"];
								$SNodeIndex = 0;
								$RNodeIndex = 0;
								foreach($Node as $key=>$value) {
									if($value == $value1)
										$SNodeIndex = $key;
									if($value == $value2)
										$RNodeIndex = $key;
								}
									echo "<div class='col-md-6'>";
										echo "<div class='row'>";
											echo "<table style='width:100%'>";
												echo "<tr>";
													echo "<td style='width:80%;'>";
														echo'<li class="list-group-item">Edge'.$k.': FOLLOWS Node'.$SNodeIndex.', Node'.$RNodeIndex.'</li>';
													echo "</td>";
													echo "<input type='hidden' name='del_follows_id' id='del_follows_id' value='$del_follows_key'/>";
													echo "<td>";
														echo "<button type='submit' class='btn btn-danger'>Delete</button>";
													echo "</td>";
												echo "</tr>";
											echo "</table>";
										echo "</div>";
									echo "</div>";
								echo "</form>";
								$k++;
							}
						}

						if ($resultLeadsTo->num_rows > 0) {
							while($rowLeadsTo = $resultLeadsTo->fetch_assoc()) {
								echo "<form method='POST' action='deleteLeadsToNode.php'>";

								$del_LeadsTo_key = $rowLeadsTo['id'];
								$value1 = $rowLeadsTo["startingNodeType"].$rowLeadsTo["startingNode"];
								$value2 = $rowLeadsTo["reachingNodeType"].$rowLeadsTo["reachingNode"];
								$SNodeIndex = 0;
								$RNodeIndex = 0;
								foreach($Node as $key=>$value) {
									if($value == $value1)
										$SNodeIndex = $key;
									if($value == $value2)
										$RNodeIndex = $key;
								}
								echo "<form method='POST' action='deleteLeadsToNode.php'>";
									echo "<div class='col-md-6'>";
										echo "<div class='row'>";
											echo "<table style='width:100%'>";
												echo "<tr>";
													echo "<td style='width:80%;'>";
														echo'<li class="list-group-item">Edge'.$k.': LEADSTO Node'.$SNodeIndex.', Node'.$RNodeIndex.'</li>';
													echo "</td>";
													echo "<input type='hidden' name='del_LeadsTo_id' id='del_LeadsTo_id' value='$del_LeadsTo_key'/>";
													echo "<td>";
														echo "<button type='submit' class='btn btn-danger'>Delete</button>";
													echo "</td>";
												echo "</tr>";
											echo "</table>";
										echo "</div>";
									echo "</div>";
								echo "</form>";
								$k++;
							}
						}						
					?>
				</ul>
			</div>
		</div>
	</div>
	<!-- Flush end -->

	
</body>
</html>