<?php include('includes/config.php'); 
/* Facebook Login Code ENDS HERE */

include_once("includes/facebook-config.php");
include_once("includes/facebook-functions.php");
//destroy facebook session if user clicks reset

/*echo $fbuser;*/
print_r($fbuser);
print_r($_SESSION);

die();

if(!$fbuser){
	$fbuser = null;
	$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
	//$output = '<a class="gtsociallogin gtfacebook" href="'.$loginUrl.'"><i class="fa fa-facebook"></i> Sign in with Facebook</a>'; 	
	header("location: ".$loginUrl);
	 
}else{

	$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
	$user = new Users();
	$user_data = $user->checkUser('facebook',$user_profile['id'],$user_profile['first_name'],$user_profile['last_name'],$user_profile['email'],$user_profile['gender'],$user_profile['locale'],$user_profile['picture']['data']['url']);
	if(!empty($user_data)){
		echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
}

?>