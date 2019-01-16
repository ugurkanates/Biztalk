<?php
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);


		$wsdl = 'http://10.1.90.19:9001/OrchestrationService?WSDL';
		$trace = true;
		$exceptions = false;

		//Burası request için gerekli.
		if ($_SERVER['REQUEST_METHOD'] == 'GET'){
			if (isset($_GET['del_job_id'])) {
				$del_key = $_GET['del_job_id'];
			}
		}
		$xml_array['jobID'] = $del_key;		//----------------------------------------------------->CHANGE HERE $_POST['jobID']
		
		var_dump($xml_array);

		$client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
		var_dump($client);

		$response = $client->removeJob($xml_array);
		var_dump($response);
		//var_dump($response->getJob);
		echo($response->message) . "<br>";
		//echo($response->getJob->owner) . "<br>";
		//echo($response->getJob->relatives) . "<br>";


		/*----------------------------------------------------------------If Response succeeded DELETE from GUI's DB

		DELETE JOB FROM GUI's DB

		-------------------------------------------------------------------*/

// 		if($_SERVER["REQUEST_METHOD"] == "POST") {
// //		print_r($_POST);
		
//         $del_job_key = mysqli_real_escape_string($db,$_POST['del_job_id']);

//         $sql_del_J = "DELETE FROM tbl_jobs WHERE id='".$del_job_key."'";

// 		if ($db->query($sql_del_J) === TRUE){
// 			echo "<div class='alert alert-info' role='alert'>
// 		 	<strong>Notice !</strong>Job has been REMOVED.
// 			</div>";
//		    header( "refresh:1; url=manageJobs.php" );

// 		}

		
//         } else {
//             echo "Error: " . $sql . "<br>" . $db->error;
//         }

?>
	
