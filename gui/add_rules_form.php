<?php
   include ('dashboard_admin.php');
 ?>
    <!-- Textual inputs start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <form action="addRules.php" method="POST">
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">RuleID</label>
                    <input class="form-control" type="text" id="RuleID" name="RuleID">
                </div>
                
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">JobID</label>
                    <input class="form-control" type="text" id="JobID" name="JobID">
                </div>

            
                    
              
                
                
                
                 <div class="col-lg-6 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Entry Type</h4>
                                <div id="accordion4" class="according accordion-s3 gradiant-bg">
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#accordion41">Entry Text</a>
                                        </div>
                                        <div id="accordion41" class="collapse show" data-parent="#accordion4">
                                            <div class="card-body">
                                                  <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label"></label>
                                                    <input class="form-control" type="text" id="EntryText" name="EntryText">
                                                </div>
                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#accordion42">Entry File</a>
                                        </div>
                                        <div id="accordion42" class="collapse" data-parent="#accordion4">
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile02">
                                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>  
                
                                            </div>
                                        </div>
                                    </div>
                               
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                <br/>
                <input class="btn btn-primary mb-3" type="submit" name="submit_button" id="submit_button">
            </form>                                             
        <!-- Radios end -->
            
<!-- Textual inputs end -->
        </div>
    </div>
</div>

 

