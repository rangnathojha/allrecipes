<?php include("includes/config.php"); ?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php"); 

$gt_msgerror= ""; 

if(isset($_POST["rwsformsubmit"]))

{
	// Form Validation Code
	$errors = array(); //Initialize error array 
	$id = $_SESSION['GTUserID'];
	$newpassword = md5($_POST["newpassword"]);
	if (empty($_POST['oldpassword']) ) {$errors[]="Old Password field can't be blank!";}
	else { if(tocheckoldpwdusers($_POST['oldpassword'],$id)!=1) { $errors[]='Old Password does not match with our database. Please try once again!'; } }
	
	if (empty($_POST['newpassword']) ) {$errors[]="New Password  field can't be blank!";}
	 else { if(strlen($_POST['newpassword']) < 6) { $errors[]='Minimum password length is 6 characters!'; } }	
	
	if (empty($_POST['cnewpassword']) ) {$errors[]="Confirm New Password field can't be blank!";}
	
	if($_POST['newpassword'] != $_POST['cnewpassword'] ) { $errors[]='New Password does not matches with Confirm New Password!'; }	
	
	if(empty($errors)) {
	
	 $update_query = "UPDATE `ss_users` SET `password` = '$newpassword' WHERE `user_id`=$id";
		$result = $db->query($update_query);
		
	$gt_msgerror='<div id="rws-formsuccess">Great! Your settings have been updated.</div>';
	
	}
	
	
}

?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">	

    <div class="row">    

    	<div class="col-sm-offset-4 col-sm-4">
<div class="rws-userformdesign">
        	<h1 style="margin-top:0;">Change Password</h1>
            
            <?php if(!empty($errors)) {
				echo '<div id="rws-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
					foreach ($errors as $msg) { //prints each error
					echo "<li>$msg</li>";
					} // end of foreach
					echo '</ul></div>'; }
					
					if($gt_msgerror !="") { echo $gt_msgerror; }								
			?>
            
            <form action="" method="post" enctype="multipart/form-data" name="gt-editprofileform" id="gt-editprofileform">
        	<div class="rws-fields"> 
                <input type="password" name="oldpassword" id="oldpassword" value="" placeholder="*Old Password" required />  
            </div>
            <div class="rws-fields">
                <input type="password" name="newpassword" id="newpassword" value="" placeholder="*New Password" required /> 
            </div>
            <div class="rws-fields"> 
                <input type="password" name="cnewpassword" id="cnewpassword" value="" placeholder="*Confirm New Password" required /> 
            </div>
            <div class="rws-fields">
                <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Save" class="rwsbutton width_100" />  
            </div>
			</form>
                    

        </div>

    </div>

    </div>        

</div>

<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 