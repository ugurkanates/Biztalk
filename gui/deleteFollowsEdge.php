
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
   if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
       error_reporting(E_ALL); ini_set('display_errors', 1);

	if($_SERVER["REQUEST_METHOD"] == "POST") {

        $del_key = mysqli_real_escape_string($db,$_POST['edgeToDel']);

        $sql = "DELETE FROM orcFollowsEdge WHERE id=$del_key";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully Deleted a Follows edge.
            </div>";
		
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

    $orcId = $maxOrcID;
	$follows_Sql = "SELECT r.ruleName ,j.description,j.jobId, r.ruleId,f.id,f.reachingNodeType, f.startingNode ,f.reachingNode FROM orcJobs j , orcRules r , orcFollowsEdge f WHERE (j.jobId = f.startingNode and r.ruleId = f.reachingNode) and (j.orchestrations_id = $orcId and r.orchestrations_id = $orcId and f.orchestrations_id = $orcId)";

	$result = $db->query($follows_Sql);

	
?>


<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
                <div class="form-group">
				
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="text-uppercase bg-danger">
                                <tr class="text-white">
                                    <th scope="col">Starting Node</th>
                                    <th scope="col">Reaching Node</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>                                  
                            <form method="POST" action="deleteFollowsEdge.php">
								<?php						

									if ($result->num_rows > 0) {
										while($row = $result->fetch_assoc()) {
											$del_key = $row['id'];
											echo "<tr>";
											echo "<td>(JOB) ".$row['startingNode']." - ".$row['description']."</td>";
											if ($row['reachingNodeType'] == 'R')
												echo "<td>(RULE) ".$row['reachingNode']." - ".$row['ruleName']."</td>";
											if ($row['reachingNodeType'] == 'J')
												echo "<td>(JOB) ".$row['reachingNode']." - ".$row['description']."</td>";																							
											echo "<td><button type='submit' class='btn btn-danger'><i class='ti-trash'></i>Delete</button></td>";
											echo "</tr>";
											echo "<input type='hidden' name='edgeToDel' id='edgeToDel' value='$del_key'/>";
										}
									}
								?>
								
							</form>
                            </tbody>
                        </table>
                    </div>
                </div>				

        </div>
    </div>
</div>



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