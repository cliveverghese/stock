<?php 
	require_once("config.php");
	$result = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	$database = DB_NAME;
	@mysql_select_db($database) or die( "Unable to select database. Please see if the database exists");
	
	$sql = "CREATE TABLE IF NOT EXISTS stockval (
			id INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
			time_stamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
			symbol VARCHAR(20), 
			value DECIMAL(15,2), 
			chnge DECIMAL(15,2), 
			day_low DECIMAL(15,2), 
			day_high DECIMAL(15,2), 
			week_low DECIMAL(15,2), 
			week_high DECIMAL(15,2), 
			change_perc DECIMAL(15,2))";
	$ref = mysql_query($sql);
?>

