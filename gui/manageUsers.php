<?php
    include ('dashboard_admin.php');
    include("config.php");
    error_reporting(E_ALL); ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $myusername = mysqli_real_escape_string($db,$_POST['inputUsername']);
        $mypassword = mysqli_real_escape_string($db,$_POST['inputPassword']);
        $mytype =     mysqli_real_escape_string($db,$_POST['inputUserType']); 
       // $passwordHash = sha1($_POST['password']);
        $sql = "INSERT INTO tbl_usr (username, password, type)
        VALUES ('$myusername', '$mypassword', '$mytype')";

        if ($db->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>
                <strong>Well done!</strong> You successfully added a user.
            </div>";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }
        
    $sql_select = "SELECT * FROM tbl_usr";
    $result = $db->query($sql_select); 
        
//    <!-- Textual inputs start -->
echo "
<div class='col-12 mt-5'>
    <div class='card'>
        <div class='card-body'>
            <!-- Striped table start -->
                <div class='col-lg-6 mt-5'>
                    <div class='card'>
                        <div class='card-body'>
                            <h4 class='header-title'>Users</h4>
                            <div style='width:750px;' class='single-table'>
                                <div class='table-responsive'>
                                    <table class='table table-striped text-center'>
                                        <thead class='text-uppercase'>
                                            <tr>
                                                <th scope='col'>ID</th>
                                                <th scope='col'>Name</th>
                                                <th scope='col'>Password</th>
                                                <th scope='col'>User Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                            
                                            $count = 1;
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>".$count++."</th>";
                                                    echo "<td>".$row['username']."</td>";
                                                    echo "<td>".$row['password']."</td>";
                                                    echo "<td>".$row['type']."</td>";
                                                    echo "<td>";
                                                    echo "<form action='deleteUser.php' method='POST'>";
                                                    echo "<input type='hidden' id='delIndex' name='delIndex' value='".$row['id']."'/>";
                                                    echo "<input type='submit' value='Delete' class='btn btn-rounded btn-danger mb-3'/>";
                                                    echo "</form>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            }else{
                                                echo "0 results";
                                            }

                                        echo"
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Striped table end -->
                   
<!-- Textual inputs end -->
        </div>
    </div>
</div>
";

?>

 

