<?php 

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		$userApprove = $_REQUEST['tf'];
		$jobId = $_REQUEST['jobid'];
		$ruleId = $_REQUEST['rlid'];

		$wsdl = 'http://10.1.90.19:9001/ApproveService?WSDL';
		$trace = true;
		$exceptions = false;

		//Burasý request için gerekli.
		$xml_array['arg0']['userApprove']=$userApprove;
		$xml_array['arg0']['jobId']=$jobId;
		$xml_array['arg0']['relativeId']=$ruleId;
		




		$client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
	

		$response = $client->updateUserApprove($xml_array);
		//var_dump($response->getJob);
		$result = $response->return;
		//echo($response->return) . "<br>";
		//echo($response->getJob->owner) . "<br>";
		//echo($response->getJob->relatives) . "<br>";
		exit($result);

?>