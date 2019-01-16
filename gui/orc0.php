<?php
   include ('dashboard_manager.php');
?>

<!-- PAGE BODY -->
<form method="POST" action="orc2.php">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
            	<h4 class="header-title">Orchestration</h4>
                <label for="orcOwner" class="col-form-label">Orchestration Owner</label>
                <?php
                    echo "<input readonly placeholder='$login_session' class='form-control mb-4 input-rounded' type='text' name='showOwner' id='showOwner'/>";
                    echo "<input value='$login_id' type='hidden' name='orcOwner' id='orcOwner'/>";
                ?>
            </div>
		   	<div class="row">
		   		<div class="col-md-12">
		   			<div class="card">
						<div class="card-body">
	    					<button type="Submit" class="btn btn-primary mb-3">Create Orchestration</button>
	    				</div>
	    			</div>
		   		</div>
		   	</div>
        </div>
    </div>
</form>
<!-- main content area end -->