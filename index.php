<?php


	session_start();		
	require_once('core/bootstrap.php');
	
	if(!isset($_SESSION['mobile']))
	{
		if(isset($_COOKIE['mobile']))
		{
			if($_COOKIE['mobile'] == 1)
			{
				$_SESSION['mobile'] = true;
			}
			else
			{
				$_SESSION['mobile'] = false;
			}
		}
		else 
			$_SESSION['mobile'] = false;
	
	}	
	if(isset($_REQUEST["signed_request"]))
	{	
		require_once('user/verify.php');
	}
	else if(!isset($_SESSION['user']))
	{
		//echo '<head><meta HTTP-EQUIV="REFRESH" content="0; url=index.php"></head>';
		//
		require_once('theme/login.php');
			
		require_once('user/verify.php');

	}
	$content = null;
	$UserBalance = null;
	$pageRefresh = false;
	$theme = true;
	
	if(!$_SESSION['completed'])
	{

		require_once('module/updateProfile.php');
	}
	else if(isset($_REQUEST['o']))
	{	

		if(isset($_SESSION['user']))
		{
			if(isset($_REQUEST['amo']) && ($_REQUEST['amo'] == "amo"))
			{
				require_once('module/amo.php');
				
			}
			else if(isset($_REQUEST['t']) && ($_REQUEST['t'] == "limit"))
			{
				require_once('module/limitbuysell.php');
			}				
			else if($_REQUEST['o'] == "buy")
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
				$pageRefresh = true;
				$theme = false;
				require_once('theme/portfolio.php');
			}
			else if($_REQUEST['o'] == "feedback")
			{
				require_once('module/feedback.php');
			}
			else if($_REQUEST['o'] == "intrabuy")
			{
				require_once('module/intrabuy.php');
			}
			else if($_REQUEST['o'] == "intrasell")
			{
				require_once('module/intrasell.php');
			}
			else if($_REQUEST['o'] == "listStocks")
			{
				require_once('module/userhome.php');
				$pageRefresh = true;
			}
			else if($_REQUEST['o'] == "limitbuy")
			{
				require_once('module/limitbuy.php');
			}
			else if($_REQUEST['o'] == "limitsell")
			{
				require_once('module/limitsell.php');
			}
			else if($_REQUEST['o'] == "pending")
			{
				require_once('module/pending.php');
			}
			else if($_REQUEST['o'] == "notifications")
			{
				require_once('module/notifications.php');
			}
			else if($_REQUEST['o'] == "page")
			{
				
				require_once('page/rules.php');
							
			}
			else if($_REQUEST['o'] == "winners")
			{
				require_once('page/winners.php');
			}
			else if($_REQUEST['o'] == "leader")
			{
				require_once('module/leader.php');
			}
				
			else if($_REQUEST['o'] == "admin")
			{
				require_once('admin/admin.php');
			}
			else if($_REQUEST['o'] == 'convert')
			{
				require_once('module/convert.php');
			}
			else
			{
				require_once('module/stockwatch.php');
				$pageRefresh = true;

			}		
			require_once('user/userProps.php');
		}
		else if($_REQUEST['o'] == "login")
		{
			//require_once('user/list.php');
		}

	
		
	}
	
	else
	{
		require_once('module/stockwatch.php');
		require_once('user/userProps.php');
		$pageRefresh = true;
	}

		
	if(isset($_SESSION['user']) && $theme)
	{
		require_once('theme/userprofile.php');
	}

	$sql = "SELECT * FROM settings WHERE value = 'market'";
		$ref = query_database($sql);
		$row = mysql_fetch_assoc($ref);

		$status = $row['conf'];
	if(isset($_SESSION['user']) && $status == 'closed')
	{
		require_once('module/postfb.php');
	}	
	
	
?>
