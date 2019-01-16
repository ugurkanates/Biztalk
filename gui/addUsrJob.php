<?php
    include ('dashboard_user.php');
?>

<!-- FORM  -->
<form method="GET" action="addUsrJob2.php">
<div class="main-content-inner">
    <div class="row">
        <!-- Input Sizes Rounded start -->
        
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Add Job Area</h4>
                        <input class="form-control mb-4" type="text" readonly placeholder="<?php echo $login_session ?>" name="showOwner" id="showOwner">

                        <input class="form-control mb-4" type="text" placeholder="Description:" name="jobDescription" id="jobDescription" required>
                        <div class="form-group">
                            <label for="example-number-input" class="col-form-label">Number of Destinations</label>
                            <input class="form-control" type="number" value="1" id="numberofip" name="numberofip" max="200" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Next</button>
                    </div>
                </div>
            </div>
        <!-- Input Sizes Rounded end -->
         </div>
    </div>
</form>
