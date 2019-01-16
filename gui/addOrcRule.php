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

<?php
   include('session.php');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 

    error_reporting(E_ALL); ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $ruleName = mysqli_real_escape_string($db,$_POST['RuleName']);
        $ownerID = $login_id;
        $orcID = $maxOrcID;
        if($_POST['EntryText'] != "")
            $query = mysqli_real_escape_string($db,$_POST['EntryText']);
        else{
            $fileName = realpath($_FILES['inputGroupFile02']['tmp_name']);
            $queryFile = fopen($fileName, "r") or die("Unable to open file!");
            $query = fread($queryFile,filesize($fileName));
            fclose($queryFile);
        }

        //For current rule id of current orchestration

        $sqlRuleId = "SELECT * FROM orcRules WHERE orchestrations_id = $maxOrcID";
        $resSqlRuleId = mysqli_query($db, $sqlRuleId);
        $resSqlRuleIdArr = mysqli_fetch_all($resSqlRuleId, MYSQLI_ASSOC);
        $ruleId = 0;
        if($resSqlRuleId->num_rows == 0){
            $ruleId = 1;
        }
        else{
            $ruleId = $resSqlRuleIdArr[(sizeof($resSqlRuleIdArr))-1]['ruleId'] +1;
        }

        $sql = "INSERT INTO orcRules (ruleId, orchestrations_id, owner, ruleName, query)
        VALUES ('$ruleId', '$orcID', '$ownerID', '$ruleName', '$query')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully added a rule to orchestration.
            </div>";
            header( "refresh:1; url=orcRule.php" );
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

    $db->close();
?>