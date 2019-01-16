<?php

    include('dashboard_user.php');
    // echo '<pre>'; print_r($_POST); echo '</pre>';
    error_reporting(E_ALL); ini_set('display_errors', 1);

    $wsdl = "http://".$wdslIP.":9001/OrchestrationService?WSDL";
    $trace = true;
    $exceptions = true;

     try {
        $client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
    }

    //catch exception
    catch(Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>
                <strong>Opps!</strong>&nbsp;Server is offline.
            </div>";  
        exit;       
    }

     if(isset($_FILES['fileUrl'])){
        
         $errors= array();
        // $target = $_POST['fileUrl'];
         $file_name = $_FILES['fileUrl']['name'];
         $file_size = $_FILES['fileUrl']['size'];
         $file_tmp = $_FILES['fileUrl']['tmp_name'];
         $file_type = $_FILES['fileUrl']['type'];
	
         //$file_ext=strtolower(end(explode('.',$file_name)));

         /*$expensions= array("jpeg","jpg","png","pdf");

         if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
         }
         */
         if($file_size > 2097152) {
             $errors[]='File size must be excately 2 MB';
         }

         if(empty($errors)==true) {
             move_uploaded_file($file_tmp,"IncomingFiles/".$file_name);
             /* echo "Success";
             echo "Stored in: " . $_SERVER['SERVER_NAME'] ."/incomingFile/" . $_FILES["file"]["name"];*/
             $fileURL = "http://" .$_SERVER['SERVER_NAME'] ."/BiztalkGUI/IncomingFiles/" . $_FILES["fileUrl"]["name"];
            // echo "debug1";
             //echo '<a href='.$fileURL.'>'.$fileURL.'</a>';
            
         }else{
             print_r($errors);
         }
     }

	
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $ipNum = mysqli_real_escape_string($db,$_POST['ipNum']);
        $jobDescription = mysqli_real_escape_string($db,$_POST['jobDescription']); 
        $relatives = mysqli_real_escape_string($db,$_POST['relatives']); 
        $fileUrl = mysqli_real_escape_string($db,$fileURL); 
        $checkBox = mysqli_real_escape_string($db,$_POST['checkBox']); 
        echo $checkBox;
        
      //  echo "file URL : ".$fileUrl."<br>";
       
        $ips = $_POST['ip'];
        $messages = $_POST['message'];

        $jobOwner = $login_id;

        $ipString = "";
        foreach( $ips as $key => $n ) {
            $ipString = $ipString.$n.",";
        } 
        $ipString = rtrim($ipString, ',');
        
        $messageString = "";
        foreach( $messages as $key => $n ) {
            $messageString = $messageString.$n."~";
        } 
        $messageString = rtrim($messageString, '~');

        $ruleID = 0;
        $query = "";

        if($checkBox == "yes"){
        	$ruleID = 1;
	        if($_POST['EntryText'] != "")
	            $query = mysqli_real_escape_string($db,$_POST['EntryText']);

	        else{
	            $fileName = realpath($_FILES['inputGroupFile02']['tmp_name']);
	            $queryFile = fopen($fileName, "r") or die("Unable to open file!");
	            $query = fread($queryFile,filesize($fileName));
	            fclose($queryFile);
	        }
        }

        $sql = "INSERT INTO tbl_jobs (owner, description, destination, fileUrl, ruleID , query ,relatives, messages)
        VALUES ('$jobOwner', '$jobDescription', '$ipString', '$fileUrl','$ruleID','$query' ,'$relatives','$messageString')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully added a Job.
            </div>"; 
            echo "<a href='addUsrJob.php'><button class='btn btn-primary mb-3'>Add New Job</button></a>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

    //echo phpinfo();
       

        //Burası request için gerekli.
        
        $job_sql = "SELECT * FROM tbl_jobs";
                            
        $resultJobs = $db->query($job_sql); 

        if ($resultJobs->num_rows > 0) {
            while($rowJobs = $resultJobs->fetch_assoc()) {

                $xml_array['job']['id']             = $rowJobs['id'];
                $xml_array['job']['owner']          = $rowJobs['owner'];
                $xml_array['job']['description']    = $rowJobs['messages'];
                $xml_array['job']['destination']    = $rowJobs['destination'];
                $xml_array['job']['fileUrl']        = $rowJobs['fileUrl'];
                $xml_array['job']['relatives']      = $rowJobs['relatives'];
                $xml_array['job']['ruleId']         = $rowJobs['ruleID'];
                $xml_array['job']['orchFlag']         = 0;


                $xml_array['rule']['id']            = $rowJobs['ruleID'];
                $xml_array['rule']['ownerID']       = $rowJobs['owner'];
                $xml_array['rule']['query']         = $rowJobs['query'];
                $xml_array['rule']['yesEdge']       = 0;
                $xml_array['rule']['noEdge']        = 0;

               
            }

        }else{
            echo "0 results";
        }
          

        $response = $client->addJobRule($xml_array);
        // var_dump($response);
        // var_dump($response->getJob);
        // echo($response->message) . "<br>";
        // echo($response->getJob->owner) . "<br>";
        // echo($response->getJob->relatives) . "<br>";

?>