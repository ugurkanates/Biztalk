<?php    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include ('dashboard_manager.php');

    $wsdl = 'http://10.1.90.19:9001/InfoService?WSDL';
    $trace = true;
    $exceptions = false;
	
	//$login_id = 25;
    $xml_array['ownerID']=$login_id;
    
	
    //var_dump($xml_array);

    $client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
   // var_dump($client);

    $response = $client->getOrchestration($xml_array);

    //echo '<pre>'; print_r($response); echo '</pre>';

    // var_dump($response);

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
                                    <th scope="col">Owner</th>
                                    <th scope="col">Start Job</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">status</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Test Data</td>
                                <td>Test Data</td>
                                <td>Test Data</td>
                                <td>Test Data</td>
                                <td><button class="btn btn-danger" onclick="">Delete</button></td>
                            </tr>
                           <?php
                                /*
                                if (isset($response->getOrchestration)) {
                                    $responseData = array($response->getOrchestration);
                                    if (is_array($response->getOrchestration)) {
                                       $responseData = array($response->getOrchestration);
                                        $count = count($responseData[0]);
                                        for ($j = 0; $j < $count; $j++) {   
                                            echo "<tr>";
                                            echo "<td>".$login_session."</td>";
                                            echo "<td>".$responseData[0][$j]->startJobID."</td>";
                                            echo "<td>".$responseData[0][$j]->InsertDateTime."</td>";
                                            if ($responseData[0][$j]->status == 404)
                                            echo "<td class='btn-danger' >Error</td>";
                                            else if ($responseData[0][$j]->status == 100)
                                                echo "<td class='btn-success' >Success</td>";
                                            else if ($responseData[0][$j]->status == 50)
                                                echo "<td class='btn-primary' >Working</td>";
                                            else if ($responseData[0][$j]->status == 0)
                                                echo "<td class='btn-warning' >Pending</td>";
                                            else if ($responseData[0][$j]->status == -1)
                                                echo "<td class='btn-warning' >Pending</td>";
                                            echo "<tr>";
                                        }     
                                    } else {
                                        echo "<tr>";
                                        echo "<td>".$login_session."</td>";
                                        echo "<td>".$responseData[0]->startJobID."</td>";
                                        echo "<td>".$responseData[0]->InsertDateTime."</td>";
                                        if ($responseData[0]->status == 404)
                                            echo "<td class='btn-danger' >Error</td>";
                                        else if ($responseData[0]->status == 100)
                                            echo "<td class='btn-success' >Success</td>";
                                        else if ($responseData[0]->status == 50)
                                            echo "<td class='btn-primary' >Working</td>";
                                        else if ($responseData[0]->status == 0)
                                            echo "<td class='btn-warning' >Pending</td>";
                                        else if ($responseData[0]->status == -1)
                                            echo "<td class='btn-warning' >Pending</td>";

                                        echo "<tr>";     
                                    }
                                } */
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
