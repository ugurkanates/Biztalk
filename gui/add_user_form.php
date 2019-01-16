<?php
   include ('dashboard_admin.php');
?>
    <!-- Textual inputs start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <form action="manageUsers.php" method="POST">
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Username</label>
                    <input class="form-control" type="text" id="inputUsername" name="inputUsername" placeholder="User name" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label for="inputPassword" class="">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required autocomplete="off">
                </div>

                <!-- Radios start -->                                        
                <b class="text-muted mb-3 d-block">User Type:</b>
                <div>
                <input type="radio" id="inputUserType" name="inputUserType" value="admin">
                <label for="admin">Admin</label>
                </div>

                <div>
                <input type="radio" id="inputUserType" name="inputUserType" value="user">
                <label for="user">User</label>
                </div>

                <div>
                <input type="radio" id="inputUserType" name="inputUserType" value="manager">
                <label for="user">Manager</label>
                </div>

                <br/>
                <input class="btn btn-primary mb-3" type="submit" name="submit_button" id="submit_button">
            </form>                                             
        <!-- Radios end -->
            
<!-- Textual inputs end -->
        </div>
    </div>
</div>

 

