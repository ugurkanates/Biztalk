<?php
   include('session.php');
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
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
    
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>

<form method="POST" action="addOrcJob3.php" enctype="multipart/form-data">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		$val = $_GET['startJob'];
		$IPs = $_GET['numberofip'];
		$passedJobDescription = $_GET['jobDescription'];

		echo "<input type='hidden' name='ipNum' id='ipNum' value='$IPs'/>";
		echo "<input type='hidden' name='jobDescription' id='jobDescription' value='$passedJobDescription'/>";

		if ($val == "yes"){
			$passedStartJob = $val;
			echo "<input type='hidden' name='isStartJob' id='isStartJob' value='$passedStartJob'/>";
		}
	}
?>
	<div class="main-content-inner">
	    <div class="row">
	                <!-- Input Sizes Rounded start -->
	                <div class="col-12 mt-5">
	                    <div class="card">
	                        <div class="card-body">
	                            <h4 class="header-title">Add Job Area Continue</h4>
	                            <?php
	                            for ($i=0; $i < $IPs; $i++) {
	                            ?>
	                            <div class="form-row align-items-center">                                       
	                                <div class="col-sm-5 my-1">
	                                	<input class="form-control mb-4 input-rounded" type="text" id="ipNo" name="ip[]" placeholder="IP <?php echo $i + 1 ?>" >
	                                </div>
	                                <div class="col-sm-7 my-2">
		                                <div class="input-group mb-3">
		                                    <div class="input-group-prepend">
		                                        <span class="input-group-text">Message</span>
		                                    </div>
		                                    <textarea id="message<?php echo $i + 1 ?>" name="message[]" class="form-control" aria-label="With textarea" style="margin-top: 0px; margin-bottom: 0px; height: 58px;"></textarea>
		                                </div>
	                                </div>
	                            </div>
	                            <?php
	                            }
	                            ?>
	                            <div class="input-group">
					            <div class="col-12 mt-5">

									<div class="frmSearch">
										<input class="form-control mb-4" autocomplete="off" type="text" id="relatives" name="relatives" placeholder="Relatives:"/>
										<div class="form-row" class="form-control mb-4" id="suggesstion-box"></div>
									</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fileUrl" name="fileUrl" required>
                                        <label class="custom-file-label" id="inputGroupFile04" for="inputGroupFile04">Choose file</label>
                                    </div> 
                                
                                </div>
	                            </div>
	                            <br></br>
		                        <button type="submit" class="btn btn-primary btn-lg btn-block">Add Job</button>
		                        <input type="button" class="btn btn-danger btn-lg btn-block" value="Back" onclick="history.back(-1)" />
	                        </div>
	                    </div>
	                </div>
	                <!-- Input Sizes Rounded end -->
	            </div>
	        </div>
	    </div>
	</div>

</form>

<!-- Auto-suggest script for relatives -->
<script>
	$(document).ready(function(){

		$("#relatives").keyup(function( evt ){
			if (evt.keyCode == 27) {
		        $("#suggesstion-box").hide();
		    }
		    else{
		    	var xhttp = new XMLHttpRequest();
				  	xhttp.onreadystatechange = function() {
					    if (this.readyState == 4 && this.status == 200) {
					      	$("#suggesstion-box").show();
							$("#suggesstion-box").html(this.responseText);
							$("#relatives").css("background","#FFF");
							
				    	}
				  	};
				  	xhttp.open("POST", "getHint.php", true);
				  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				  	xhttp.send("keyword="+$(this).val());
		    }
			
		});
		$("#relatives").mouseup(function(){
		var xhttp = new XMLHttpRequest();
		  	xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {

			      	$("#suggesstion-box").show();
					$("#suggesstion-box").html(this.responseText);
					$("#relatives").css("background","#FFF");
		    	}
		  	};
		  	xhttp.open("POST", "getHint.php", true);
		  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  	xhttp.send("keyword="+$(this).val());
			}

	);
	});
	
	function selectRelative(val) {
		$("#relatives").val(val);
		$("#suggesstion-box").hide();
	}
</script>

<!-- Show name script for file -->
<script type="text/javascript">
	$(document).ready(function(){
			$('input[name="fileUrl"]').change(function(e){
			var fileName = e.target.files[0].name;
				document.getElementById("inputGroupFile04").innerText = fileName;

		});
	});

</script>

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