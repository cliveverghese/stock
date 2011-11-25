<?php 


	$sql = "SELECT id,name FROM user WHERE id = '1'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	
	$_SESSION['user'] = $row['name'];
	$_SESSION['id'] = $row['id'];
	echo $row['name'];

