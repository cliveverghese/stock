<?php
	require_once("../core/bootstrap.php");
	$sql = "SELECT * FROM user";
	$ref = mysql_query($sql);
	while($row = mysql_fetch_assoc($ref))
	{
		$sql = "UPDATE user SET week_worth = '{$row['liq_cash']}' WHERE id = '{$row['id']}'";
		$re = mysql_query($sql);
		if($re)
		{
			echo "updated {$row['id']} {$row['name']}";	
		}
		else 
		{
			echo "failed {$row['id']} {$row['name']}";
		}
	}
