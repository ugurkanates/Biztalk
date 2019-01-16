<?php    
    
    include ('dashboard_manager.php');

    $xmlstring = '
      <ns2:getJobsFromOwnerResponse xmlns:ns2="http://InfoService.Services/" xmlns:ns3="Rule" xmlns:ns4="Orchestration" xmlns:ns5="Server">
         <getJobFromOwner>
            <id>2</id>
            <owner>0</owner>
            <description>Blabla</description>
            <destination>10.0.0.3,10.0.0.5</destination>
            <fileUrl>http://onur.com/a.jpg</fileUrl>
            <relatives>20,21,23,24</relatives>
            <status>0</status>
            <ruleId>1</ruleId>
            <insertDateTime>2018-12-26T18:04:25+03:00</insertDateTime>
            <updateDateTime>1.updateTime</updateDateTime>
         </getJobFromOwner>
         <getJobFromOwner>
            <id>1</id>
            <owner>0</owner>
            <description>Deneme</description>
            <destination>10.0.0.1,10.0.0.2</destination>
            <fileUrl>http://blabla.com/o.img</fileUrl>
            <relatives>15,16,17</relatives>
            <status>0</status>
            <ruleId>0</ruleId>
            <insertDateTime>2.insertTime</insertDateTime>
            <updateDateTime>2.updateTime</updateDateTime>
         </getJobFromOwner>
      </ns2:getJobsFromOwnerResponse>';

	parser($xmlstring);

    
    echo "user: " . $login_session . "\n\r\n\r\n";

?>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Show Orchestrations Table</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col">Job Descriptions</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Owner</td>
                                    <td>Job Message</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3"><a href="#" class="text-secondary"><i class="fa fa-play"></i></a></li>
                                            <li><a href="#" class="mr-3"><i class="fa fa-pause"></i></a></li>
                                            <li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Owner</td>
                                    <td>Job Message</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3"><a href="#" class="text-secondary"><i class="fa fa-play"></i></a></li>
                                            <li><a href="#" class="mr-3"><i class="fa fa-pause"></i></a></li>
                                            <li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Owner</td>
                                    <td>Job Message</td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <li class="mr-3"><a href="#" class="text-secondary"><i class="fa fa-play"></i></a></li>
                                            <li><a href="#" class="mr-3"><i class="fa fa-pause"></i></a></li>
                                            <li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php

function request() {
    $url = 'https://android.googleapis.com/gcm/send';
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "<xml>here</xml>" );
    $result = curl_exec($ch);
    curl_close($ch);

    parser($result);
}


function parser($inputxml) {

	$xml = simplexml_load_string($inputxml);

	//echo "insertDateTime: " . $xml->insertDateTime . "\n";

	echo "[[[ insertDateTime -> " . $xml->getJobFromOwner[0]->insertDateTime . "]]]\n";
	echo "[[[ insertDateTime2 -> " . $xml->getJobFromOwner[1]->insertDateTime . "]]]\n";
	echo "[[[ updateDateTime -> " . $xml->getJobFromOwner[0]->updateDateTime . "]]]";
	echo "[[[ updateDateTime -> " . $xml->getJobFromOwner[0]->updateDateTime . "]]]";
    //var_dump($xml);
}


?>