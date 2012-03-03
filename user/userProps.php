<?php
if(isset($_SESSION['user']))
{
	$UserBalance = null;
	$sql = "SELECT * FROM user WHERE id = '" . $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	$UserBalance = $row['liq_cash'];
}
