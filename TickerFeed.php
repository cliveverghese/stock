<?php
require_once("core/bootstrap.php");
$sql = "SELECT * FROM stockval limit 0,50";
$ref = mysql_query($sql);
echo "c|date|50|";

while($row = mysql_fetch_assoc($ref))
{
	echo $row['symbol'] . "," . $row['value'] . "," . $row['change_perc'] . "|";
} 
