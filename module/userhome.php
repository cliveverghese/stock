<?php 

if(isset($_SESSION['user']))
{
	$limit = 'LIMIT 0,40';
	if(isset($_GET['page']))
	{
		if($_GET['page'] == '1')
		{
			$limit = 'LIMIT 0,40';
		} 
		else if($_GET['page'] == '2')
		{
			$limit = 'LIMIT 41,40';
		}
		else if($_GET['page'] == '3')
		{
			$limit = 'LIMIT 81,40';
		}
		else if($_GET['page'] == '4')
		{
			$limit = 'LIMIT 121,40';
		}
	}
	$sql = "SELECT * FROM stockval ORDER BY symbol " . $limit;
	$ref = mysql_query($sql);
	$content .= '<ul id = "page"><li class = "anchor"></li><li><a href = "index.php?o=listStocks&page=1">A-F</a></li><li><a href = "index.php?o=listStocks&page=2">G-M</a></li><li><a href = "index.php?o=listStocks&page=3">M-T</a></li><li><a href = "index.php?o=listStocks&page=4">T-Z</a></li></ul><div style = "clear:both"></div>';

	$content = $content . "<table><tr><th>Symbol</th><th>Value</th><th>Change</th><th>Day Low</th><th>Day High</th><th>30 days</th><th>Today</th><th></th><th></th></tr>";

	while($row = mysql_fetch_assoc($ref))
	{
		$chng = "down";
				if($row['chnge'] > 0)
				{
					$chng = "up";
				}
				else 	
					$chng = "down";
		$content = $content . "<tr><td>" .$row['symbol'] . "</td><td>" . $row['value'] . "</td><td class = \"$chng\">" . $row['chnge'] . "</td><td>" . $row['day_low'] . "</td><td>" . $row['day_high'] . "</td><td><img src = \"http://conjura.in/bullsndbears/images/monthly/" . $row['symbol'] . "M.png\" /></td><td><img src = \"http://conjura.in/bullsndbears/images/day/" . $row['symbol'] . ".png\" /></td><td><a class = \"buyAction\" href = \"index.php?o=buy&sym=" . urlencode($row['symbol']) . "\">Buy</a></td><td>";
		$content .= '<form class = "watchAction" method = "post" action = "index.php"><input type = "hidden" name = "action" value = "add"></input><input type = "hidden" name = "symbol" value = "' . $row['symbol'] . '"></input><input type = "submit" value = "Add Watch"></input></form></td></tr>';
	}
	$content = $content . "</table>";
	$content .= "<br />";
	$content .= '<div style = "clear:both"></div><ul id = "page"><li class = "anchor"></li><li><a href = "index.php?o=listStocks&page=1">A-F</a></li><li><a href = "index.php?o=listStocks&page=2">G-M</a></li><li><a href = "index.php?o=listStocks&page=3">M-T</a></li><li><a href = "index.php?o=listStocks&page=4">T-Z</a></li></ul><div style = "clear:both"></div>';
	

}
