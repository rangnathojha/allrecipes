<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php 
	$hideform=0;
	$gt_msgerror= "";
	$_GET["reset"] = str_replace('rEN','=',$_GET["reset"]);
	$reset = base64_decode($_GET["reset"]);
	$userid = str_replace('SS-','',$reset);

	$query_login="SELECT users_resetpasswordlinks_id as id, usertype FROM ss_users_resetpasswordlinks WHERE (DATEDIFF('$gtcurrenttime', add_date) < 2 ) AND userid = '$userid' ORDER BY add_date DESC LIMIT 0,1";	

	$result = $db->query($query_login);
	
	$numrows=$result->num_rows;
	$rowut = $result->row;	



if($numrows>0)
{
	
	$rwsusertype = 	$rowut["usertype"];

if(isset($_POST["password"]))
{

	$_SESSION['myForm'] = $_POST;

	if (empty($_POST['password']) ) {

	$errors[]="Password field can't be blank!";

	} else { if(strlen($_POST['password']) < 6) { $errors[]='The minimum characters for passwords to be set at 6!'; } }

	if(empty($_POST['cpassword']) ) {
	$errors[]="Confirm Password field can't be blank!";
	}

	if(trim($_POST['password'])!=trim($_POST['cpassword'])) {
		$errors[]='Confirm Password don\'t match!';
	}
	
	if(empty($errors)) 
	{

			$pass = md5($_POST["password"]);
		
			
			$query="UPDATE `ss_users` SET `password` = '$pass' WHERE `user_id`='$userid'";	
			//echo $query;

			$qpu = $db->query($query);

			$query = "DELETE FROM `ss_users_resetpasswordlinks` WHERE `userid` = '$userid' AND `usertype` = '$rwsusertype'";

			$qpu = $db->query($query);
			$rown = $qpu->row;
			$firstname = $rown["firstname"];
			$registeremail = $rown["email"];

		$subject = "$sitename - Password Reset";

		$body = $emailheader.'

		  <tr>

			<td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">

			  <tr>

				<td height="22" colspan="2" align="left" valign="middle">Hey,<br><br>
Your password has been successfully changed.<br><br>
Just in case, if you didn\'t change your password reset it again to keep your account protected. <br><br>
Use the link below, if the link isn\'t clickable copy and paste it in your browser and go head.<br><br>

<div style="text-align:center">
<a href="'.$baseurl.'forget-password.php" title="Click Here to Change Password" style="display:inline-block; background:#2f4f99; border:2px solid #55acee; text-decoration:none; border-radius:10px; padding:10px 25px; text-transform:uppercase; color:#FFF; font-size:16px; font-weight:600; margin:17px 0 0 0;" target="_blank">Change Password »</a>
</div>

<br><br>
Your current password is  '.$_POST["password"].'<br><br>

<strong>Shaping Steps Admin</strong>
<br />
<br />
		</td>
				</tr> 
			   <tr>
				<td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>
				</tr>  
		  '.$emailfooter;

		

		sendmail($registeremail,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);		
		$gt_msgerror = '<div id="rws-formsuccess">Dear User, <br/><br/>Your password has been changed successfully! <a href="'.$baseurl.'login.php"><strong>Click Here</strong></a> to login into ShapingSteps Account.</div>';
		$hideform =1;
		
	}
	else
	{
		if(!empty($errors)) {
		$gt_msgerror = '<div id="rws-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
		foreach ($errors as $msg) { //prints each error
		$gt_msgerror .= "<li>$msg</li>";
		} // end of foreach
		$gt_msgerror .= '</ul></div>'; }
	}	

}
}

?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
    <div class="row">    
    	<div class="col-sm-offset-4 col-sm-4">
        <div class="rws-userformdesign">
        	<h1 style="margin-top:0;">Reset Password</h1>
            <?php echo $gt_msgerror; if(isset($_SESSION["GTMsgtoUser"])) { echo $_SESSION["GTMsgtoUser"]; unset($_SESSION["GTMsgtoUser"]); }?>
            <?php if($numrows>0) { if($hideform==0) { ?>
            <form action="" method="post" enctype="multipart/form-data" name="gtregisterforms" id="gtregisterforms">
        	<div class="rws-fields">    
                <input type="password" value="" id="password" class="form-control" name="password" placeholder="*New Password">    
            </div>
            <div class="rws-fields">    
                <input type="password" value="" id="cpassword" class="form-control" name="cpassword" placeholder="*Confirm New Password">  
            </div>
            <div class="rws-fields">    
                <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Submit" class="rwsbutton width_100" />    
            </div>  
            </form>          
        	<?php } } else { echo '<div id="rws-formfeedback">Sorry, We are unable to recognize you. Please try once again!</div>'; } ?>
        </div>
    </div>
    </div>        
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 