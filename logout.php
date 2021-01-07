<?php session_start();


	/*
	include_once("includes/google-config.php");
	unset($_SESSION['token']);
	unset($_SESSION['google_data']); //Google session data unset
	$gClient->revokeToken();

	include_once("includes/facebook-config.php");
	$facebook->destroySession();
	session_start();
	unset($_SESSION['userdata']);

	include_once("includes/facebook-config.php");
	$facebook->destroySession();
	session_start();
	unset($_SESSION['userdata']);*/


unset($_SESSION['userdata']);

session_destroy();

echo "<script>document.location.href='http://www.shapingsteps.com/'</script>";



?>