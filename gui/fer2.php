<html>
<head>
    <title>SOAP JavaScript Client Test</title>
	
	
	
</head>
<body>	
  <?php    
    	
		include ('session.php');
    //include ('session.php');

    $wsdl = 'http://gtubiztalk.tk:9001/InfoService?WSDL';
    $trace = true;
    $exceptions = false;

    $xml_array['relativeID']=1;
		$my_id = $login_id;

		//var_dump($xml_array);

        $client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
		//var_dump($client);

		$response = $client->getJobsFromRelative($xml_array);
		//var_dump($response);
		//var_dump($response->getJob);
		$functions = $client->__getFunctions ();
		var_dump ($functions);
       //echo $client->getJobsFromRelative($xml_array);



        for ($i = 0; $i < count($response->getJobFromRelative); $i++) {
            echo("------------------------------------------------") . "<br>";
            echo($response->getJobFromRelative[$i]->owner) . "<br>";
            echo($response->getJobFromRelative[$i]->description) . "<br>";
            echo($response->getJobFromRelative[$i]->insertDateTime) . "<br>";
            echo($response->getJobFromRelative[$i]->destination) . "<br>";
            echo($response->getJobFromRelative[$i]->status) . "<br>";
            echo("------------------------------------------------") . "<br>";

           
            
        }

		
		
        
$counter=count($response);
   echo $counter;
   
echo "<script type='text/javascript'>alert('$counter');</script>";
   
   ?>
   
   
   
</body>
</html> <!-- typo -->