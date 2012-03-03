<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'intrasell')
	{
		$sql = "SELECT * FROM settings WHERE value = 'market'";
		$ref = query_database($sql);
		$row = mysql_fetch_assoc($ref);
		$status = $row['conf'];
		$symbol = null;
		$form = true;
		if(isset($_POST['sym']))
		{
			if($status != "closed")
			{
				$sym = mysql_real_escape_string(urldecode($_POST['sym']));
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$rate = $row['value'];
				$sql = "SELECT * FROM intraday WHERE id = '" . $_SESSION['id'] . "' AND symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				
				if(mysql_num_rows($ref) > 0)
				{
					$amount = $row['amount'];
					$cost = $amount * $rate;
					$buying_price = $row['cost'] * 5;
					$sql = "SELECT liq_cash FROM user WHERE id = '" . $_SESSION['id'] . "'";
					$ref = query_database($sql);
					$row = mysql_fetch_assoc($ref);
					$brokerage = $cost * 0.001;
					
					$cost = $cost - $brokerage;
					
					$cost = $cost - 4 * ($buying_price / 5);
					
					$cost = $row['liq_cash'] + $cost;
					
				
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $_SESSION['id'] . "'";
					$ref = query_database($sql);
					
					$sql = "DELETE FROM intraday WHERE id = '" . $_SESSION['id'] . "' and symbol = '$sym'";
					$ref = query_database($sql);
					$msg .= "Sold $amount Units of $sym at $rate per Unit<br />Brokerage + tax = $brokerage<br />";
			
				}
				else
				{
					$msg .= "Unable to sell $sym";
					
				}
				$content = $msg;
				$sql = "INSERT INTO notifications (id,notification,status) VALUES('" . $_SESSION['id'] . "','$msg','ur')";
				$ref = query_database($sql);

				$form = false;
			}
			else
			{
				$content .= "Market is closed";
				$form = false;
			}
		}	

		else if(isset($_GET['sym']))
		{
			$symbol = $_GET['sym'];
		}
		else 
		{
			$symbol = "Symbol";
		}
		if($form)
		{
	$content = $content . '<form class = "buySellAction" method = "post" action = "index.php"><input type = "hidden" name = "o" value = "intrasell"></input><input type = "hidden" name = "sym" value = "' . $symbol . '"></input><br />Are you sure you want to sell ' . $symbol .'??..<br />Rate : <input class = "limitBuy" type = "textbox" name = "rate" value = "Current Rate"></input><br />Stop Loss : <input class = "stoploss" type = "textbox" name = "stop" value = "Stop Loss"></input><br /><select class = "buySellType" name = "t"><option value = "Current">Sell</option><option value = "limit">Limit</option></select><input type = "checkbox" name = "amo" value = "amo">AMO</input><br /><input type = "submit" value = "Yes"></input></form>';		
		}	
	}
	
}
		
