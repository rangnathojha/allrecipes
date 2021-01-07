<?php include('includes/config.php');
if($_GET["user"]!="")
{
	$_SESSION["GTDemoUserType"] = $_GET["user"];
}
else
{
	$_SESSION["GTDemoUserType"] = "C";
}

if($_GET["social"]=="facebook")
{
	echo "<script>document.location.href='".$baseurl."members-facebook-login.php'</script>";
}
elseif($_GET["social"]=="google")
{
	echo "<script>document.location.href='".$baseurl."members-google-login.php'</script>";
}
elseif($_GET["social"]=="twitter")
{
	echo "<script>document.location.href='".$baseurl."members-twitter-login.php'</script>";
}
else
{
	echo "<script>document.location.href='".$baseurl."'</script>";
}




?>