<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>BizTalk - Admin Log Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="terminalCSS.css">
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

    <style>
    <?php 
         include 'assets/css/terminalCSS.css'; 
    ?>
	</style>

    <body>
 
        <meta charset="utf-8">
        <title>Admin Terminal</title>

        <div id="container">
    	  <p>GTU Biztalk Log Terminal</p>
          <output id="outp"></output>
          <div id="input-line" class="input-line">
            <div class="prompt">[Admin] > </div><div><input class="cmdline" id="input" onKeyDown="newCommand()"></div>
          </div>
        </div>

        <script type="text/javascript">
			function newCommand() {
			    if (event.keyCode == 13) {
			        document.getElementById("outp").innerHTML = document.getElementById("input").value
			    }
			}

		</script>

    </body>

</html>
