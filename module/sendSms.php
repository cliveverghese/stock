<?php
function sendSms($mobile,$message)
{
	$mobile=$mobile;

	$message=$message;

	$username=urlencode("smstkm");
	$password=urlencode("conjuratkm");
	$senderid=urlencode("CNJURA");
	$message=urlencode($message);
	$domain="sms.bulksmscochin.com";
	$route="C";
	$method="POST";

	$parameters="uname=$username&pwd=$password&senderid=$senderid&to=$mobile&msg=$message&route=$route";

	$url="http://$domain/sendsms";

	$ch = curl_init($url);

	if($method=="POST")
	{
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
	}
	else
	{
		$get_url=$url."?".$parameters;

		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
	}

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
	curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
	$return_val = curl_exec($ch);

}	

