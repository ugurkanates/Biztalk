<?php
   include('dashboard_user.php');

   if (!isset($_GET['numberofip'])) {
       header('Location: addUsrJob.php');
   }

	$IPs = $_GET['numberofip'];
?>

<form method="POST" action="addUsrJob3.php" enctype="multipart/form-data">
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
	                                	<input class="form-control mb-4" required type="text" id="ipNo" name="ip[]" placeholder="IP  <?php echo $i + 1 ?>">
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
                                        <input type="file" class="custom-file-input" id="fileUrl" name="fileUrl" required>
                                        <label class="custom-file-label" id='chooseFilePlace' for="fileUrl">Choose File</label>
                                    </div>   
	                            </div>


	                            <script type="text/javascript">
    								$(document).ready(function(){
       									$('input[name="fileUrl"]').change(function(e){
            								var fileName = e.target.files[0].name;
           									document.getElementById("chooseFilePlace").innerText = fileName;

        								});
    								});

								</script>

				

	                            <br>
	                            
	                            <div class="custom-control custom-checkbox custom-control-inline">
	                            <input  class="custom-control-input" type="checkbox" name="enableRuleSection" id="enableRuleSection" onclick="enableRule(this);" />
	                            <input type="hidden" value="no" name="checkBox" id="chckBx">
                                    <label class="custom-control-label" for="enableRuleSection">Add a Rule ?</label>
                                </div>
	                            
	                            <script type="text/javascript">
	                            	function enableRule(fth){
	                            		var res = fth.checked;
	                            		console.log(res);
	                            		var ruleSct = document.getElementById("ruleSection");
	                            		if(res){
	                            			document.getElementById("chckBx").value = "yes";
	                            			ruleSct.setAttribute("style", "visibility: visible;");
	                            			document.getElementById("relatives").required = true;
	                            			document.getElementById("field").required = true;
	                            			document.getElementById("inputid").required = true;
	                            			document.getElementById("EntryText").required = true;

	                            		}else{
	                            			document.getElementById("chckBx").value = "no";
	                            			ruleSct.setAttribute("style", "visibility: hidden;");
	                            			document.getElementById("relatives").required = false;
	                            			document.getElementById("field").required = false;
	                            			document.getElementById("inputid").required = false;
	                            			document.getElementById("EntryText").required = false;
	                            		}
	                            		console.log(document.getElementById("chckBx").value);
	                            	}
	                            </script>
			                 	<div name="ruleSection" id="ruleSection" class="col-6 mt-5" style="visibility: hidden;">

                            		<label for="example-relatives-input" class="col-form-label"><strong>Relatives</strong></label>
     	                        	<div class="frmSearch">
										<input autocomplete="off" class="form-control mb-4" type="text" name="relatives" id="relatives">
										<div class="form-row" id="suggesstion-box"></div>
									</div>
     	                        	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
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
										}
										);
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
										function selectRelative(val) {
											$("#relatives").val(val);
											$("#suggesstion-box").hide();
										}
									</script>
				                        
	                                <h4 class="header-title">Rule</h4>
                                    <input type="radio" name='field' id='field' value="asText" onclick="ShowHideDivText()"/> Type CNF Rule as Text
                                    <br>
                                    <div class="card-body" id="asTextField" style="display: none;">
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="EntryText" placeholder="Type Cnf.." name="EntryText">
                                        </div>
                                    </div>

                                    <br>

                                    <input type="radio" name='field' id='field' value="asFile" onclick="ShowHideDivFile()"/> Upload CNF file                                   
                                    <div class="card-body" id="asFileField" style="display: none">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile02" name="inputGroupFile02">
                                                <label class="custom-file-label" id='cnfFilePlace' for="inputGroupFile02">Choose file</label>
                                            </div>
                                        </div>  
	                                    <script type="text/javascript">
	                                    
	                                    	$(document).ready(function(){
       											$('input[name="inputGroupFile02"]').change(function(e){
            										var fileName2 = e.target.files[0].name;
           										 	
           											document.getElementById("cnfFilePlace").innerText = fileName2;
		
        										});
    										});

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
				            	<br>
	                        	<button type="submit" class="btn btn-primary btn-lg btn-block">Add Job</button>  
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php 
	$passedJobDescription = $_GET['jobDescription'];
	echo "<input type='hidden' name='ipNum' id='ipNum' value='$IPs'/>";
	echo "<input type='hidden' name='jobDescription' id='jobDescription' value='$passedJobDescription'/>";
	?>
</form>
