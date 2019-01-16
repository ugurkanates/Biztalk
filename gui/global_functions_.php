<?php
	function type_check ($type, $correct_url, $wrong_url)
	{
		echo $login_type;
		echo $type;
		echo $correct_url;
		echo $wrong_url;
		
		if ($login_type == $type)
		{
			header($correct_url);
		}
		else
		{
			header($wrong_url);
		}
	}

?>