<?php 

	require_once("sendSms.php");

	if(isset($_POST['mail']))
	{
		$email = mysql_real_escape_string($_POST['mail']);
		$sql = "UPDATE user SET email = '$email' WHERE id = '" . $_SESSION['id'] . "'";
		$ref = mysql_query($sql);
	}
	if(isset($_POST['mob']))
	{
		$email = mysql_real_escape_string($_POST['mob']);
		$sql = "UPDATE user SET mob = '$email' WHERE id = '" . $_SESSION['id'] . "'";
		$ref = mysql_query($sql);
		sendSms($email,"Now you officially become a part of CONJURA'12 with your successful registration for BULLS&BEARS Powered by GEOJIT BNP PARIBAS.So book your tickets right away.");
	}
	if(isset($_POST['college']))
	{
		$email = mysql_real_escape_string($_POST['college']);
		$sql = "UPDATE user SET college = '$email' WHERE id = '" . $_SESSION['id'] . "'";
		$ref = mysql_query($sql);
	}
	 
									
	require_once("user/checkUserStats.php");
	$sql = "SELECT * FROM user WHERE id = '". $_SESSION['id'] . "'";
	$ref = mysql_query($sql);
	$row = mysql_fetch_assoc($ref);
	error_log($sql);

	

	if($row['email'] == null || $row['mob'] == null || $row['college'] == null || !$_SESSION['Facebook_like'])
	{
		$content .= 'Please complete your profile to proceed<br /><form action = "index.php" method = "post">';
		if($row['email'] == null)
		{
			$content .= '<br>Email : <input type = "text" name = "mail"></input>';
		}
		if($row['mob'] == null)
		{
			$content .= '<br>Mobile : +91 <input type = "text" name = "mob"></input>';
			
		}
		if($row['college'] == null)
		{
			$content .= '<br>College : <input type = "text" name = "college"></input>';
		}
		
		if(!$_SESSION['Facebook_like'])
		{
			$content .= '<br />Please like the facebook page (Geojit BNP Paribas) to complete your registration<br /><div id = "LikeButton">';
			$content .= '<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FGeojitBNPParibas&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=196982610389509" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:35px;" allowTransparency="true"></iframe>';
			$content .= '</div>';
			
		}
		
		$content .= '<br><input type = "submit" value = "Update"></input">';
	}
	else
	{
		$_SESSION['completed'] = true;
		$content .= 'Thank You for completing your profile... ';
	}
			
	

?>	
