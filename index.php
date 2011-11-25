<?php
	session_start();		
	require_once('core/bootstrap.php');
	if(isset($_GET['option']))
	{	
		if($_GET['option'] == "login")
		{
			require_once('user/list.php');
		}
	}
	else
	{
		echo $_SESSION['user'];
	}	

?>
