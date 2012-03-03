<?php
	require_once("../core/bootstrap.php");
	$sql = "SELECT symbol FROM stockval";
	$ref = mysql_query($sql);
	echo "testing";
	while($row = mysql_fetch_assoc($ref))
	{
		$link = "http://nseindia.com/images/sparks/monthly/" . $row['symbol'] . "M.png";
		$destination = "../images/monthly/" . $row['symbol'] . "M.png";
		$image = file_get_contents_curl($link);
		echo "test";
		$image = imagecreatefromstring($image);
		imagepng($image,$destination);
	}
	$sql = "DELETE FROM stocks_bought WHERE amount = '0'";
	$ref = mysql_query($sql);
