<?php
   include('session.php');
   include ('config.php');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 

    $sql = "SELECT id FROM tbl_usr";
    $result = $db->query($sql);

    $db->close();
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

<!-- basic form start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Add Job</h4>
            <form>
                <div class="form-row align-items-center">
                    <div class="col-sm-3 my-1">
                        <input type="text" class="form-control" id="ip" name="ip" placeholder="Enter ip.">
                    </div>
                    
                    <div class="col-auto my-1">
                        <input type="text" class="form-control" id="message" name="message" placeholder="Enter ip.">    
                    </div>
                    
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary" onclick="addDestination()">Add Ip</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- basic form end -->

</body>
</html>