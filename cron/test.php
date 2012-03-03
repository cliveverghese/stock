<?php
$jsn = file_get_contents("http://nseindia.com/homepage/Indices1.json");
if(preg_match("/status:\"MARKET CLOSED\"/i",$jsn))
{
	echo "Closed";
}
else 
	echo "open";



