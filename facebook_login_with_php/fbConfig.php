<?php
session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '269910900121765'; //Facebook App ID
$appSecret = 'ec52227731602603f3495af97ee43703'; // Facebook App Secret
$homeurl = 'http://www.shapingsteps.com/app/facebook_login_with_php/';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>