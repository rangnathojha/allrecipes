<?php include_once("src/Google_Client.php");
include_once("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '915561579900-mpsqt7hhf9fridu4qp4j9tbk8c19qsec.apps.googleusercontent.com'; //Google CLIENT ID
$clientSecret = 'qdkXxBwAP5dWUicXcvdM4Lg1'; //Google CLIENT SECRET
$redirectUrl = 'https://www.shapingsteps.com/app/members-google-login.php';  //return url (url to script)
$homeUrl = 'https://www.shapingsteps.com/app/members-google-login.php';  //return to home

##################################

$gClient = new Google_Client();
$gClient->setApplicationName('SPARA');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>