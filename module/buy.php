<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'buy')
	{
		$symbol = null;
		$form = true;
		if(isset($_POST['sym']) && isset($_POST['amount']))
		{
				
				$form = false;
		}	

		if(isset($_GET['sym']))
		{
			$symbol = $_GET['sym'];
		}
		else 
		{
			$symbol = "Symbol";
		}
		if($form)
		{
	$content = $content . '<form method = "post" action = "index.php"><input type = "hidden" name = "o" value = "buy"></input><input type = "text" name = "sym" value = "' . $symbol . '"></input><input type = "text" name = "amount"></input><input type = "submit"></form>';		
		}	
	}
	
}
		
