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
    <div class="row">
	<?php include("application/left-sidebar.php"); ?>
    
    <div class="col-sm-9" id="rws-rightcolumn">
    <?php if(isset($_SESSION["GtThanksMsg"])) { echo $_SESSION["GtThanksMsg"]; unset($_SESSION["GtThanksMsg"]); } ?>
    	<div class="rws-module">
        	<h3>Become a Frentor</h3>
            <div class="mcontent">
                <p>Do you want to become a consumer?</p>
                <p><a href="user-change-type.php" class="rwsbutton ">Become A Consumer</a></p>   
            </div>
        </div>
        <!-- Mentoring Ends -->
    </div>
</div>
</div>
<!-- RWS Dashboard Starts -->
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 