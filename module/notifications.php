<?php 

if(isset($_SESSION['user']))
{
	if($_GET['o'] == "notifications")
	{
		$id = $_SESSION['id'];
		if(isset($_GET['user']))
		{
			$sql = "SELECT * FROM user_status WHERE id = '" . $_SESSION['id'] . "'";
			$row = mysql_fetch_assoc(mysql_query($sql));
			if($row['admin'] == 'T')
			{
				$id = $_GET['user'];
			}
			
		}
		

		$sql = "SELECT * FROM notifications WHERE id = '$id' ORDER BY time DESC";

		$ref = mysql_query($sql);
		$count = mysql_num_rows($ref);
		if($count == 0)
		{
			$content .= "No notifications";
		}
		else
		{
			
			$content .= '<table><tr><th>Messages</th></tr>';
			while($row = mysql_fetch_assoc($ref))
			{
				$notification = $row['notification'];
				preg_replace("/<br>/",". ",$notification);
				$content .= "<tr><td>$notification</td></tr>";
				
			}
			$content .= '</table>';
			$sql = "UPDATE notifications SET status = 'r' WHERE id = '$id'";
			$ref = mysql_query($sql);
		}
		
	}
}

