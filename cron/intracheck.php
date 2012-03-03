<?php 
require_once("../core/bootstrap.php");

function sellin($sym,$user_id)
{
	$sql = "SELECT value FROM stockval WHERE symbol = '$sym'";
	$ref = query_database($sql);
	$row = mysql_fetch_assoc($ref);
	$rate = $row['value'];
	$sql = "SELECT * FROM intraday WHERE id = '" . $user_id . "' AND symbol = '$sym'";
	$ref = query_database($sql);
	$row = mysql_fetch_assoc($ref);
	
	if(mysql_num_rows($ref) > 0)
	{
		$amount = $row['amount'];
		$cost = $amount * $rate;
		$buying_price = $row['cost'] * 5;
		$sql = "SELECT liq_cash FROM user WHERE id = '" . $user_id . "'";
		$ref = query_database($sql);
		$row = mysql_fetch_assoc($ref);
		$cost = $cost - 0.001 * $cost;
		
		
		$cost = $cost - 4 * ($buying_price / 5);
		$cost = $row['liq_cash'] + $cost;
		
	
		$sql = "UPDATE user SET liq_cash = '$cost' WHERE id = '" . $user_id . "'";
		$ref = query_database($sql);
			
		$sql = "DELETE FROM intraday WHERE id = '" . $user_id . "' and symbol = '$sym'";
		$ref = query_database($sql);
		
	}
	else
	{
		$echo = "Unable to sell $sym";
	}

}


$sql = "SELECT * FROM intraday";
$ref = query_database($sql);
while($row = mysql_fetch_assoc($ref))
{
	$symbol = $row['symbol'];
	$sql = "SELECT value FROM stockval WHERE symbol = '$symbol'";
	$temp_ref = query_database($sql);
	$rw = mysql_fetch_assoc($temp_ref);
	$rate = $rw['value'];
	$current_cost = $rate * $row['amount'];
	
	$buying_price = $row['cost'] * 5;
	$loss = $current_cost - $buying_price;
	$margin = $row['cost'];
	$margin += $loss;
	echo $margin ." " . $loss; 
	if($margin < 0)
	{	
		sellin($symbol,$row['id']);
	}
}


