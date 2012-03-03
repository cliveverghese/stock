<?php 

if(isset($_SESSION['user']))
{
	if($_REQUEST['o'] == 'feedback')
	{
		if(isset($_POST['value']))
		{
			$id = $_SESSION['id'];
			$value = mysql_real_escape_string($_POST['value']);
			$sql = "INSERT INTO feedback(id,value) VALUES ('$id','$value')";
			$ref = mysql_query($sql);
			$sql = "SELECT * FROM user WHERE id = '$id'";
			$ref = mysql_query($sql);
			$row = mysql_fetch_assoc($ref);
			$name = $row['name'];
			mail("onlineevents@conjura.in","$name Says",$value,'From: no-reply@conjura.in' . "\r\n" .
    'Reply-To: onlineevents@conjura.in' . "\r\n" .
    'X-Mailer: PHP/' . phpversion());
			$value .= "\n$id";
			mail("me@cliveverghese.com","$name Says",$value,'From: no-reply@conjura.in' . "\r\n" .
    'Reply-To: onlineevents@conjura.in' . "\r\n" .
    'X-Mailer: PHP/' . phpversion());
			$content .= "Thank you for your feedback";
		} 	
		else
		{
			$content .= 'FeedBack<br />';
			$content .= '<form method = "post" action = "index.php"><textarea name = "value" rows = "4" col = "40"></textarea><br /><input type = "hidden" value = "feedback" name = "o"><input type = "submit" value = "Submit"></form><br /><br />Contact<br />Krishnaraj R : +91 9446260393<br />Clive : +91 9496820687';
		}
	}
}
