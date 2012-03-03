<?php 
	if(!isset($_GET['p']))
	{
		$_GET['page'] == 'rules';
	}
	
	if($_GET['page'] == 'rules')
	{
		require_once("rules.php");
	}
	else if($_GET['page'] == 'winners')
	{
		require_once("winners.php");
	}
