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

    $xml_array['ownerID']=$login_id;
		$my_id = $login_id;

		//var_dump($xml_array);

        $client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
		//var_dump($client);

		$response = $client->getJobsFromOwner($xml_array);
		//var_dump($response);
		//var_dump($response->getJob);
       



        for ($i = 0; $i < count($response->getJobFromOwner); $i++) {
            echo("------------------------------------------------") . "<br>";
            echo($response->getJobFromOwner[$i]->owner) . "<br>";
            echo($response->getJobFromOwner[$i]->description) . "<br>";
            echo($response->getJobFromOwner[$i]->insertDateTime) . "<br>";
            echo($response->getJobFromOwner[$i]->destination) . "<br>";
            echo($response->getJobFromOwner[$i]->status) . "<br>";
            echo("------------------------------------------------") . "<br>";

           
            
        }

		
		
        
$counter=count($response->getJobFromOwner);
   echo $counter;
   
echo "<script type='text/javascript'>alert('$counter');</script>";
   
   ?>
   
   
   
</body>
</html> <!-- typo -->