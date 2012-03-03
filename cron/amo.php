<?php 
require_once("../core/bootstrap.php");
function buy($sym,$amount,$id)
{
				$content = "";			
				$amountCpy = $amount;
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$cost = $amount * $row['value'];
				$rate = $row['value'];
				$rateCpy = $rate;
				$sql = "SELECT liq_cash FROM user WHERE id = '" . $id . "'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$brokerage = 0.003 * $cost;
				$cost = $cost + 0.003 * $cost;
				$cost = $row['liq_cash'] - $cost;
				if($cost > 0)
				{
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $id . "'";
					$ref = query_database($sql);
					$sql = "SELECT * FROM stocks_bought WHERE id = '" . $id . "' AND symbol = '$sym'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
					if($count == 0)
					{
						$sql = "INSERT INTO stocks_bought(id,symbol,amount,rate) VALUES ('" . $id . "','$sym','$amount','$rate')";
					}
					else
					{		
						$row = mysql_fetch_assoc($ref);
						$rate = ($rate * $amount + $row['amount'] * $row['rate'])/($amount + $row['amount']); 
						$amount += $row['amount'];
						$sql = "UPDATE stocks_bought SET amount = '$amount', rate = '$rate' WHERE id = '" . $id . "' and symbol = '$sym'";
					}
					$ref = query_database($sql);
					
					$content .= "Purchased $amountCpy Units of $sym at $rateCpy per Unit<br />Brokerage charges + Tax = $brokerage<br />";
				}
				else
				{
					$content .= "Insufficient Funds for $sym<br />";
				}

				return $content;
}

function sell($sym,$amount,$id)
{
				$amountCpy = $amount;
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$rate = $row['value'];
				$cost = $amount * $row['value'];
				$sql = "SELECT liq_cash FROM user WHERE id = '" . $id . "'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$brokerage = $cost * 0.003;
				$cost = $cost - 0.003 * $cost;
				$cost = $row['liq_cash'] + $cost;
				$sql = "SELECT * FROM stocks_bought WHERE id = '" . $id . "' AND symbol = '$sym'";
				
				$ref = query_database($sql);
				$current_amount = mysql_fetch_assoc($ref);
				$count = mysql_num_rows($ref);
				if($current_amount['amount'] >= $amount && $count != 0)
				{
					$amount = $current_amount['amount'] - $amount;
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $id . "'";
					$ref = query_database($sql);
					
					$sql = "UPDATE stocks_bought SET amount = '$amount' WHERE id = '" . $id . "' and symbol = '$sym'";
					$ref = query_database($sql);
					
					$content .= "Sold $amountCpy Units of $sym at $rate per Unit<br />Brokerage + Tax = $brokerage<br />";
					
				}
				else
				{
					$content .= "Unable to Sell $sym";
					$content = $content . '<a href = "index.php">home</a>';
				}

				return $content;
		}	

function intrasell($sym,$id)
{
				
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$rate = $row['value'];
				$sql = "SELECT * FROM intraday WHERE id = '" . $id . "' AND symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				echo $sql;
				
				
				if(mysql_num_rows($ref) > 0)
				{
					$amount = $row['amount'];
					$cost = $amount * $rate;
					$buying_price = $row['cost'] * 5;
					$sql = "SELECT liq_cash FROM user WHERE id = '" . $id . "'";
					$ref = query_database($sql);
					$row = mysql_fetch_assoc($ref);
					$brokerage = $cost * 0.001;
					$cost = $cost - 0.001 * $cost;
					
					
					$cost = $cost - 4 * ($buying_price / 5);
					$cost = $row['liq_cash'] + $cost;
					
				
					$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $id . "'";
					$ref = query_database($sql);
					
					$sql = "DELETE FROM intraday WHERE id = '" . $id . "' and symbol = '$sym'";
					$ref = query_database($sql);
					$content .= "Sold $amount Units of $sym at $rate per Unit<br />Brokerage + Tax = $brokerage<br />";
			
				}
				else
				{
					$content .= "Unable to Sell $sym";
					
				}

				$form = false;
				return $content;
}

function intrabuy($sym,$amount,$id)
{
				$amountCpy = $amount;
				$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$cost = $amount * $row['value'];
				$rate = $row['value'];
				$rateCpy = $rate;
				$sql = "SELECT liq_cash FROM user WHERE id = '" . $id . "'";
				$ref = query_database($sql);
				$row = mysql_fetch_assoc($ref);
				$brokerage = $cost * 0.001;
				$netcost = $cost + 0.001 * $cost;
				$intrabal = ($row['liq_cash'] * 5) - $netcost;
				if($intrabal > 0)
				{
					$cost = $cost / 5;
					$balance = $intrabal / 5;
					$sql = "UPDATE user SET liq_cash = '$balance' WHERE id = '" . $id . "'";
					$ref = query_database($sql);
					$sql = "SELECT * FROM intraday WHERE id = '" . $id . "' AND symbol = '$sym'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
					if($count == 0)
					{
						
						$sql = "INSERT INTO intraday(id,symbol,amount,cost) VALUES ('" . $id . "','$sym','$amount','$cost')";
					$ref = query_database($sql);
					$content .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					}
					else
					{		
						$row = mysql_fetch_assoc($ref);
						
						$cost = $cost + $row['cost']; 
						$amount += $row['amount'];
						$sql = "UPDATE intraday SET amount = '$amount', cost = '$cost' WHERE id = '" . $id . "' and symbol = '$sym'";
						$ref = query_database($sql);
					$content .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					}
					//$ref = query_database($sql);
					//$content .= "Purchased $amountCpy Units of $sym at $rateCpy per unit <br />Brokerage Charges + Tax = $brokerage<br />";
					
				}
				else
				{
					$content .= "Insufficient Funds for $sym<br />";
					
				}

				return $content;
		}


$sql = "SELECT * FROM settings WHERE value = 'market'";
$ref = query_database($sql);
$market = "closed";
$row = mysql_fetch_assoc($ref);
$market = $row['conf'];
$content = null;
if($market == "open")
{
	$sql = "UPDATE lim SET amo = '0'";
	$ref = query_database($sql);
	$sql = "SELECT * FROM lim WHERE rate = 'null'";
	$ref = query_database($sql);
	$count = mysql_num_rows($ref);
	$msg = null;
	if($count > 0)
	{
		while($row = mysql_fetch_assoc($ref))
		{
			if($row['operation'] == 'intrabuy')
			{
				$msg = intrabuy($row['symbol'],$row['amount'],$row['id']);
			}
			else if($row['operation'] == 'intrasell')
			{
				$msg = intrasell($row['symbol'],$row['id']);
			}
			else if($row['operation'] == 'buy')
			{
				$msg = buy($row['symbol'],$row['amount'],$row['id']);
			}
			else if($row['operation'] == 'sell')
			{
				$msg = sell($row['symbol'],$row['amount'],$row['id']);
			}
			$sql = "INSERT INTO notifications(id,notification,status) VALUES('" . $row['id'] . "','$msg','ur')";
			$r = query_database($sql);
			$sql = "DELETE FROM lim WHERE id = '" . $row['id'] . "' AND symbol = '" . $row['symbol'] . "' AND operation = '" . $row['operation'] . "'";
			$r = query_database($sql);
		}
	}
	$sql = "SELECT lim.id,lim.symbol,lim.rate,lim.operation,lim.amount FROM lim,stockval WHERE lim.symbol = stockval.symbol AND lim.operation IN ('buy','intrabuy') AND lim.rate >= stockval.value";
	$ref = query_database($sql);
	$count = mysql_num_rows($ref);
	$msg = null;
	if($count > 0)
	{
		while($row = mysql_fetch_assoc($ref))
		{
			if($row['operation'] == "intrabuy")
			{
				$msg = intrabuy($row['symbol'],$row['amount'],$row['id']);
			}
			else if($row['operation'] == 'buy')
			{
				$msg = buy($row['symbol'],$row['amount'],$row['id']);

			}
			$sql = "INSERT INTO notifications(id,notification,status) VALUES('" . $row['id'] . "','$msg','ur')";
			$r = query_database($sql);
			$sql = "DELETE FROM lim WHERE id = '" . $row['id'] . "' AND symbol = '" . $row['symbol'] . "' AND operation = '" . $row['operation'] . "'";
			$r = query_database($sql);
		}
	}
	$sql = "SELECT lim.id,lim.symbol,lim.rate,lim.operation,lim.amount FROM lim,stockval WHERE lim.symbol = stockval.symbol AND lim.operation IN ('sbuy','sintrabuy') AND lim.rate <= stockval.value";
	$ref = query_database($sql);
	$count = mysql_num_rows($ref);
	$msg = null;
	if($count > 0)
	{
		while($row = mysql_fetch_assoc($ref))
		{
			if($row['operation'] == "sintrabuy")
			{
				$msg = intrabuy($row['symbol'],$row['amount'],$row['id']);
			}
			else if($row['operation'] == 'sbuy')
			{
				$msg = buy($row['symbol'],$row['amount'],$row['id']);

			}
			$sql = "INSERT INTO notifications (id,notification,status) VALUES('" . $row['id'] . "','$msg','ur')";
			$r = query_database($sql);
			$sql = "DELETE FROM lim WHERE id = '" . $row['id'] . "' AND symbol = '" . $row['symbol'] . "' AND operation = '" . $row['operation'] . "'";
			$r = query_database($sql);
		}
	}	

	$sql = "SELECT lim.id,lim.symbol,lim.rate,lim.operation,lim.amount FROM lim,stockval WHERE lim.symbol = stockval.symbol AND lim.operation IN ('sell','intrasell') AND lim.rate <= stockval.value";
	$ref = query_database($sql);
	$count = mysql_num_rows($ref);
	$msg = null;
	if($count > 0)
	{
		while($row = mysql_fetch_assoc($ref))
		{
			if($row['operation'] == "intrasell")
			{
				
				$msg = intrasell($row['symbol'],$row['id']);
			}
			else if($row['operation'] == 'sell')
			{
				$msg = sell($row['symbol'],$row['amount'],$row['id']);
			}
			$sql = "INSERT INTO notifications (id,notification,status) VALUES('" . $row['id'] . "','$msg','ur')";
			$r = query_database($sql);
			$sql = "DELETE FROM lim WHERE id = '" . $row['id'] . "' AND symbol = '" . $row['symbol'] . "' AND operation = '" . $row['operation'] . "'";
			$r = query_database($sql);
		}
	}
	$sql = "SELECT lim.id,lim.symbol,lim.rate,lim.operation,lim.amount FROM lim,stockval WHERE lim.symbol = stockval.symbol AND lim.operation IN ('ssell','sintrasell') AND lim.rate >= stockval.value";
	$ref = query_database($sql);
	$count = mysql_num_rows($ref);
	$msg = null;
	if($count > 0)
	{
		while($row = mysql_fetch_assoc($ref))
		{
			if($row['operation'] == "sintrasell")
			{
				
				$msg = intrasell($row['symbol'],$row['id']);
			}
			else if($row['operation'] == 'ssell')
			{
				$msg = sell($row['symbol'],$row['amount'],$row['id']);
			}
			$sql = "INSERT INTO notifications(id,notification,status) VALUES('" . $row['id'] . "','$msg','ur')";
			$r = query_database($sql);
			$sql = "DELETE FROM lim WHERE id = '" . $row['id'] . "' AND symbol = '" . $row['symbol'] . "' AND operation = '" . $row['operation'] . "'";
			$r = query_database($sql);
		}
	}
}



