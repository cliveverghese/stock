<?php 
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
function query_database($sql)
{
	$return = false;

	$i = 0;
	$error = null;
	while(!$return && $i != 5)
	{
		$return = mysql_query($sql);
		if(!$return)
		{
			$error= mysql_error();
			$error .= " " . $sql;
			error_log($error);
		}
		$i++;
	}
	
	return $return;
}

