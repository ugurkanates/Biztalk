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
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>

<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <form action="addOrcRule.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Rule Name</label>
                    <input class="form-control" type="text" id="RuleName" name="RuleName" required>
                </div>
                
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">OwnerID</label>
                    <input class="form-control" type="text" readonly placeholder="<?php echo $login_session ?>" name="jobOwner" id="jobOwner">

                </div>  
                
                 <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Rule</h4>
                                    <input type="radio" name='field' id='field' value="asText" onclick="ShowHideDivText()" required /> Type CNF Rule as Text
                                    <br></br>
                                    <div class="card-body" id="asTextField" style="display: none;">
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="EntryText" placeholder="Type Cnf.." name="EntryText" required>
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
                <input class="btn btn-primary mb-3" type="submit" name="submit_button" id="submit_button">
            </form>                                             
        <!-- Radios end -->
            
<!-- Textual inputs end -->
        </div>
    </div>
</div>

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