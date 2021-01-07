<?php include('includes/config.php'); 
include('includes/google-config.php'); 
include('includes/google-functions.php'); 

/* Google Login Code Starts HERE */
//echo $_GET['code']; die();
if($_GET['code']!=""){
	$gClient->authenticate();
	$_SESSION['token'] = $gClient->getAccessToken();
	//header('Location: ' . filter_var($redirect_url, FILTER_SANITIZE_URL));
	echo "<script>document.location.href='".$baseurl."members-google-login.php'</script>";
	echo $_GET['code'];
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	$userProfile = $google_oauthV2->userinfo->get();
	//DB Insert
	$gUser = new Users();
	$gUser->checkUser('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);
	$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
	
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
	$_SESSION['token'] = $gClient->getAccessToken();
} else {
	$authUrl = $gClient->createAuthUrl();
	header("Location: ".$authUrl);
}

/* Google Login Code ENDS HERE */
?>