<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";

if(isset($_POST["rwsusername"]))

{

	$_SESSION['myForm'] = $_POST;

	if (empty($_POST['rwsusername']) ) {$errors[]='Email ID field can\'t be blank!';}else {

	if (!eregi ('^[[:alnum:]][a-z0-9_\.\-]*@[a-z0-9\.\-]+\.[a-z]{2,4}$', stripslashes(trim($_POST['rwsusername'])))) {

	$errors[]='Please provide a valid email address!';

	} // if eregi

	// if empty email

	}

	

	if(empty($errors)) 

	{	
		$emailid = $_POST['rwsusername'];

		$query="SELECT * FROM `ss_users` WHERE `email`='$emailid' ";	
			
		
		$result = $db->query($query);

		$numrows=$result->num_rows;

		if($numrows>0)

		{

			$row = $result->row;

			if($row["validate"] == 0)
			{
				$firstname 	= $row["firstname"];
				$email 		= $row["email"];						

				$validateid = base64_encode("SS-".$row["user_id"]);					
				
				$activeurl = $baseurl."validate.php?vid=".str_replace('=','rEN',$validateid);

				$subject = "$sitename - Validate your Account";

				$body =  $emailheader.'
  <tr>

    <td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">

      <tr>

        <td height="22" colspan="2" align="left" valign="middle">Hello User,<br><br>
Change your password using the link below.<br>

<br>

<div style="text-align:center">
<a href="'.$activeurl.'" title="Click Here to Validate your email id" style="display:inline-block; background:#2f4f99; border:2px solid #55acee; text-decoration:none; border-radius:10px; padding:10px 25px; text-transform:uppercase; color:#FFF; font-size:16px; font-weight:600; margin:17px 0 0 0;" target="_blank">Validate Account »</a>
</div>

<br>

<br>
This link would stay valid for 48 hours from now.<br />
<br />
<strong>Shaping Steps Admin</strong>
<br />
<br />

</td>

        </tr>        

	   <tr>

        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>

        </tr>'.$emailfooter;

			sendmail($email,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);

			$gt_msgerror='<div id="rws-formfeedback"><p>Please complete your email verification using the mailed link, or <strong><a href="'.$baseurl.'resend-validation-link.php">click here</a></strong> to resend a verifaction link on your registered mail.</p>
<p>If you do not find the mail in your Inbox, please check your Spam or Junk folder.</p></div>';

			}

			elseif($row["status"] == 0)

			{

				$gt_msgerror='<div id="rws-formfeedback">Sorry! Your Account has been temporarily suspend Please call us immediately on '.$admin_support_mobile.'.</div>';

				

			}

			else

			{	

			$firstname 	= $row["firstname"];

			$email 		= $row["email"];

			$userid 	= $row["user_id"];

			$regid 		= base64_encode("SS-".$row["user_id"]);

			$query = $db->query("INSERT INTO `ss_users_resetpasswordlinks` (`users_resetpasswordlinks_id`, `userid`, `usertype`, `add_date`) VALUES (NULL, '$userid', '$rwsusertype', '$gtcurrenttime')");

			$urlreset = $baseurl.'reset-password.php?reset='.str_replace('=','rEN',$regid);				

			$subject = "$sitename - Reset Your Password";
				
		$body = $emailheader.'<tr>

    <td align="left" valign="middle"><table width="633" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td height="22" colspan="2" align="left" valign="middle">Dear '.$firstname.',<br>

<br>

Please click on the below link to reset your password:<br>

<br>

<div style="text-align:center">
<a href="'.$urlreset.'" title="Click Here to Join" style="display:inline-block; background:#2f4f99; border:2px solid #55acee; text-decoration:none; border-radius:10px; padding:10px 25px; text-transform:uppercase; color:#FFF; font-size:16px; font-weight:600; margin:17px 0 0 0;" target="_blank">Reset Password »</a>
</div>

<br>

<br>

<strong style="color:#FF0000;">This link will be valid upto <em>48 hours</em> from now.</strong><br />

<br />

</td>

        </tr>        

	   <tr>

        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>

        </tr>  

  '.$emailfooter;

		

		sendmail($emailid,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);

		$gt_msgerror = '<div id="rws-formsuccess">Check out your mail for a passsword reset link. If you do not find the mail in your inbox, check your Spam or Junk folder.</div>';

				

				

			}

	}
	else
	{
		$gt_msgerror='<div id="rws-formfeedback">Sorry! your email id doesn\'t exist in our database. Please call us immediately on '.$admin_support_mobile.'.</div>';
	}
	
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

?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
    <div class="row">    
    	<div class="col-sm-offset-4 col-sm-4">
        <div class="rws-userformdesign">
        	<h1 style="margin-top:0;">Forgot Password?</h1>
            <?php echo $gt_msgerror; if(isset($_SESSION["GTMsgtoUser"])) { echo $_SESSION["GTMsgtoUser"]; unset($_SESSION["GTMsgtoUser"]); }?>
            <form action="" method="post" enctype="multipart/form-data" name="gtregisterforms" id="gtregisterforms">
        	<div class="rws-fields">    
                <input type="text" name="rwsusername" id="rwsusername" value="" placeholder="*Email ID" required />    
            </div>            
            <div class="rws-fields">    
                <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Submit" class="rwsbutton width_100" />    
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