<?php
    include ('dashboard_user.php');
?>

<!-- ----------------------FORM ---------------------------------- -->
<form method="GET" action="z2.php">
<div class="main-content-inner">
    <div class="row">
        <!-- Input Sizes Rounded start -->
        
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Add Job Area</h4>
                        <hr>
                        <input class="form-control mb-4 input-rounded" type="text" readonly placeholder="<?php echo $login_session ?>" name="jobOwner" id="jobOwner">
                        <input class="form-control mb-4 input-rounded" type="text" placeholder="Description:" name="jobDescription" id="jobDescription required">
                        <div class="form-group">
                            <label for="example-number-input" class="col-form-label"># of Destinations</label>
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
