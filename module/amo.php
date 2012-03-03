<?php
if(isset($_SESSION['user']))
{
	if($_REQUEST['amo'] == 'amo')
	{
		
		$symbol = null;
		$form = true;
		$rate = null;
		$amount = null;
		if($_POST['o'] == "intrasell")
			$_POST['amount'] = 0;
		if(isset($_POST['sym']) && isset($_POST['amount']))
		{

			$symbol = mysql_real_escape_string(urldecode($_POST['sym']));
			$amount = mysql_real_escape_string($_POST['amount']);
			$operation = mysql_real_escape_string($_POST['o']);
			
			if(isset($_POST['rate']))
			{
				$rate = mysql_real_escape_string($_POST['rate']);
			}
			else
			{
				$rate = null;
			}
				$id = $_SESSION['id'];
				$sql = "SELECT * FROM lim WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operation' AND amo = '1'";

				$ref = query_database($sql);
				$count = mysql_num_rows($ref);

				if($count != 0)
				{
					$sql = "UPDATE lim SET amount = '$amount', rate = '$rate' WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operation' AND amo = '1'";
					
					$ref = query_database($sql);
					$content .= "Updated";
				}
				else if($count == 0)
				{
					$sql = "INSERT INTO lim(id,symbol,amount,rate,operation,amo) VALUES ('$id','$symbol','$amount','$rate','$operation','1')";

					$ref = query_database($sql);
					$content .= "Added";				
				}
				
			

		}
	}
}
