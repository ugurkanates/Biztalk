<?php
   include ('dashboard_admin.php');
?>
<script language="javascript">
    function addDestination()
    {
        var i = 1;
        jobScreen.innerHTML = jobScreen.innerHTML +"<br> <input type='text' value ='Please enter IP!' name='mytext'+ i> </br>"
    }
</script>

<!-- Textual inputs start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Create New Job</h4>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">JOB ID</label>
                                            <input class="form-control" type="label_job_id" placeholder="Please enter job id!" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-form-label">JOB DESCRIPTION</label>
                                            <input class="form-control" type="label_job_description" placeholder="Please enter job description!" id="example-search-input">
                                        </div>
                                        <action action="post" name="form" method="">
                                        <input class="text" name=t1 type="label_destination" placeholder="Please enter IP!" id="destination">
                                        <input class="text" type="button" value="add" onclick="addDestination()">
                                        <div id="jobScreen"></div>

                                        <button style="float:right" type="submit" class="btn btn-primary mt-4 pl-4 pr-4">Save</button>

                                    </div>
                                </div>
                            </div>
                            <!-- Textual inputs end -->
