<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'sell')
	{
		$symbol = null;
		$form = true;
		if(isset($_POST['sym']) && isset($_POST['amount']))
		{
				$sym = mysql_real_escape_string($_POST['sym']);
				$amount = mysql_real_escape_string($_POST['amount']);
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = mysql_query($sql);
				$row = mysql_fetch_assoc($ref);
				$cost = $amount * $row['value'];
				$sql = "SELECT liq_cash FROM user WHERE id = '" . $_SESSION['id'] . "'";
				$ref = mysql_query($sql);
				$row = mysql_fetch_assoc($ref);
				$cost = $row['liq_cash'] + $cost;
				$sql = "SELECT * FROM stocks_bought WHERE id = '" . $_SESSION['id'] . "' AND symbol = '$sym'";
				
				$ref = mysql_query($sql);
				$current_amount = mysql_fetch_assoc($ref);
				$count = mysql_num_rows($ref);
				if($current_amount['amount'] >= $amount && $count != 0)
				{
					$amount = $current_amount['amount'] - $amount;
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $_SESSION['id'] . "'";
					$ref = mysql_query($sql);
					
					$sql = "UPDATE stocks_bought SET amount = '$amount' WHERE id = '" . $_SESSION['id'] . "' and symbol = '$sym'";
					$ref = mysql_query($sql);
					$content .= '<a href = "index.php">home</a>';
				}
				else
				{
					$content .= "Unable to sell";
					$content = $content . '<a href = "index.php">home</a>';
				}

				$form = false;
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
	$content = $content . '<form method = "post" action = "index.php"><input type = "hidden" name = "o" value = "sell"></input><input type = "text" name = "sym" value = "' . $symbol . '"></input><input type = "text" name = "amount"></input><input type = "submit"></form>';		
		}	
	}
	
}
		
