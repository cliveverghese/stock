<?php
if(isset($_SESSION['user']))
{
	$sql = "SELECT * FROM user WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	
	$content .= '<img src = "https://graph.facebook.com/' . $_SESSION['id'] . '/picture"><br />Name : ';
	$content .= $row['name'] . "<br/>Balance : ";
	$content .= $row['liq_cash'] . "<br/>";
	
	$sql = "SELECT * FROM stocks_bought WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$content .= "<br /><br /><table><tr><td>Symbol</td><td>Amount</td><td>Purchase Rate(Average)</td><td>Current Rate</td></tr>";
	while($row = mysql_fetch_assoc($ref))
	{	
		if($row['amount'] != 0)
		{
			$sql = "SELECT value FROM stockval WHERE symbol = '" . $row['symbol'] . "'";
			$temp_ref = (mysql_query($sql));
			$rate = mysql_fetch_assoc($temp_ref);
			$content .= "<tr><td>" . $row['symbol'] . "</td><td>" . $row['amount'] . "</td><td>" . $row['rate'] . "</td><td>" . $rate['value'] . "</td><td><a href = \"index.php?o=sell&sym=" . urlencode($row['symbol']) ."\">sell</a></tr>";
		}
	}
	
	$content .= "</table>";
	
}
