<?php
//use this file to initilize table with default contents if any.. or to initilize something for jus one run

require_once("config.php");
	$result = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	$database = DB_NAME;
	@mysql_select_db($database) or die( "Unable to select database. Please see if the database exists");

function file_get_contents_curl($url) {
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);
	
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}

	$jsn = file_get_contents_curl("http://nseindia.com/live_market/dynaContent/live_watch/stock_watch/niftyStockWatch.json");
	$jsn_obj = json_decode($jsn);
	foreach($jsn_obj->{'data'} as $data)
	{
		$sql = "INSERT INTO stockval(symbol) VALUES ('" . $data->{'symbol'} . "')";
	 	$ref = mysql_query($sql);
	}
?>



