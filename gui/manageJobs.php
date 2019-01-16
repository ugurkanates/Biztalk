<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include ('dashboard_admin.php');

    $wsdl = "http://".$wdslIP.":9001/InfoService?WSDL";
    $trace = true;
    $exceptions = true;

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
    $response = $client->getAllJobs();



    //var_dump($response);
    //echo '<pre>'; print_r($response); echo '</pre>';
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                           <?php


                                //GET jobID FROM SERVER DB AND POST IT TO deleteJobRequest.php -------------------->CHANGE HERE
                                //GET id FROM GUI's DB AND POST IT TO deleteJobRequest.php ------------------------>CHANGE HERE
                                //$del_job_id = $row[id];
                                //echo "<input type='hidden' value='$del_job_id'/>";
                                //---------------------------------------------------------------------------------------------


                                if (isset($response->getAllJobs)) {
                                    $responseData = array($response->getAllJobs);

                                    if (is_array($response->getAllJobs)) {
                                        $count = count($responseData[0]);
                                        for ($j = 0; $j < $count; $j++) { 
                                        	$serverJobId = $responseData[0][$j]->id;  

                                            echo "<tr>";
	                                            echo "<td>".$login_session."</td>";
	                                            echo "<td>".$responseData[0][$j]->description."</td>";
	                                            //echo "<td>Description".$j."</td>";
	                                            echo "<td>".$responseData[0][$j]->insertDateTime."</td>";
	                                            echo "<td>".$responseData[0][$j]->destination."</td>";
	                                            if ($responseData[0][$j]->status == 404)
	                                            echo "<td class='btn-danger' >Error</td>";
	                                            else if ($responseData[0][$j]->status == 100){
	                                                echo "<td class='btn-success' >Success</td>";
	                                                echo "<td><button type='submit' disabled class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                            }
	                                            else if ($responseData[0][$j]->status == 50){
	                                                echo "<td class='btn-primary' >Working</td>";
	                                                echo "<form method='GET' action='deleteJobRequest.php'>";	
	                                                	echo "<td><button type='submit' class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                                	echo "<input type='hidden' name='del_job_id' value='$serverJobId'/>";
	                                                echo "</form>";	
	                                            }
	                                            else if ($responseData[0][$j]->status == 0){
	                                                echo "<td class='btn-warning' >Pending</td>";
	                                                echo "<form method='GET' action='deleteJobRequest.php'>";	
	                                                	echo "<td><button type='submit' class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                                	echo "<input type='hidden' name='del_job_id' value='$serverJobId'/>";
	                                                echo "</form>";	

	                                            }
	                                            else if ($responseData[0][$j]->status == -1)
	                                                echo "<td class='btn-warning' >Pending</td>";
	                                            else if ($responseData[0][$j]->status == -31){
	                                                echo "<td class='btn-danger' >Deleted</td>";
	                                                echo "<td><button type='submit' disabled class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                            }

                                            echo "</tr>"; 
                                        }    

                                    } else {
                                    	

                                    		$serverJobId = $responseData[0]->id;  

                                        	echo "<tr>";
	                                        echo "<td>".$login_session."</td>";
	                                        echo "<td>".$responseData[0]->description."</td>";
	                                        echo "<td>".$responseData[0]->insertDateTime."</td>";
	                                        echo "<td>".$responseData[0]->destination."</td>";
	                                        if ($responseData[0]->status == 404)
	                                            echo "<td class='btn-danger' >Error</td>";
	                                        else if ($responseData[0]->status == 100){
	                                            echo "<td class='btn-success' >Success</td>";
                                                echo "<td><button type='submit' disabled class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                        }
	                                        else if ($responseData[0]->status == 50){
	                                            echo "<td class='btn-primary' >Working</td>";
	                                            echo "<form method='GET' action='addOrcJob2.php'>";	
                                                	echo "<td><button type='submit' class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
                                                echo "</form>";	
	                                        }
	                                        else if ($responseData[0]->status == 0){
	                                            echo "<td class='btn-warning' >Pending</td>";
	                                            echo "<td><button type='submit' class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                          
	                                        }
	                                        else if ($responseData[0]->status == -1)
	                                            echo "<td class='btn-warning' >Pending</td>";
	                                        else if ($responseData[0]->status == -31){
	                                                echo "<td class='btn-danger' >Deleted</td>";
	                                                echo "<td><button type='submit' disabled class='btn btn-danger '><i class='fa fa-trash'></i></button></td>";
	                                            }

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