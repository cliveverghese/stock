<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'intrabuy')
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
				$brokerage = $cost * 0.001;
				$netcost = $cost + $brokerage;
				$intrabal = ($row['liq_cash'] * 5) - $netcost;
				if($intrabal > 0)
				{
					$cost = $cost / 5;
					$balance = $intrabal / 5;
					$sql = "UPDATE user SET liq_cash = '$balance' WHERE id = '" . $_SESSION['id'] . "'";
					$ref = query_database($sql);
					$sql = "SELECT * FROM intraday WHERE id = '" . $_SESSION['id'] . "' AND symbol = '$sym'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
					if($count == 0)
					{
						
						$sql = "INSERT INTO intraday(id,symbol,amount,cost) VALUES ('" . $_SESSION['id'] . "','$sym','$amount','$cost')";
					$ref = query_database($sql);
					$msg .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					}
					else
					{		
						$row = mysql_fetch_assoc($ref);
						
						$cost = $cost + $row['cost']; 
						$amount += $row['amount'];
						$sql = "UPDATE intraday SET amount = '$amount', cost = '$cost' WHERE id = '" . $_SESSION['id'] . "' and symbol = '$sym'";
						query_database($sql);
					$msg .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					}
					//$ref = query_database($sql);
					//$msg .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					
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
	$content = $content . '<form method = "post" action = "index.php"><input type = "hidden" name = "o" value = "intrabuy"></input>Symbol :<input type = "text" name = "sym" value = "' . $symbol . '"></input><br />Amount(Number of units)<input type = "text" name = "amount"></input><input type = "submit"></form>';		
		}	
	}
	
}
		
