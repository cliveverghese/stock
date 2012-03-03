<?php 
$content .= "<h2>LeaderBoard</h2>";


	function cmp($a,$b)
	{
		if($a['sum'] == $b['sum'])
			return 0;
		return $a['sum'] < $b['sum'] ? 1 : -1;
	}
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM user_status WHERE id = '$id'";
	
	$ref = mysql_query($sql);
	$adm = mysql_fetch_assoc($ref);
	$admin = false;
	if($adm['admin'] == 'T')
	{
		$admin = true;
	}
	
	$sql = "SELECT user.id,bought.total_bought,intra.total_intra,liq_cash,name FROM user
LEFT OUTER JOIN (
SELECT stocks_bought.id,SUM(stocks_bought.amount * stockval.value) AS total_bought FROM stocks_bought,stockval WHERE stocks_bought.symbol = stockval.symbol GROUP BY stocks_bought.id) bought
ON user.id = bought.id
LEFT OUTER JOIN(
SELECT
intraday.id,SUM(intraday.amount * stockval.value - intraday.cost * 4) AS total_intra FROM intraday,stockval WHERE intraday.symbol = stockval.symbol GROUP BY intraday.id) intra
ON user.id = intra.id
WHERE user.liq_cash != 100000
GROUP BY user.id
DESC";
	$ref = mysql_query($sql);
	$i = 0;
	
	

	while($r = mysql_fetch_assoc($ref))
	{
		
		$row[$i] = $r;
		$row[$i]['sum'] = $r['total_bought'] + $r['total_intra'] + $r['liq_cash'];
		$i++;
		
	}
	usort($row,"cmp");
	
	
	$content .= "<table><tr><th>#</th><th>Name</th><th>Net Worth</th></tr>";
	$j = 0;
	$k = 1;

	for($j=0;$j<$i;$j++)
	{
		$content .= "<tr><td>" . $k . "</td><td>" . $row[$j]['name'] . "</td><td>" . $row[$j]['sum'] . "</td>";
	
		if($admin)
			$content .= "<td><a href = \"index.php?o=portfolio&user=" . $row[$j]['id'] . "\">portfolio</a></td>";
	
		
		$content .="</tr>";
		
		$k++;
	
		
	
	}
	$content .= "</table>";


