<?php
session_start(); //session start

require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '796531963031-hkogrufdaia61to9gsvh63s8i3a591l3.apps.googleusercontent.com'; // Put here your clicent ID
$client_secret = 'fYkobq5kevoBj8cEIhOeQs2s'; // Put here your client secret
$redirect_uri = 'http://jaketv.tv/jaketv/jaketv_website/'; // put here your redirect url where you need response

//database
$db_username = "root"; //Database Username
$db_password = "root"; //Database Password
$host_name = "jaketv.tv"; //Mysql Hostname
$db_name = 'jaketv'; //Database Name




//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
{
  $client->setAccessToken($_SESSION['access_token']);
} 
else 
{
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
echo '<div style="margin:20px">';
if (isset($authUrl))
{
	//show login url
	echo '<div align="center">';
	echo '<h3>Login With Google+</h3>';
	//echo '<div>Please click login button to connect to Google.</div>';
	echo '<a class="login" href="' . $authUrl . '">Please click on link to connect with Google+.</a>';
	echo '</div>';
	
} 
else 
{echo '2';exit;
	
	$user = $service->userinfo->get(); //get user info with one by one parameters
	
	$googleid = $user->id;				// Google Unique ID
	$googlename = $user->name;			// Google Your Name (In google plus)
	$googleemail = $user->email;		// Google Your Email ID
	//$googleuserlink = $user->link;		// Google User Account Link
	$googlepicture = $user->picture;	// Google Your Given Picture
	$googlegender = $user->gender;		// Google Your Gender
	
	@mysql_connect($host_name,$db_username,$db_password) or die ("Oops! Connection fail.");
	@mysql_select_db($db_name) or die ("Oops! No database found.");
	
	
	$qry_select_if_exist = @mysql_query("SELECT googleplusid FROM tbl_user WHERE email='".$googleemail."'");
	$number_of_row = @mysql_num_rows($qry_select_if_exist);
	
	if($number_of_row == 0) // If googleid not exist then insert
	{
		$qry_inser_userinfo = @mysql_query("INSERT INTO tbl_user (googleplusid,fname,email,picture) 
		VALUES ('".$googleid."','".$googlename."','".$googleemail."','".$googlepicture."')");
		$_SESSION['sessionid'] = $sessionid;
		
		// Now create new session from your table unique ID of this user, and redirect as you want any where
	}
	else // else update user information using google login
	{
		$qry_update_userinfo = @mysql_query("UPDATE `tbl_user` SET `fname`='".$googlename."',`email`='".$googleemail."',`picture`='".$googlepicture."' WHERE `googleplusid`='".$googleid."',");
		$_SESSION['sessionid'] = $sessionid;
		// Now create new session from your table unique ID of this user, and redirect as you want any where
	}
	
	
	echo '<img src="'.$googlepicture.'" style="float: right;margin-top: 33px;" />';			//show user picture
	echo 'Welcome '.$googlename.'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';		//Logout URL
	//print user details
	echo '<pre>';
	print_r($user); // extract this variable and get individual detail of your self
	echo '</pre>';
}
echo '</div>';


?>
