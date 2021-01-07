<?php include("includes/config.php"); checkuserlogin();
$_SESSION['GTThanksMSG'] = '<div id="rws-formfeedback">Sorry, we are unable to process your payment. Please try again.</div>';
?>

<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<!-- RWS Header Starts -->  
<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">
    <?php 
		if(isset($_SESSION['GTThanksMSG'])) { echo $_SESSION['GTThanksMSG']; unset($_SESSION['GTThanksMSG']); } else { echo "<script>document.location.href='http://www.shapingsteps.com/'</script>"; }
	?>
</div>
<!-- RWS Dashboard Starts -->
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 