<?php 
	if(isset($_SESSION['user']))
	{
		$sql = "SELECT * FROM user_status WHERE id = " . $_SESSION['id'];
	
		$ref = mysql_query($sql);
		$row = mysql_fetch_assoc($ref);

		
			
		if($row['facebook_post'] == 'F')
		{
		$sql = "SELECT * FROM user WHERE id = " . $_SESSION['id'];
		$ref = mysql_query($sql);
		$row = mysql_fetch_assoc($ref);
		$bal = $row['liq_cash'];
		$prev_day = $row['day_worth'];
	
		
		
		$url = "https://graph.facebook.com/" . $_SESSION['id'] . "/feed";
		
		$des = urlencode("Portfolio worth = $prev_day.");
		$name = urlencode("Bulls & Bears");
		$msg = urlencode("is playing bulls & bears | conjura'12");
		$body = "access_token=" . $_SESSION['facebook_access_token'] . "&message=$msg&picture=http://www.conjura.in/bullsndbears/theme/images/fbpost.jpg&link=http://conjura.in/bullsndbears&name=$name&caption=Powered by Geojit BNP PARIBAS | Conjura'12&description=$des";
		
		
		$c = curl_init ($url);
		curl_setopt ($c, CURLOPT_POST, true);
		curl_setopt ($c, CURLOPT_POSTFIELDS, $body);
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec ($c);
		$balance = $row['liq_cash'];
		
		$sql = "UPDATE user_status SET facebook_post = 'T' WHERE id = '{$_SESSION['id']}'";
		
		$ref = mysql_query($sql);
		}
	}

			
		
	
