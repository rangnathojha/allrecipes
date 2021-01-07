<?php
include_once("inc/facebook.php"); //include facebook SDK
######### Facebook API Configuration ##########
$appId = '1919115421643526'; //Facebook App ID
$appSecret = 'b0a4d7a87d04dd55d68c7d9417d47974'; // Facebook App Secret
$homeurl = 'http://www.shapingsteps.com/app/members-facebook-login.php';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret

));
$fbuser = $facebook->getUser();
?>