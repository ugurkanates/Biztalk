<?php
   include ('dashboard_manager.php');
   include('session.php');
   error_reporting(E_ALL); ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $orcOwner = mysqli_real_escape_string($db,$_POST['orcOwner']);
        $sql = "INSERT INTO orchestrations (owner,startJobId) VALUES ('$orcOwner',NULL)";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong>Orchestration has been successfully created.
            </div>";

            //echo "<a href='addOrcJob.php'><button class='btn btn-primary mb-3'>Add New Job Node</button></a>";
            //echo "<a href='addOrcJob.php'>Add New Job Node</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }
    /*else{
    	$orcOwner = $login_id;
        $sql = "INSERT INTO orchestrations (owner) VALUES ('$orcOwner')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong>Orchestration has been successfully created.
            </div>";

            //echo "<a href='addOrcJob.php'><button class='btn btn-primary mb-3'>Add New Job Node</button></a>";
            //echo "<a href='addOrcJob.php'>Add New Job Node</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }
    */
?>

<!-- PAGE BODY -->
<form method="POST" action="orc3.php">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Orchestration</h4>
                <!-- MAIN ACCORDION -->
                <div class="row">
                	
                	<!-- ACCORDION 1 -->
	                <div class="col-md-6">
	                    <div id="accordion1" class="according">
						    <div class="card">
						        <div class="card-header">
						            <a class="card-link" data-toggle="collapse" href="#accordion11">Create Nodes</a>
						        </div>
						        <div id="accordion11" class="collapse show" data-parent="#accordion1">
						            <div class="card-body">
						            	<div class="row">
						            		<div class="col-md-6">
						            			<button onclick="refreshIframe('jobIframe');" type="button" class="btn btn-primary btn-lg btn-block mt-3" data-toggle="modal" data-target="#addJobPopUp">Add Job</button>
										        <!-- Modal -->
										        <div class="modal fade" id="addJobPopUp" aria-hidden="true" style="display: none;">
										            <div class="modal-dialog">
										                <div class="modal-content" style="width: 630px;height: 500px;">
										                    <div class="modal-header">
										                        <h5 class="modal-title">Add Job Node</h5>
										                        
										                    </div>
										                    <!-- THis is the popup's body 1-->
										                    <div class="modal-body">
										                        <iframe scrolling="yes" id="jobIframe" style="width: 600px; height: 350px;" src="addOrcJob.php"></iframe>
										                    </div>
										                    <div class="modal-footer">
					                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										                    </div>
										                    <!-- End of pop up message 1-->
										                </div>
										            </div>
										        </div>
						            		</div>
						            		<div class="col-md-6">
						            			<button onclick="refreshIframe('ruleIframe');" type="button" class="btn btn-primary btn-lg btn-block mt-3" data-toggle="modal" data-target="#addRulePopUp">Add Rule</button>
										        <!-- Modal -->
										        <div class="modal fade" id="addRulePopUp" aria-hidden="true" style="display: none;">
										            <div class="modal-dialog">
										                <div class="modal-content" style="width: 630px;height: 500px;">
										                    <div class="modal-header">
										                        <h5 class="modal-title">Add Rule Node</h5>
																	
										                    </div>
										                    <!-- THis is the popup's body 2-->
										                    <div class="modal-body">
										                    	<iframe  id="ruleIframe" scrolling="yes" style="width: 600px; height: 350px;" src="orcRule.php"></iframe>
										                    </div>
										                    <div class="modal-footer">
										                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										                    </div>
										                    <!-- End of pop up message 2-->
										                </div>
										            </div>
										        </div>
						            		</div>
						            		<div class="col-md-6">
						            			<button onclick="refreshIframe('endNodeIframe');" type="button" class="btn btn-secondary btn-lg btn-block mt-3" data-toggle="modal" data-target="#endPopup">END</button>
										        <!-- Modal -->
										        <div class="modal fade" id="endPopup" aria-hidden="true" style="display: none;">
										            <div class="modal-dialog">
										                <div class="modal-content" style="width: 630px;height: 500px;">
										                    <div class="modal-header">
										                        <h5 class="modal-title">End Node</h5>
										                    </div>

										                    <!-- THis is the popup's body 3-->
										                    <div class="modal-body">
										                    	<iframe id="endNodeIframe" scrolling="yes" style="width: 600px; height: 350px;" src="endOrc.php"></iframe>
										                    </div>										               
										                    <div class="modal-footer">
										                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										                    </div>
										                    <!-- End of pop up message 3-->
										                </div>
										            </div>
										        </div>
						            		</div>
						            	</div>
						            </div>
						        </div>
						    </div>
						</div>
	                </div>
	                <!-- END OF ACCORDION 1-->

                	<!-- ACCORDION 2 -->
	                <div class="col-md-6">
	                    <div id="accordion2" class="according">
						    <div class="card">
						        <div class="card-header">
						            <a class="card-link" data-toggle="collapse" href="#accordion12">Create Edges</a>
						        </div>
						        <div id="accordion12" class="collapse show" data-parent="#accordion2">
						            <div class="card-body">
						            	<div class="row">
						            		<div class="col-md-6">
						            			<button onclick="refreshIframe('followIframe');" type="button" class="btn btn-primary btn-lg btn-block mt-3" data-toggle="modal" data-target="#followsPopUp" id="followsButtonID">Follows</button>
										        <!-- Modal -->
										        <div class="modal fade" id="followsPopUp" aria-hidden="true" style="display: none;">
										            <div class="modal-dialog">
										                <div class="modal-content" style="width: 630px;height: 500px;">
										                    <div class="modal-header">
										                        <h5 class="modal-title">Follows</h5>
										                    </div>
										                    <!-- THis is the popup's body 1-->
										                    <div class="modal-body">
										                        <iframe id="followIframe" scrolling="yes" style="width: 600px; height: 350px;" src="follows.php"></iframe>
										                    </div>
										                    <div class="modal-footer">
										                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										                    </div>
										                    <!-- End of pop up message 1-->
										                </div>
										            </div>
										        </div>
						            		</div>
						            		<div class="col-md-6">
						            			<button onclick="refreshIframe('leadsToIframe');" type="button" class="btn btn-primary btn-lg btn-block mt-3" data-toggle="modal" data-target="#leadsToPopUp">Leads To</button>
										        <!-- Modal -->
										        <div class="modal fade" id="leadsToPopUp" aria-hidden="true" style="display: none;">
										            <div class="modal-dialog">
										                <div class="modal-content" style="width: 630px;height: 500px;">
										                    <div class="modal-header">
										                        <h5 class="modal-title">leads To</h5>
										                    </div>
										                    <!-- THis is the popup's body 2-->
										                    <div class="modal-body">
										                    	<iframe id="leadsToIframe" scrolling="yes" style="width: 600px; height: 350px;" src="leadsTo.php"></iframe>
										                    </div>
										                    <div class="modal-footer">
										                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										                    </div>
										                    <!-- End of pop up message 2-->
										                </div>
										            </div>
										        </div>
						            		</div>
						            		
						            	</div>
																            	
						            </div>
						        </div>
						    </div>
						</div>
	                </div>
	                <!-- END OF ACCORDION 2-->


	                
                </div>
                <!-- MAIN ACCORDION END -->
            </div>
		   	<div class="row">
		   		<div class="col-md-3">
		   			<div class="card">
						<div class="card-body">
							<button onclick="refreshIframe('viewIframe');" type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#viewPopUp" id="viewButtonID">View Orchestration</button>
	    					<button type="Submit" class="btn btn-success mb-3">Finish Orchestration</button>						
	    				</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body">
							
							<!-- Modal -->
							<div class="modal fade" id="viewPopUp" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
									<div class="modal-content" style="width: 630px;height: 500px;">
										<div class="modal-header">
											<h5 class="modal-title">View</h5>
										</div>
										<!-- THis is the popup's body 2-->
										<div class="modal-body">
											<iframe id="viewIframe" scrolling="yes" style="width: 600px; height: 350px;" src="view.php"></iframe>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										</div>
										<!-- End of pop up message 2-->
									</div>
								</div>
							</div>
							
						</div>
					</div>
		   		</div>
		   	</div>
        </div>
    </div>
</form>

<script type="text/javascript">
    function refreshIframe(id) {
        document.getElementById(id).src = document.getElementById(id).src;
    }
</script>
<!-- main content area end -->