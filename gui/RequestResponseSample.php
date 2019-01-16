<?php
		//echo phpinfo();
		$wsdl = 'http://46.101.176.37:9001/OrchestrationService?WSDL';
		$trace = true;
		$exceptions = false;

		//Burası request için gerekli.
		
		
		$xml_array['job']['id'] 	= 10;
		$xml_array['job']['owner']	= 9988;
		$xml_array['job']['description'] 	= "Proje Lab";
		$xml_array['job']['destination'] 	= "10.1.1.1";
		$xml_array['job']['fileUrl'] 	= "http://www.google.com";
		$xml_array['job']['relatives'] 	= "99,78,67";
		$xml_array['job']['ruleId'] 	= 1;
		
		$xml_array['rule']['id'] 	= 1;
		$xml_array['rule']['ownerID'] 	= 9988;
		$xml_array['rule']['query'] 	= "99.78.67";
		$xml_array['rule']['yesEdge'] 	= 0;
		$xml_array['rule']['noEdge'] 	= 0;
		
		//var_dump($xml_array);
		
		
	
		$client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
		

		$response = $client->addJobRule($xml_array);
		var_dump($response);
		//var_dump($response->getJob);
		echo($response->message) . "<br>";
		//echo($response->getJob->owner) . "<br>";
		//echo($response->getJob->relatives) . "<br>";
?>
	
