<?php
	include('config.php');
	include('global_functions_.php');
	

	if(isset($_SESSION['login_user']))
	{
		$ses_type_sql = mysqli_query($db,"select type from tbl_usr where username = '$user_check' ");
		if ($ses_type_sql == 'admin')
		{
			type_check('admin',"location:dashboard_admin.php","location:dashboard_user.php");
		}
		if ($ses_type_sql == 'manager')
		{
			type_check('manager',"location:dashboard_manager.php","location:dashboard_manager.php");
		}
		else
		{
			type_check('user',"location:dashboard_user.php","location:dashboard_admin.php");
		}
	}
?>