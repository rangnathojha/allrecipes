<?php include('includes/config.php');

require_once("includes/facebookinc/autoload.php"); //AutoLoad
require_once("includes/facebookinc/Facebook.php");
	
######### Facebook API Configuration ##########
$appId = '269910900121765'; //Facebook App ID
$appSecret = '48d2f80965d2dff38c0d5518a9af4b6c'; // Facebook App Secret
$homeurl = 'http://www.shapingsteps.com/app/members-facebook-callback.php';  //Return URL

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('269910900121765');
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,first_name,last_name,name,email,gender,locale,picture', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

$oauth_uid = $user["id"];
$first_name = $user["first_name"];
$last_name = $user["last_name"];
$email = $user["email"];
$gender = $user["gender"];
$locale = $user["locale"];
$oauth_provider = "facebook";
//$picture = $user["picture"];

if(isUnique("email", $email, "ss_users"))
{			
	/* Insert Code to Database */
	$query_insert = "INSERT INTO `ss_users` SET firstname = '$first_name', middlename = '$middlename', lastname = '$last_name', mobile = '$mobile', email = '$email', password = '$password', photograph = '$photograph', gender = '$gender', dateofbirth = '$dateofbirth', address = '$address', location = '$location', area = '$area', city = '$city', state = '$state', pincode = '$pincode', country = '$country', user_type = '".$_SESSION["GTDemoUserType"]."', oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', locale = '".$locale."', status = '1', validate = '1', add_date = '$gtcurrenttime'";
	
	$update_result = $db->query($query_insert);
	
	$userid = $db->getLastId();
	
	$_SESSION['GTUserID'] = $userid;
	$_SESSION['GTUserFirstName']=$first_name;
	$_SESSION['GTUserLastName']=$last_name;			
	$_SESSION['GTUserEmail']=$email;
	$_SESSION['GTUserMobile']="";
	$_SESSION['GTUserType']=$_SESSION["GTDemoUserType"];
	$_SESSION['GTUserProfilepic']=$picture;
	$_SESSION['GTUserProfileID']=$userid;
	$_SESSION['GTUserLoginFrom']=$oauth_provider;
	
}
else
{
	$select_query = 'SELECT * FROM `ss_users` WHERE email = "'.$email.'"';
	$select_result = $db->query($select_query);
	$row = $select_result->row;
	
	$userid = $row["id"];
	
	/* Insert Code to Database */
	if($row["user_type"]==$_SESSION["GTDemoUserType"])
	{
		$query_insert = "UPDATE `ss_users` SET firstname = '$first_name', middlename = '$middlename', lastname = '$last_name', user_type = '".$_SESSION["GTDemoUserType"]."', oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', locale = '".$locale."', status = '1', validate = '1' WHERE `user_id`='$userid'";
	}
	else
	{
		$query_insert = "UPDATE `ss_users` SET firstname = '$first_name', middlename = '$middlename', lastname = '$last_name', user_type = 'B', oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', locale = '".$locale."', status = '1', validate = '1' WHERE `user_id`='$userid'";
	}
	
	$update_result = $db->query($query_insert);
	
	
	$_SESSION['GTUserID'] = $row['user_id'];
	$_SESSION['GTUserFirstName']=$row["firstname"];
	$_SESSION['GTUserLastName']=$row["lastname"];			
	$_SESSION['GTUserEmail']=$row["email"];
	$_SESSION['GTUserMobile']=$row["mobile"];
	$_SESSION['GTUserType']=$row["user_type"];
	$_SESSION['GTUserProfilepic']=$row["photograph"];
	$_SESSION['GTUserProfileID']=$oauth_uid;
	$_SESSION['GTUserLoginFrom']=$oauth_provider;
}



if(empty($_SESSION["services_package_id"]))
{				
	if($_SESSION['GTUserType']=="SP")
	{
		echo "<script>document.location.href='".$baseurl."dashboard-service-provider.php'</script>";
	}
	else
	{
		echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	}
}
else
{
	echo "<script>document.location.href='".$baseurl."create-session-cart.php?services_package_id=".$_SESSION["services_package_id"]."'</script>";
}

?>