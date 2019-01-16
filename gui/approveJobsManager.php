<?php 
include ('dashboard_manager.php');
?>

<?php  
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $wsdl = "http://".$wdslIP.":9001/InfoService?WSDL";
    $trace = true;
    $exceptions = true;

        $xml_array['relativeID']=$login_id;
        //echo "LoginId: " . $login_id;
		$my_id = $login_id;

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

		$response = $client->getJobsFromRelative($xml_array);
		//print_r($response->getJobFromRelative);
		//var_dump($response->getJob);
		
		//var_dump($response);
		
		if (!property_exists($response, 'getJobFromRelative')){
			
			$counter=0;
		}
		else {
	
			$result = $response->getJobFromRelative;
			if(is_array($result)){
				   $counter=count($result);
			}else {
				$counter = 1;
			}
			
		}
     
   
  //echo "Count: " . $counter;
   
   
  //echo "<script type='text/javascript'>alert('$counter');</script>";
 
   
   ?>

    <body onload = main_function()>
            <div class="main-content-inner">
                <!-- MAIN CONTENT GOES HERE -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">APPROVAL TASKS TABLE</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover progress-table text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">JOB ID</th>
                                                    <th scope="col">JOB OWNER</th>
                                                    <th scope="col">JOB DESCRIPTION</th>
                                                    <th scope="col">ACCEPTANCE</th>
                                                </tr>
                                            </thead>
                                            <tbody id="single-table">
                                            	
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
        <!-- main content area end -->
	


    <script type="text/javascript">
    	function deleteRow(_delete) {
  		var row = _delete.parentNode.parentNode;
  		row.parentNode.removeChild(row);
	}
    </script>

<script>

function main_function(){

    var counter = <?php echo $counter;  ?>;
    var obj = <?php echo json_encode($response->getJobFromRelative); ?>;
    if (counter == 1 ) obj[0] = obj; 
    var i;
    for (i = 0; i < counter; i++) { 
        if(obj[i].status == 0 || obj[i].status == -1 || obj[i].status == 50){
            myFunction(obj[i].id, obj[i].owner, obj[i].description);}
    }
}


function soap(tf,jobid,rlid) {
	
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				alert(this.responseText);
			}
		};
		xmlhttp.open("GET", "approve.php?tf=" + tf +"&jobid="+jobid+"&rlid="+rlid, true);
		xmlhttp.send();
	
}


function myFunction(jobid,ownerid,jobdescription) {
	
  var relative_id = <?php echo $login_id;  ?>;
  var table = document.getElementById("single-table");
  var btn=document.createElement('input');
  btn.type="button";
  btn.className="btn btn-xs btn-success";
  btn.value="Accept";
  btn.onclick = function(){soap("t",row.cells[0].innerHTML,relative_id); deleteRow(this)};
  var btn2=document.createElement('input');
  btn2.type="button";
  btn2.className="btn btn-xs btn-danger";
  btn2.value="Delete";
  
 
  btn2.onclick = function(){ soap("f",row.cells[0].innerHTML,relative_id);  deleteRow(this)};
	
	
	
	
   var row = table.insertRow(0);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  
  row.cells[0].innerHTML=jobid;
  row.cells[1].innerHTML=ownerid;
  row.cells[2].innerHTML=jobdescription
  
  row.cells[3].appendChild(btn);
  row.cells[3].appendChild(btn2);
}
</script>
