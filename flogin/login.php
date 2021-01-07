<?php include_once("inc/facebook.php"); //include facebook SDK

$fb = new facebook(['app_id' => '{app-id}',   'app_secret' => '{app-secret}', 'default_graph_version' => 'v2.2']);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>