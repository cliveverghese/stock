<?php 

if(isset($_SESSION['user']))
{

	$sql = "SELECT * FROM stockval";
	$ref = mysql_query($sql);

	$content = $content . "<table>";

	while($row = mysql_fetch_assoc($ref))
	{
		$content = $content . "<tr><td>" .$row['symbol'] . "</td><td>" . $row['value'] . "</td><td><a href = \"index.php?o=buy&sym=" . $row['symbol'] . "\">Buy</a></td></tr>";
	}
	$content = $content . "</table>";

}
