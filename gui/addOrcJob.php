<?php 

include("session.php");

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

<!-- FORM  -->
<form method="GET" action="addOrcJob2.php">
<div class="main-content-inner">
    <div class="row">
        <!-- Input Sizes Rounded start -->
        
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Add Job Area</h4>
                        <?php 
                            if (is_null($exStartJobId)){
                                echo"<div class='custom-control custom-checkbox custom-control-inline'>";
                                    echo"<input type='checkbox' class='custom-control-input' id='isStartJob' name='isStartJob' onclick='check(this)' >";
                                    echo"<label class='custom-control-label' for='isStartJob'>is Start Job ?</label>";
                                echo"</div>";
                                echo"<br></br>"; 
                            }                   
                            echo "<input type='hidden' id='startJob' value='no' name='startJob' >";
                            ?>
                        <label for="example-number-input" class="col-form-label">Job Owner</label>
                        <input readonly value="<?php echo $login_session?>" class="form-control mb-4 input-rounded" type="text" name="jobOwner" id="jobOwner"/>             
                        <input class="form-control mb-4 input-rounded" type="text" placeholder="Job Name:" name="jobDescription" id="jobDescription"/>
                        <div class="form-group">
                            <label for="example-number-input" class="col-form-label"># of Destinations</label>
                            <input class="form-control" type="number" value="1" id="numberofip" name="numberofip" max="200" min="1">
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Next</button>
                    </div>
                </div>
            </div>
        <!-- Input Sizes Rounded end -->
         </div>
    </div>
</form>

<script type="text/javascript">

    function check(fth){
        var res = fth.checked;
        var startSelect = document.getElementById("startJob");

        if(res){
            startSelect.value = "yes";
        }else{
            startSelect.value = "no";
        }
        console.log(startSelect.value);
    }


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