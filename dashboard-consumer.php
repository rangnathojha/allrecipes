<?php include("includes/config.php"); checkuserlogin(); 

$query_login="SELECT * FROM `ss_users` WHERE `user_id`='".$_SESSION['GTUserID']."' ";	
$result = $db->query($query_login);
$row = $result->row;

$_SESSION["gtpagedb"] = "C";

$pageuser = "Consumer";

?>

<!-- RWS Header Starts -->
<?php include("application/gtheader.php"); ?>
<!-- RWS Header Starts -->  
<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">
    <?php echo $pagedb; include("application/dashboard-consumer.php"); ?>
</div>
<!-- RWS Dashboard Starts -->
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 