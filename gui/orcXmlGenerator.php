<?php
	include('session.php');
	include ('config.php');
	if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 

	$sqlJob = "SELECT * FROM tbl_job_orc";
	$sqlRule = "SELECT * FROM tbl_rule_orc";
	
	$resultJob = $db->query($sqlJob);
	$resultRule = $db->query($sqlRule);

	/*$soapXML = ''; //<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:orc='http://orchestration.server.com'>
	$headerTag = '<soapenv:Header/>';
	$bodyOpenTag = '<soapenv:Body>';
	$bodyCloseTag = '</soapenv:Body>';

	$orcMainTagOpen = '<orc:addOrchestration>';
	$orcMainTagClose = '</orc:addOrchestration>';

	
	//Creation start here
	$soapXML .= $headerTag; 		// <soapenv:Header/>
	$soapXML .= $bodyOpenTag; 		// <soapenv:Body>
	$soapXML .= $orcMainTagOpen; 	// <orc:addOrchestration>

	//----Orchestration info
	$soapXML .= '<orchestration>';

	$soapXML .= '</orchestration>';
	//-----
	*/

	/*Format*/

	/*$xml = new SimpleXMLElement('<xml/>');

	    $addOrchestration = $xml->addChild('orc:addOrchestration');
	    	$orchestration = $addOrchestration->addChild('orchestration');
			    $orchestration->addChild('id', "1");
			    $orchestration->addChild('ownerID', "Onur");
			    $orchestration->addChild('startJobID', "1");

			/* IN FOR LOOP */
			/*$jobList = $addOrchestration->addChild('jobList');
			    $jobList->addChild('id', "1");
			    $jobList->addChild('owner', "Onur");
			    $jobList->addChild('description', "Deneme");
			    $jobList->addChild('destination', "10.0.0.1,10.0.0.2");
			    $jobList->addChild('fileUrl', "http://blabla.com/o.img");
			    $jobList->addChild('relatives', "15,16,17");
			    $jobList->addChild('ruleId', "1");
			/********/

			/* IN FOR LOOP */
			/*$ruleList = $addOrchestration->addChild('ruleList');
			    $ruleList->addChild('id', "1");
			    $ruleList->addChild('ownerID', "Owner");
			    $ruleList->addChild('query', "20,21,23,24");
			    $ruleList->addChild('yesEdge', "0");
			    $ruleList->addChild('noEdge', "0");
			    $ruleList->addChild('relativeResults', "?");
			/********/

		$xml = new SimpleXMLElement('<xml/>');

	    $addOrchestration = $xml->addChild('orc:addOrchestration');
    	$orchestration = $addOrchestration->addChild('orchestration');
	    $orchestration->addChild('id', "1");
	    $orchestration->addChild('ownerID', "Onur");
	    $orchestration->addChild('startJobID', "1");

			/* IN FOR LOOP */
			if ($resultJob->num_rows > 0) {
				while($rowJob = $resultJob->fetch_assoc()) {
					$jobList = $addOrchestration->addChild('jobList');
				    $jobList->addChild('id', $rowJob['id']);
				    $jobList->addChild('owner', $rowJob['owner']);
				    $jobList->addChild('description', $rowJob['description']);
				    $jobList->addChild('destination', $rowJob['destination']);
				    $jobList->addChild('fileUrl', $rowJob['fileurl']);
				    $jobList->addChild('relatives', "15,16,17");
				    $jobList->addChild('ruleId', "1");
				}
			}
			/********/

			/* IN FOR LOOP */
			if ($resultRule->num_rows > 0) {
				while($rowRule = $resultRule->fetch_assoc()) {
					$ruleList = $addOrchestration->addChild('ruleList');
				    $ruleList->addChild('id', $rowRule['id']);
				    $ruleList->addChild('ownerID', $rowRule['ownerID']);
				    $ruleList->addChild('query', $rowRule['query']);
				    $ruleList->addChild('yesEdge', "0");
				    $ruleList->addChild('noEdge', "0");
				    $ruleList->addChild('relativeResults', "?");
				}
			}
			/********/

	Header('Content-type: text/xml');
	print($xml->asXML());
	
	
	

	
?>