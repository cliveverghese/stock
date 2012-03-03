<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'buy')
	{
		$sql = "SELECT * FROM settings WHERE value = 'market'";
		$ref = query_database($sql);
		$row = mysql_fetch_assoc($ref);

		$status = $row['conf'];
		$symbol = null;
		$form = true;
	
		if(isset($_POST['sym']) && isset($_POST['amount']))
		{
			if($status != "closed")
			{
				$sym = mysql_real_escape_string(urldecode($_POST['sym']));
				$amount = mysql_real_escape_string($_POST['amount']);
				$amountCpy = $amount;
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$cost = $amount * $row['value'];
				$rate = $row['value'];
				$rateCpy = $rate;
				$sql = "SELECT liq_cash FROM user WHERE id = '" . $_SESSION['id'] . "'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$brokerage = 0.003 * $cost;
				$cost = $cost + 0.003 * $cost;
				$cost = $row['liq_cash'] - $cost;
				if($cost > 0)
				{
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $_SESSION['id'] . "'";
					$ref = query_database($sql);
					$sql = "SELECT * FROM stocks_bought WHERE id = '" . $_SESSION['id'] . "' AND symbol = '$sym'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
					if($count == 0)
					{
						$sql = "INSERT INTO stocks_bought(id,symbol,amount,rate) VALUES ('" . $_SESSION['id'] . "','$sym','$amount','$rate')";
					}
					else
					{		
						$row = mysql_fetch_assoc($ref);
						$rate = ($rate * $amount + $row['amount'] * $row['rate'])/($amount + $row['amount']); 
						$amount += $row['amount'];
						$sql = "UPDATE stocks_bought SET amount = '$amount', rate = '$rate' WHERE id = '" . $_SESSION['id'] . "' and symbol = '$sym'";
					}
					$ref = query_database($sql);
					
					$msg .= "Purchased $amountCpy Units of $sym at $rateCpy per Unit<br />Brokerage charges + tax = $brokerage<br />";
				}
				else
				{
					$msg .= "Insufficient Funds for $sym<br />";
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
	$content = $content . '<form class = "buySellAction" method = "post" action = "index.php">&nbsp;Symbol : <input type = "text" name = "sym" value = "' . $symbol . '"></input><br />Quantity : <input type = "text" name = "amount"></input><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rate : <input class = "limitBuy" type = "textbox" name = "rate" value = "Current Rate"></input><br />Stop Loss : <input class = "stoploss" type = "textbox" name = "stop" value = "Stop Loss"></input><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trade Type : <select name = "o"><option value = "buy">Delivery</option><option value = "intrabuy">Intraday</option></select><select class = "buySellType" name = "t"><option value = "current">Current Price</option><option value = "limit">Limit Price</option></select><input type = "checkbox" name = "amo" value = "amo">AMO</input><br /><input type = "submit"></form>';		
		}	
	
	}
	
}
		
