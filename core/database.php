<?php 
	require_once("config.php");
	$result = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	$database = DB_NAME;
	@mysql_select_db($database) or die( "Unable to select database. Please see if the database exists");
	
	$sql = "CREATE TABLE IF NOT EXISTS stockval (
			id INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
			time_stamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
			symbol VARCHAR(20) UNIQUE, 
			value DECIMAL(15,2), 
			chnge DECIMAL(15,2), 
			day_low DECIMAL(15,2), 
			day_high DECIMAL(15,2), 
			week_low DECIMAL(15,2), 
			week_high DECIMAL(15,2), 
			change_perc DECIMAL(15,2),
			sector VARCHAR(20))";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS user (
			id BIGINT NOT NULL UNIQUE,
			name VARCHAR(40),
			liq_cash DECIMAL(15,2) DEFAULT 25000,
			market_val DECIMAL(15,2),
			rank INT,
			college VARCHAR(200),
			email VARCHAR(200),
			day_worth DECIMAL(15,2),
			week_worth DECIMAL(15,2),
			mob VARCHAR(20))";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS stocks_bought(
			id BIGINT NOT NULL,
			rate DECIMAL(15,2),
			time TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
			symbol VARCHAR(20) NOT NULL,
			amount BIGINT NOT NULL)";
	
	$ref = mysql_query($sql);

	$sql = "CREATE TABLE IF NOT EXISTS feedback(
			id BIGINT NOT NULL,
			value VARCHAR(300),
			time TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP)";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS intraday(
			id BIGINT NOT NULL,
			symbol VARCHAR(20) NOT NULL,
			amount BIGINT NOT NULL,
			cost DECIMAL(15,2) NOT NULL,
			time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS watch(
			id BIGINT NOT NULL,
			symbol VARCHAR(20) NOT NULL)";
	$ref = mysql_query($sql);

	$sql = "CREATE TABLE IF NOT EXISTS lim(
			id BIGINT NOT NULL,
			symbol VARCHAR(20) NOT NULL,
			amount BIGINT NOT NULL,
			rate DECIMAL(15,2),
			operation VARCHAR(10) NOT NULL,
			amo BOOLEAN DEFAULT FALSE)";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS settings(
			value VARCHAR(20) NOT NULL UNIQUE,
			conf VARCHAR(20) NOT NULL)";

	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS notifications(
			id BIGINT NOT NULL,
			notification VARCHAR(300),
			status VARCHAR(5),
			time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
	$ref = mysql_query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS user_status(
			id BIGINT NOT null UNIQUE,
			facebook_like VARCHAR(2) DEFAULT 'F',
			admin VARCHAR(2) DEFAULT 'F',
			banned VARCHAR(2) DEFAULT 'F')";	
	$ref = mysql_query($sql);


function query_database($sql)
{
	$return = false;

	while($return == false)
	{
		$return = mysql_query($sql);
	}
	
	return $return;
}
