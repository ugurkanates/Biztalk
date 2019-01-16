<?php
   include('dashboard_user.php');

   if (!isset($_GET['numberofip'])) {
       header('Location: z1.php');
   }

	$IPs = $_GET['numberofip'];
?>

<form method="POST" action="addUsrJob3.php">
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
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fileUrl" name="fileUrl">
                                        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                    </div>   
	                            </div>
	                            <br></br>


				                <div class="form-group">
				                    <label for="example-text-input" class="col-form-label">RuleID</label>
				                    <input class="form-control" type="text" id="RuleID" name="RuleID">
				                </div>
				          
				                 <div class="col-lg-6 mt-5">
				                        <div class="card">
				                            <div class="card-body">
				                                <h4 class="header-title">Relatives</h4>
				                                    <input type="radio" name='field' id='field' value="asText" onclick="ShowHideDivText()"/> Type CNF Rule as Text
				                                    <br></br>
				                                    <div class="card-body" id="asTextField" style="display: none;">
				                                        <div class="form-group">
				                                            <input class="form-control" type="text" id="EntryText" placeholder="Type Cnf.." name="EntryText">
				                                        </div>
				                                    </div>

				                                    <input type="radio" name='field' id='field' value="asFile" onclick="ShowHideDivFile()"/> Upload CNF file                                   
				                                    <div class="card-body" id="asFileField" style="display: none">
				                                        <div class="input-group mb-3">
				                                            <div class="custom-file">
				                                                <input type="file" class="custom-file-input" id="inputGroupFile02" name="inputGroupFile02">
				                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
				                                            </div>
				                                        </div>  
				                                    </div>
				                                    <script type="text/javascript">
				                                        function ShowHideDivText() {
				                                            var field = document.getElementById("field");
				                                            var text = document.getElementById("asTextField");
				                                            var file = document.getElementById("asFileField");
				                                            text.style.display = "block";
				                                            file.style.display = "none";
				                                        }
				                                        function ShowHideDivFile() {
				                                            var field = document.getElementById("field");
				                                            var text = document.getElementById("asTextField");
				                                            var file = document.getElementById("asFileField");
				                                            text.style.display = "none";
				                                            file.style.display = "block";
				                                        }
				                                    </script>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                
				                
				                <br/>

		                        <button type="submit" class="btn btn-primary btn-lg btn-block">Add Job</button>  
	                        </div>
	                    </div>
	                </div>
	                <!-- Input Sizes Rounded end -->
	            </div>
	        </div>
	    </div>
	</div>
	<?php 
	$passedJobID = $_GET['jobID'];
	$passedJobDescription = $_GET['jobDescription'];
	$passedJobOwner = $_GET['jobOwner'];
	echo "<input type='hidden' name='ipNum' id='ipNum' value='$IPs'/>";
	echo "<input type='hidden' name='jobOwner' id='jobOwner' value='$passedJobOwner'/>";
	echo "<input type='hidden' name='jobID' id='jobID' value='$passedJobID'/>";
	echo "<input type='hidden' name='jobDescription' id='jobDescription' value='$passedJobDescription'/>";
	?>
</form>
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
