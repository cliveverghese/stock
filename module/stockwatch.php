<?php 

if(isset($_SESSION['user']))
{
	if(isset($_POST['symbol'])&&isset($_POST['action']))
	{
		$symbol = mysql_real_escape_string($_POST['symbol']);
		if($_POST['action'] == 'add')
		{
			$id = $_SESSION['id'];
			$sql = "SELECT * FROM watch WHERE id = '$id' AND symbol = '$symbol'";
			
			$ref = mysql_query($sql);
			$count = 0;			
			$count = mysql_num_rows($ref);
			$sql = "SELECT * FROM watch WHERE id = '$id'";
			$ref = mysql_query($sql);
			$max = mysql_num_rows($ref);

			if($count == 0 && $max < 51)
			{			
				$sql = "INSERT INTO watch(id,symbol) VALUES('$id','$symbol')";
				$ref = mysql_query($sql);
				$content .= "watch added";
			
			}
			else if($count != 0)
			{	
				$content .= "Watch already exists";
			}
			else
			{
				$content .= "You have exceeded your limit";
			}

				
		}
		else if($_POST['action'] == 'remove')
		{
			$id = $_SESSION['id'];
			$sql = "DELETE FROM watch WHERE id = '$id' AND symbol = '$symbol'";
			$ref = mysql_query($sql);
			$content .= "watch removed";
		}
	}
	else
	{
		
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM watch WHERE id = '$id'";
		$ref = mysql_query($sql);
		if(mysql_num_rows($ref) != 0)
		{
			
			$content = $content . "<table><tr><th>Symbol</th><th>Value</th><th>Change</th><th>Day Low</th><th>Day High</th><th>30 days</th><th>Today</th><th></th><th></th></tr>";
			$count = 0;
			while($row = mysql_fetch_assoc($ref))
			{
				$symbol = $row['symbol'];
				$sql = "SELECT * FROM stockval WHERE symbol = '$symbol'";
				$r = mysql_query($sql);
				$rw = mysql_fetch_assoc($r);
				$chng = "down";
				if($rw['chnge'] > 0)
				{
					$chng = "up";
				}
				else 	
					$chng = "down";
				$content = $content . "<tr id = \"" . $rw['symbol'] . "\"><td>" .$rw['symbol'] . "</td><td>" . $rw['value'] . "</td><td class = \"$chng\">" . $rw['chnge'] . "</td><td>" . $rw['day_low'] . "</td><td>" . $rw['day_high'] . "</td><td><img src = \"http://conjura.in/bullsndbears/images/monthly/" . $rw['symbol'] . "M.png\" /></td><td><img src = \"http://conjura.in/bullsndbears/images/day/" . $rw['symbol'] . ".png\" /></td><td><a class = \"buyAction\" href = \"index.php?o=buy&sym=" . urlencode($rw['symbol']) . "\">Buy</a></td><td><form  class = \"watchActionRemove\" method = \"post\" action = \"index.php\">" . '<input type = "hidden" name = "action" value = "remove"></input><input type = "hidden" name = "symbol" value = "' . $rw['symbol'] . '"></input><input type = "submit" value = "Remove Watch"></input></form></td></tr>';
			}
			$content .= "</table>";
		}
		else
		{
			$content .= "<strong>You haven't added any Watches Yet</strong>";
			$content .= "<br /><p style:\"font-size:10px\">Visit the Information Tab to know more</p><br />";
			$content .= "<h2>Event details</h2>

<ol>
<li>Weekly online event (Monday to Friday) for 4 consecutive weeks starting from Monday 30th Jan and ending on 24th Feb, 2012</li>
<li>BULLS & BEARS is a real time stock market platform linked to the National Stock Exchange (NSE) </li>
<li> Virtual money of Rs 1,00,000 will be credited to your portfolio and Net profit will be calculated every Friday to decide the weekly winner </li>
<li>Total Portfolio Value = ( Total Value of all Stocks in Portfolio + Balance amount in Portfolio) </li>
<li>The Total Portfolio Value on Friday will be the ONLY factor which will decide the Weekly winner. So maximize your profits. </li>
<li>Weekly Winners will be announced every Friday ( after 4 PM )</li>
<li>Overall winner will be announced on Feb 24th. </li>
<li>Total Portfolio Value after 4 Weeks of Trading will be the ONLY factor which will decide the Overall winner.</li>

</ol><br /><br />";
		}
		
	}
}			
			
			
