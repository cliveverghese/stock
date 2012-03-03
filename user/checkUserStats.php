<?php

function check_facebook_status($id)
{
	$sql = "SELECT * FROM user_status WHERE id = '$id'";
	$ref = mysql_query($sql);
	
	$row = mysql_fetch_assoc($ref);

	if($row["facebook_like"] == 'F')
	{

		$_SESSION["Facebook_like"] = false;
	}
	else 
	{

		$_SESSION["Facebook_like"] = true;
	}
}

function check_facebook_like($id)
{

	$url = 'https://graph.facebook.com/me/likes?access_token=' .
    $_SESSION["facebook_access_token"];
	$next = true;
	$found = false;
	while($next && !$found)
	{
		$user = json_decode(file_get_contents_curl($url));
		
		if(isset($user))
	{
		foreach ($user->{"data"} as $row)
		{
			if($row->{'id'} == '161355370548332')
			{
				$sql = "UPDATE user_status SET facebook_like = 'T' WHERE id = '$id'";
				$ref = query_database($sql);
				$found = true;
			}
			
			
		}
		if($found == false)
		{
			$error = $_SESSION['id'] . ":";
			$error .= $_SESSION["facebook_access_token"];
		
			$error = $error . "Not found";
			error_log($error);
		}
		$next = false;
		if(isset($user->{"paging"}->{"next"}))
		{
			$next = true;
			$url = $user->{"paging"}->{"next"};
			
		}
		
	}
	}
}	


check_facebook_status($_SESSION['id']);
if(!$_SESSION['Facebook_like'])
{
	check_facebook_like($_SESSION['id']);
	check_facebook_status($_SESSION['id']);
}
