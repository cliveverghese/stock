<?php 
require_once("../core/bootstrap.php");

function sell($sym,$user_id)
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
		$echo = "Unable to sell $user_id";
	}

}


$sql = "SELECT * FROM intraday";
$ref = query_database($sql);
while($row = mysql_fetch_assoc($ref))
{
	$symbol = $row['symbol'];	
	sell($symbol,$row['id']);
}
$sql = "SELECT user.id,bought.total_bought,intra.total_intra,liq_cash,name FROM user
LEFT OUTER JOIN (
SELECT stocks_bought.id,SUM(stocks_bought.amount * stockval.value) AS total_bought FROM stocks_bought,stockval WHERE stocks_bought.symbol = stockval.symbol GROUP BY stocks_bought.id) bought
ON user.id = bought.id
LEFT OUTER JOIN(
SELECT
intraday.id,SUM(intraday.amount * stockval.value - intraday.cost * 4) AS total_intra FROM intraday,stockval WHERE intraday.symbol = stockval.symbol GROUP BY intraday.id) intra
ON user.id = intra.id
GROUP BY user.id
DESC";
	$ref = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($ref))
	{
		$sum = $row['total_bought'] + $row['total_intra'] + $row['liq_cash'];
		$sql = "UPDATE user SET day_worth = '$sum' WHERE id = '{$row['id']}'";
		$temp = mysql_query($sql);
	}
	$sql = "UPDATE user_status SET facebook_post = 'F'";
	$ref = mysql_query($sql);


