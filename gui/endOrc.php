<?php
   include('session.php');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $orcId = $maxOrcID;

        $sql = "INSERT INTO orcEndNode (orchestrations_id,endNode)
        VALUES ('$orcId','0')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully added an END Node </div>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

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

<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <form action="endOrc.php" method="POST">
                <input class="btn btn-primary mb-3" type="submit" name="submit_button" id="submit_button" value="Add END node">
            </form>                                             
        <!-- Radios end -->
            
<!-- Textual inputs end -->
        </div>
    </div>
</div>

 

</body>
</html>