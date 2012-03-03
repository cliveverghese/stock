<?php
if(isset($_SESSION['user']))
{
$id = null;
if(isset($_GET['user']))
{
	$sql = "SELECT * FROM user_status WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	
	if($row['admin'] == 'T')
	{
		$id = $_GET['user'];
	}
	else 
	{
		$id = $_SESSION['id'];
	}
}
else 
	$id = $_SESSION['id'];
	
	$sql = "SELECT * FROM user WHERE id = '" . $id . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	
	$image = '<img src = "https://graph.facebook.com/' . $id . '/picture">';
	$name = $row['name'];
	$balance = $row['liq_cash'] ;
	$intraday_balance = $row['liq_cash'] * 5;
	
	$sql = "SELECT * FROM stocks_bought WHERE id = '" . $id . "'";
	$content = "";
	$ref = mysql_query($sql);
	$content .= "<br /><br /><table><tr><th>Symbol</th><th>Quantity</th><th>Purchase Rate</th><th>Current Rate</th><th>Total Cost</th><th>Gain/Loss</th><th></th></tr>";
	$total_profit = 0;
	if($ref)
	{
	while($row = mysql_fetch_assoc($ref))
	{	
		if($row['amount'] != 0)
		{
			$sql = "SELECT value FROM stockval WHERE symbol = '" . $row['symbol'] . "'";
			$temp_ref = (mysql_query($sql));
			$rate = mysql_fetch_assoc($temp_ref);
			$cost = $rate['value'] * $row['amount'];
			$profit = $rate['value'] * $row['amount'] - $row['rate'] * $row['amount'];
			$total_profit += $profit;
			$content .= "<tr><td>" . $row['symbol'] . "</td><td>" . $row['amount'] . "</td><td>" . $row['rate'] . "</td><td>" . $rate['value'] . "</td><td>$cost</td><td>$profit</td><td><a class = \"buyAction\" href = \"index.php?o=sell&sym=" . urlencode($row['symbol']) ."\">sell</a></tr>";
		}
	}
	$content .= "</table>";
	}
	$content .= "<br />&nbsp<br /><h3><strong>Intraday Stocks</strong></h3>";
	$sql = "SELECT * FROM intraday WHERE id = '" . $id . "'";
	$ref = mysql_query($sql);
	if($ref)
	{	
	$content .= "<br /><br /><table><tr><th>Symbol</th><th>Quantity</th><th>Purchase Cost</th><th>Current Rate</th><th>Total Cost</th><th>Gain/Loss</th><th></th><th></th></tr>";
	
	
	while($row = mysql_fetch_assoc($ref))
	{	
		if($row['amount'] != 0)
		{
			$sql = "SELECT value FROM stockval WHERE symbol = '" . $row['symbol'] . "'";
			$temp_ref = (mysql_query($sql));
			$rate = mysql_fetch_assoc($temp_ref);
			$cost = $rate['value'] * $row['amount'];
			$profit = $rate['value'] * $row['amount'] - ($row['cost'] * 5.00);
			$total_profit += $profit;
			$content .= "<tr><td>" . $row['symbol'] . "</td><td>" . $row['amount'] . "</td><td>" . $row['cost'] * 5 . "</td><td>" .  $rate['value'] . "</td><td>$cost</td><td>$profit</td><td><a class = \"buyAction\" href = \"index.php?o=intrasell&sym=" . urlencode($row['symbol']) ."\">sell</a></td><td><a class = \"buyAction\" href = \"index.php?o=convert&sym=".urlencode($row['symbol']) . "\">convert</a></td></tr>";
		}
	}
	
	$content .= "</table>";
	}
	
	
}
