<?php
   include ('dashboard_admin.php');
    $state;
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $wsdl = "http://".$wdslIP.":9001/AdminService?WSDL";
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

    if(isset($_GET['start'])){

        $state = "on";
        //Burası request için gerekli.
        $xml_array['startServer']="";
        $response = $client->startServer($xml_array);
        //var_dump($response);
        //var_dump($response->getJob);
        echo($response->return) . "<br>";

    }else if(isset($_GET['stop'])){

        $state = "off";

        //Burası request için gerekli.
        $xml_array['stopServer']="";
        $response = $client->stopServer($xml_array);
        //var_dump($response);
        //var_dump($response->getJob);
        echo($response->return) . "<br>";

        echo "<div class='col-12 mt-5'>
        <div class='card'>
            <div class='card-body'>
                <h5>Start/Stop Server</h3>
                <br>
                <div class='alert alert-warning' role='alert'>
                    Server is <strong>Offline!</strong> 
                </div>";
    }

   

    //$response = $client->getOrchestration($xml_array);
?>


<!-- PAGE BODY -->
<?php
if ($state == "on"){
        echo "<div class='col-12 mt-5'>
        <div class='card'>
            <div class='card-body'>
                <h5>Start/Stop Server</h3>
                <br>
                <div class='alert alert-success' role='alert'>
                    Server is <strong>running!</strong> 
                </div>";
}else if ($state == "off"){
        echo "<div class='col-12 mt-5'>
        <div class='card'>
            <div class='card-body'>
                <h5>Start/Stop Server</h3>
                <br>
                <div class='alert alert-warning' role='alert'>
                    Server is <strong>Offline!</strong> 
                </div>";   
}
?>
                <br>
                <a href="system.php?start=1"><button type="button" class="btn btn-flat btn-success mb-3">Start</button></a>
                <button type="button" class="btn btn-flat btn-danger mb-3" data-toggle="modal" data-target="#exampleModalLong">Stop</button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalLong">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Attention!</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Server and all jobs will be suspended. If there is a job in process will be cancelled. 
                                </p>
                            </div>
                            <div class="modal-footer">
                                <a href="system.php?stop=1"> <button type="button" class="btn btn-flat btn-success mb-3">Accept</button></a>
                                <button type="button" class="btn btn-flat btn-danger mb-3">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- main content area end -->