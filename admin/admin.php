<?php
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM user_status WHERE id = '$id'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	if($row['admin'] == 'T')
	{
		$content .= "<h2>Admin</h2>";
		$sql = "SELECT * FROM user";
		$content .= "<table><tr><th></th><th>Name</th><th>Balance</th><th>College</th></tr>";
		$ref = mysql_query($sql);
		$i = 1;
		while($row = mysql_fetch_assoc($ref))
		{
			$name = $row['name'];
			$balance = $row['liq_cash'];
			$college = $row['college'];
			$id = $row['id'];
			$content .= "<tr><td>$i</td><td>$name</td><td>$balance</td><td>$college</td><td><a href = \"index.php?o=portfolio&user=$id\">Portfolio</a></td></tr>";
			$i++;
			
		}
		$content .= "</table>";
	}
	else 
	{
		$content .= "You don't enuf permissions to View this page";
	}

