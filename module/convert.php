<?php

if($_REQUEST['o'] == 'convert')
{
	if(isset($_REQUEST['sym']) && isset($_REQUEST['confirm']))
	{
		$sym = mysql_real_escape_string(urldecode($_REQUEST['sym']));
		$id = $_SESSION['id'];
		$quantity = 0;
		$sql = "SELECT * FROM intraday WHERE symbol = '$sym' AND id = $id";
		
		$ref = query_database($sql);
		
		$row = mysql_fetch_assoc($ref);
		$count = mysql_num_rows($ref);
		
		$quantity = $row['amount'];
		$buying = $row['cost'] * 5;
		$margin = $row['cost'] * 4;
		
		$sql = "SELECT liq_cash FROM user WHERE id = $id";
		
		$ref = query_database($sql);
		
		$row = mysql_fetch_assoc($ref);
		$balance = $row['liq_cash'];
		
		if($balance > $margin && $count == 1)
		{
			$balance = $balance - $margin;
			$sql = "UPDATE user SET liq_cash = '$balance' WHERE id = '$id'";
			$ref = query_database($sql);
			$sql = "DELETE FROM intraday WHERE id = '$id' AND symbol = '$sym'";
			$sql = query_database($sql);
			$rate = $buying / $quantity;
			$sql = "SELECT * FROM stocks_bought WHERE id = '$id' AND symbol = '$sym'";
			$ref = query_database($sql);
			$count = mysql_num_rows($ref);
			if($count != 0)
			{
				$row = mysql_fetch_assoc($ref);
				$rate = ($row['rate'] * $row['amount'] + $rate * $quantity) / ($row['amount'] + $quantity);
				$quantity = $row['amount'] + $quantity;
				$sql = "UPDATE stocks_bought SET rate = '$rate', amount = '$quantity' WHERE id = '$id' AND symbol = '$sym'";
			
				
				$ref = query_database($sql);
			}

			else
			{
				$sql = "INSERT INTO stocks_bought (id,rate,symbol,amount) VALUES ('$id','$rate','$sym','$quantity')";
			
				$ref = query_database($sql);
			}
				$content .= "$sym converted from intraday to delivery";
		}
		else 
		{
			$content .= "Could not convert";
		}
	}
	else 
	{
		$sym = $sym = mysql_real_escape_string(urldecode($_REQUEST['sym']));
		$symencoded = $_REQUEST['sym'];
		
		$content .= '<form class = "buySellAction" method = "post" action = "index.php"><input type = "hidden" value = "' . $symencoded . '" name = "sym" /><input type = "hidden" value = "convert" name = "o" /><input type = "hidden" name = "confirm" value = "yes" />Are you sure you want to convert ' . $sym . ' <br /><input type = "submit" value = "yes" /></form>';
	}

}
		 
		
		
