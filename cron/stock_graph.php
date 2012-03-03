<?php
	require_once("../core/bootstrap.php");
	$sql = "SELECT symbol FROM stockval";
	$ref = mysql_query($sql);
	echo "testing";
	while($row = mysql_fetch_assoc($ref))
	{
		$link = "http://nseindia.com/images/sparks/" . $row['symbol'] . ".png";
		$destination = "../images/day/" . $row['symbol'] . ".png";
		$image = file_get_contents_curl($link);
		echo "test";
		$image = imagecreatefromstring($image);
		imagepng($image,$destination);
	}

