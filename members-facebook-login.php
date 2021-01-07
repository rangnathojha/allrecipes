<?php include('includes/config.php');

if(!isset($_SESSION["GTDemoUserType"]))
{
	$_SESSION["GTDemoUserType"]="C";	
}

require_once("includes/facebookinc/autoload.php"); //AutoLoad
require_once("includes/facebookinc/Facebook.php");

######### Facebook API Configuration ##########
$appId = '269910900121765'; //Facebook App ID
$appSecret = '48d2f80965d2dff38c0d5518a9af4b6c'; // Facebook App Secret
$homeurl = 'https://www.shapingsteps.com/app/members-facebook-callback.php';  //Return URL

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($homeurl, $permissions);

header("location: ".$loginUrl);


?>