<?php 

function get_auth_tokn_code()
{

	$app_id = FB_APP_ID; 
	$app_secret = FB_APP_SECRET;
	$my_url = "http://conjura.in/bullsndbears/";
        
   	$code = $_REQUEST["code"];

   	if($_REQUEST['state'] == $_SESSION['state']) {
   	  $token_url = "https://graph.facebook.com/oauth/access_token?"
   	    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
   	    . "&client_secret=" . $app_secret . "&code=" . $code;

    	 $response = file_get_contents_curl($token_url);
	 //echo $response;
	error_log($response);
    	 $params = null;
    	 parse_str($response, $params);
	error_log($params['access_token']);
	 //echo "<br />" . $params['access_token'];
    	 return $params['access_token'];
	
    	}
   }




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
    if ($_COOKIE['fbsr_' . $app_id] != '') {
        return get_new_facebook_cookie($app_id, $app_secret);
    } else {
        return get_old_facebook_cookie($app_id, $app_secret);
    }
}

function get_old_facebook_cookie($app_id, $app_secret) {
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
        return array();
    }
    return $args;   
}

function get_new_facebook_cookie($app_id, $app_secret) {
    $signed_request = parse_signed_request($_COOKIE['fbsr_' . $app_id], $app_secret);
    // $signed_request should now have most of the old elements
    $signed_request["uid"] = $signed_request["user_id"]; // for compatibility 
    if (!is_null($signed_request)) {
        // the cookie is valid/signed correctly
        // lets change "code" into an "access_token"
        $access_token_response = file_get_contents_curl("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code={$signed_request['code']}");
        parse_str($access_token_response);
        $signed_request["access_token"] = $access_token;
        $signed_request["expires"] = time() + $expires;
    }
    return $signed_request;
}



$auth_tkn = null;
$cookie = null;
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
	//echo '<script type = "text/javascript" src = "theme/js/fb.js"></script>';
}

$cookie = get_facebook_cookie(FB_APP_ID, FB_APP_SECRET);
$auth_tkn = $cookie['access_token'];
}
if(isset($_REQUEST['code']) && $auth_tkn == null)
{
	$auth_tkn = get_auth_tokn_code();
}

$user = null;
$user = json_decode(file_get_contents_curl(
    'https://graph.facebook.com/me?access_token=' .
    $auth_tkn));
$_SESSION['facebook_access_token'] = $auth_tkn;
$College = null;
if(isset($user->{id}))
{
if(isset($user->{'education'}))
{
foreach($user->{'education'} as $education)
	{

		if(strcmp($education->{'type'},"College") == 0)
		{
			$College = $education->{'school'}->{'name'};
			break;		
		}
	}
}

$sql = "SELECT * FROM user WHERE id = \"" . $user->{'id'} . "\"";
	//echo $sql;
	$ref = mysql_query($sql);
	$result = mysql_num_rows($ref);
	if($result == 0)
	{	
		if(!isset($user->{'email'}))
		{
			$email = null;
		}
		else 
			$email = $user->{'email'};
		
		
		$sql = "INSERT INTO user(id,name,email,college) VALUES ('" . $user->{'id'} . "','" . $user->{'name'} . "','" . $user->{'email'} . "','";
		$sql = $sql . $College;
		$sql = $sql . "')";
		
		
		
		error_log($sql);		
		$ref = mysql_query($sql);

		$sql = "INSERT INTO user_status(id) VALUES('" . $user->{'id'} . "')";
		$ref = mysql_query($sql);
		
		$url = "https://graph.facebook.com/" . $user->{'id'} . "/feed";
		$name = urlencode("Bulls & Bears");
		$body = "access_token=" . $_SESSION['facebook_access_token'] . "&message=has Registered For Bulls And Bears&picture=http://www.conjura.in/bullsndbears/theme/images/fbpost.jpg&link=http://conjura.in/bullsndbears&name=$name&caption=Powered by Geojit BNP PARIBAS | Conjura'12&description=Brush up your Stock-o-Logical Skills to tame the bull and take a ride on it... Quest for the Ultimate Stock Market Hero.. Prizes worth 20,000 To be won.. Start Playing Now...!";
		
		$c = curl_init ($url);
		curl_setopt ($c, CURLOPT_POST, true);
		curl_setopt ($c, CURLOPT_POSTFIELDS, $body);
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec ($c);
		

	}
	else 
	{
		//$sql = 'SELECT level,role FROM user WHERE id = "' . $user->{'id'} . '"';
		//$ref = mysql_query($sql);
		//$row = mysql_fetch_assoc($ref);

	}
$sql = "SELECT * FROM user WHERE id = \"" . $user->{'id'} . "\"";
$ref = mysql_query($sql);
$row = mysql_fetch_assoc($ref);
$_SESSION['user'] = $user->{'name'};
$_SESSION['id'] = $user->{'id'};
if($row['email'] == null || $row['mob'] == null || $row['college'] == null)
{

		$_SESSION['completed'] = false;
}
else 
{
	require_once("checkUserStats.php");
	if($_SESSION['Facebook_like'])	
		$_SESSION['completed'] = true;
	else 
		$_SESSION['completed'] = false;
	
}





}
		

		//echo '<script type = "text/javascript" src = "theme/js/fb.js"></script>
			//<div id = \"user\">loading</div>';
		
