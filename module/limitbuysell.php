<?php
if(isset($_SESSION['user']) )
{
	if($_REQUEST['t'] == 'limit')
	{
		$symbol = null;
		$form = true;
		$rate = null;
		$amount = null;
		$sql = "SELECT * FROM settings WHERE value = 'market'";
		$ref = query_database($sql);
		$row = mysql_fetch_assoc($ref);

		$status = $row['conf'];

		if($_POST['o'] == "intrasell")
		{
			$_POST['amount'] = 0;
		}
		if(isset($_POST['sym']) && (isset($_POST['amount']) || isset($_POST['stop'])))
		{
			$symbol = mysql_real_escape_string(urldecode($_POST['sym']));
			$amount = mysql_real_escape_string($_POST['amount']);
			$operation = mysql_real_escape_string($_POST['o']);
			
			if($status != 'closed')
			{
			
				if(isset($_POST['stop']))
				{
					$rate = mysql_real_escape_string($_POST['stop']);
					$id = $_SESSION['id'];
				
					$operationloss = "s" . $operation; 
				
					$sql = "SELECT * FROM lim WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operationloss' AND amo = '0'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
				
					if($rate == null)
					{
						
					}
					else if($count != 0)
					{
						$sql = "UPDATE lim SET amount = '$amount', rate = '$rate' WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operationloss' AND amo = '0'";
					
					
						$ref = query_database($sql);
						$content .= "Updated";
					}
					else if($count == 0)
					{
						$sql = "INSERT INTO lim(id,symbol,amount,rate,operation) VALUES ('$id','$symbol','$amount','$rate','$operationloss')";
					
						$ref = query_database($sql);
						$content .= "Added";				
					}
				}

				
				if(isset($_POST['rate']))
				{
					$rate = mysql_real_escape_string($_POST['rate']);
					$id = $_SESSION['id'];
					$sql = "SELECT * FROM lim WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operation' AND amo = '0'";
					$ref = query_database($sql);
					$count = mysql_num_rows($ref);
					if($rate == null)
					{
						
					}
					else if($count != 0)
					{
						$sql = "UPDATE lim SET amount = '$amount', rate = '$rate' WHERE id = '$id' AND symbol = '$symbol' AND operation = '$operation' AND amo = '0'";
						
						$ref = query_database($sql);
						$content .= "Updated";
					}
					else if($count == 0)
					{
						$sql = "INSERT INTO lim(id,symbol,amount,rate,operation) VALUES ('$id','$symbol','$amount','$rate','$operation')";
						$ref = query_database($sql);
						$content .= "Added";					
					}
				}
			}	
			else
			{
				$content .= "Market is closed.. Please place an AMO";	
			}	
		}
		else 
		{
			$content .= 'Incomplete Information';
		}
	}
}

			

					
