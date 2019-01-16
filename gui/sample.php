<?php
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);


		$wsdl = 'http://gtubiztalk.tk:9001/OrchestrationService?WSDL';
		$trace = true;
		$exceptions = false;

		//Burası request için gerekli.
		$xml_array['orchestration']['id']="1";
		$xml_array['orchestration']['ownerID']="123";
		$xml_array['orchestration']['startJobID']="1";
		
		$xml_array['jobList'][0]['id'] 	= "1";
		$xml_array['jobList'][0]['owner']	= "9988";
		$xml_array['jobList'][0]['description'] 	= "Proje Lab";
		$xml_array['jobList'][0]['destination'] 	= "10.1.1.1";
		$xml_array['jobList'][0]['fileUrl'] 	= "http://www.google.com";
		$xml_array['jobList'][0]['relatives'] 	= "99,23,67";
		$xml_array['jobList'][0]['ruleId'] 	= 1;

		$xml_array['jobList'][1]['id'] 	= "2";
		$xml_array['jobList'][1]['owner']	= "9988";
		$xml_array['jobList'][1]['description'] 	= "Proje Lab 2";
		$xml_array['jobList'][1]['destination'] 	= "10.1.1.2";
		$xml_array['jobList'][1]['fileUrl'] 	= "http://www.google.com";
		$xml_array['jobList'][1]['relatives'] 	= "99,21,67";
		$xml_array['jobList'][1]['ruleId'] 	= 1;


		$xml_array['ruleList'][0]['id'] 	= "1";
		$xml_array['ruleList'][0]['ownerID'] 	= "9988";
		$xml_array['ruleList'][0]['query'] 	= "99.78.67";
		$xml_array['ruleList'][0]['yesEdge'] 	= "2";
		$xml_array['ruleList'][0]['noEdge'] 	= "0";

		$xml_array['ruleList'][1]['id'] 	= "2";
		$xml_array['ruleList'][1]['ownerID'] 	= "9988";
		$xml_array['ruleList'][1]['query'] 	= "99.78.67";
		$xml_array['ruleList'][1]['yesEdge'] 	= "0";
		$xml_array['ruleList'][1]['noEdge'] 	= "0";

		var_dump($xml_array);
		
		
	


		$client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
		var_dump($client);

		$response = $client->addOrchestration($xml_array);
		var_dump($response);
		//var_dump($response->getJob);
		echo($response->message) . "<br>";
		//echo($response->getJob->owner) . "<br>";
		//echo($response->getJob->relatives) . "<br>";
?>
	
