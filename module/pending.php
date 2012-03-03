<?php 

if(isset($_SESSION['user']))
{
	if($_GET['o'] == 'pending' && isset($_GET['sym']) && isset($_GET['op']))
	{
		$sym = mysql_real_escape_string(urldecode($_GET['sym']));
		$option = mysql_real_escape_string($_GET['op']);
		$sql = "DELETE FROM lim WHERE symbol = '$sym' AND operation = '$option'";
		$ref = query_database($sql);
	}
	if($_GET['o'] == "pending")
	{
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM lim WHERE id = '$id'";

		$ref = query_database($sql);
		$count = mysql_num_rows($ref);
		if($count == 0)
		{
			$content .= "No pending orders";
		}
		else
		{
			$content .= '<table><tr><th>Type</th><th>Action</th><th>Symbol</th><th>Quantity</th><th>Rate</th><th></th></tr>';
			while($row = mysql_fetch_assoc($ref))
			{
				$symbol = $row['symbol'];
				$amount = $row['amount'];
				$rate = $row['rate'];
				if($rate == 0)
				{
					$rate = "Market Price";
				}
				$action = $row['operation'];
				$content .= "<tr><td>";
				if($action == 'sell')
				{
					$content .= "Delivery</td><td>Sell</td>";
				}
				else if($action == 'intrasell')
				{
					$content .= "Intraday</td><td>Sell</td>";
				}
				else if($action == 'intrabuy')
				{
					$content .= "Intraday</td><td>Buy</td>";
				}
				else if($action == 'buy')
				{
					$content .= "Delivery</td><td>Buy</td>";
				}
				else if($action == 'ssell')
				{
					$content .= "Delivery(Stop Loss)</td><td>Sell</td>";
				}
				else if($action == 'sintrasell')
				{
					$content .= "Intraday(Stop Loss)</td><td>Sell</td>";
				}
				else if($action == 'sintrabuy')
				{
					$content .= "Intraday(Stop Loss)</td><td>Buy</td>";
				}
				else if($action == 'sbuy')
				{
					$content .= "Delivery(Stop Loss)</td><td>Buy</td>";
				}
				
				$content .= "<td>$symbol</td><td>$amount</td><td>$rate</td><td><a href = \"index.php?o=pending&sym=". urlencode($symbol) . "&op=$action\">delete</a></td></tr>";
			}
			$content .= '</table>';
		}
	}
}
				
