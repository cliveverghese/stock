<?php 
function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}



function get_facebook_cookie($app_id, $app_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $app_secret) != $args['sig']) {
    return null;
  }
  return $args;
}
$auth_tkn = null;
if(isset($_REQUEST["signed_request"]))
{
     $canvas_page = "http://apps.facebook.com/conjura_bullsndbears/";

     $auth_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . FB_APP_ID . "&redirect_uri=" . urlencode($canvas_page) ."&scope=email";

     $signed_request = $_REQUEST["signed_request"];

     list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

     $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

     if (empty($data["user_id"])) {
            echo("<script> top.location.href='" . $auth_url . "'</script>");
     } else {
            $data = parse_signed_request($signed_request, FB_APP_SECRET);
	    $auth_tkn = $data['oauth_token'];
    } 

}
else{
if($cookie == null)
{
	echo '<script type = "text/javascript" src = "js/fb.js"></script>';
}

$cookie = get_facebook_cookie(FB_APP_ID, FB_APP_SECRET);
$auth_tkn = $cookie['access_token'];
}

$user = null;
$user = json_decode(file_get_contents_curl(
    'https://graph.facebook.com/me?access_token=' .
    $auth_tkn));

$College = null;
if(isset($user))
{
foreach($user->{'education'} as $education)
	{

		if(strcmp($education->{'type'},"College") == 0)
		{
			$College = $education->{'school'}->{'name'};
			break;		
		}
	}


$sql = "SELECT * FROM user WHERE id = \"" . $user->{'id'} . "\"";
	//echo $sql;
	$ref = mysql_query($sql);
	$result = mysql_num_rows($ref);
	if($result == 0)
	{	
		
		
		$sql = "INSERT INTO user(id,name,email,college) VALUES ('" . $user->{'id'} . "','" . $user->{'name'} . "','" . $user->{'email'} . "','";
		$sql = $sql . $College;
		$sql = $sql . "')";
		
		//echo $sql;		
		$ref = mysql_query($sql);

	}
	else
	{
		//$sql = 'SELECT level,role FROM user WHERE id = "' . $user->{'id'} . '"';
		//$ref = mysql_query($sql);
		//$row = mysql_fetch_assoc($ref);

	}



$_SESSION['user'] = $user->{'name'};
$_SESSION['id'] = $user->{'id'};



}
		

		//echo '<script type = "text/javascript" src = "theme/js/fb.js"></script>
			//<div id = \"user\">loading</div>';
		
