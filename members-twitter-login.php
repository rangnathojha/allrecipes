<?php include_once("includes/config.php");
include_once("includes/twitter-config.php");
include_once("includes/twitterinc/twitteroauth.php");
include_once("includes/twitter-functions.php");

if(!isset($_SESSION["GTDemoUserType"]))
{
	$_SESSION["GTDemoUserType"]="C";	
}

if(isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {

	//If token is old, distroy session and redirect user to index.php
	session_destroy();
	header('Location: index.php');
	
}elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {

	//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($connection->http_code == '200')
	{
		//Redirect user to twitter
		$_SESSION['status'] = 'verified';
		$_SESSION['request_vars'] = $access_token;
		
		//Insert user into the database
		$params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
		$user_info = $connection->get('account/verify_credentials', $params); 
		$name = explode(" ",$user_info->name);
		$fname = isset($name[0])?$name[0]:'';
		$lname = isset($name[1])?$name[1]:'';
		
		$db_user = new Users();
		$db_user->checkUser('twitter',$user_info->id,$user_info->screen_name,$fname,$lname,$user_info->email,$user_info->lang,$access_token['oauth_token'],$access_token['oauth_token_secret'],$user_info->profile_image_url);
		
		//Unset no longer needed request tokens
		unset($_SESSION['token']);
		unset($_SESSION['token_secret']);
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
	}else{
		die("error, try again later!");
	}
		
}else{

	if(isset($_GET["denied"]))
	{
		header('Location: index.php');
		die();
	}

	//Fresh authentication
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
	
	//Received token info from twitter
	$_SESSION['token'] 			= $request_token['oauth_token'];
	$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
	
	//Any value other than 200 is failure, so continue only if http code is 200
	if($connection->http_code == '200')
	{
		//redirect user to twitter
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
		header('Location: ' . $twitter_url); 
	}else{
		die("error connecting to twitter! try again later!");
	}
}
?>

