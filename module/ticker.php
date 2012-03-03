<?php
session_start();
if(isset($_SESSION['id']))
{
	require_once("../core/bootstrap.php");
	$sql = "SELECT * FROM stockval ORDER BY change_perc LIMIT 0,15";
	echo "<ul>";
	$ref = mysql_query($sql);
	while($row = mysql_fetch_assoc($ref))
	{
		$symbol = $row['symbol'];
		$value = $row['value'];
		$change = $row['change_perc'];
		echo "<li><span class = \"tkrSym\">$symbol</span><span class = \"tkrvalue";
		if($change < 0)
			echo "down";
		else
			echo "up";
		echo "\">$value</span><span class = \"tkrchange";
		if($change < 0)
			echo "down";
		else
			echo "up";
		echo "\">$change</span></li>";
	}
	echo "</ul>";
}
