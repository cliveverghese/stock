<?php
	session_start();		
	require_once('core/bootstrap.php');
	
	if(isset($_REQUEST["signed_request"]))
	{	
	require_once('user/verify.php');
	}
	$content = null;
	if(isset($_REQUEST['o']))
	{	

		if(isset($_SESSION['user']))
		{
			if($_REQUEST['o'] == "buy")
			{
				require_once('module/buy.php');
			}
			else if($_REQUEST['o'] == "sell")
			{
				require_once('module/sell.php');
			}
			else if($_REQUEST['o'] == "portfolio")
			{
				require_once('user/portfolio.php');
			}
			else
			{
				require_once('module/userhome.php');

			}		
}
		else if($_REQUEST['o'] == "login")
		{
			require_once('user/list.php');
		}

	
		
	}
	else
	{
		require_once('module/userhome.php');
	}	
	require_once('theme/userprofile.php');
	
?>
