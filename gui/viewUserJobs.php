<?php    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include ('dashboard_user.php');

    $wsdl = "http://".$wdslIP.":9001/InfoService?WSDL";

    $trace = true;
    $exceptions = true;


	$xml_array['ownerID']=$login_id;
	

	//var_dump($xml_array);
    
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

	//var_dump($client);
	$response = $client->getJobsFromOwner($xml_array);


	//var_dump($response);
	//var_dump($response->getJob);
    //echo '<pre>'; print_r($response); echo '</pre>';
    //exit();
               
?>


<div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Show Jobs Table</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-hover progress-table text-center">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">Owner</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">status</th>
                                </tr>
                            </thead>
                            
                           <?php

                                $description_sql = "SELECT `description` FROM `tbl_jobs` WHERE owner=$login_id";
                                $result = $db->query($description_sql); 
                                $row = $result->fetch_assoc();

                                if (isset($response->getJobFromOwner)) {
                                    $responseData = array($response->getJobFromOwner);
                                    if (is_array($response->getJobFromOwner)) {
                                        $count = count($responseData[0]);
                                        for ($j = 0; $j < $count; $j++) {   
                                            echo "<tr>";
                                            echo "<td>".$login_session."</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<td>".$responseData[0][$j]->insertDateTime."</td>";
                                            echo "<td>".$responseData[0][$j]->destination."</td>";
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


                                            echo "</tr>"; 
                                        }     
                                    } else {
                                        echo "<tr>";
                                        echo "<td>".$login_session."</td>";
                                        echo "<td>".$row['description']."</td>";
                                        echo "<td>".$responseData[0]->insertDateTime."</td>";
                                        echo "<td>".$responseData[0]->destination."</td>";
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
                                        
                                       

                                        echo "</tr>";    
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>