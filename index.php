<?php
	session_start();		
	require_once('core/bootstrap.php');
	$content = null;
	if(isset($_REQUEST['o']))
	{	

		if(isset($_SESSION['user']))
		{
			if($_REQUEST['o'] == "buy")
			{
				require_once('module/buy.php');
			}
			else
			{
				require_once('module/userhome.php');
			}
		}
		if($_REQUEST['o'] == "login")
		{
			require_once('user/list.php');
		}
		
	}
	else
	{
		require_once('module/userhome.php');
	}	

	echo $content;
?>
