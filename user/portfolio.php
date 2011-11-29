<?php
if(isset($_SESSION['user']))
{
	$sql = "SELECT * FROM user WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	
	$content .= $row['name'] . "<br/>";
	$content .= $row['liq_cash'] . "<br/>";
	
	$sql = "SELECT * FROM stocks_bought WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$content .= "<table>";
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
