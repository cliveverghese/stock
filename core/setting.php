<?php 
	require_once("config.php");
	$result = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	$database = DB_NAME;
	@mysql_select_db($database) or die( "Unable to select database. Please see if the database exists");
	
	$sql = "INSERT INTO settings VALUES ('market','closed')";
	$ref = mysql_query($sql);
	
