<?php include("includes/config.php"); checkuserlogin(); 

if($_SESSION['GTUserType']!="B") 
{ 
				
	$update_query = "UPDATE `ss_users` SET `user_type` = 'B' WHERE `user_id`=".$_SESSION['GTUserID'];
	$rsupdate = $db->query($update_query);
	
	if($_SESSION['GTUserType']=="C")	
	{
		$_SESSION["GtThanksMsg"] = '<div id="rws-formsuccess">Your profile has been upgraded to Frentor successfully. Your Profile is under review. You will receive an email once your profile has been activated for Frentor Area. <strong>Kindly Update your Frentor profile so that admin will check it</strong>.</div>';
		$_SESSION['GTUserType']='B';
						
		$_SESSION['GTFrentorEditP']=togetusereditprofile($_SESSION['GTUserID']);
		
		/* Email Verification Code */
		$subject = "ShapingSteps - Become a Frentor Request made by ".$_SESSION['GTUserFirstName']." [Account Validation Required]";
		$body = $emailheader.'
  <tr>
	<td style="padding:10px;margin:0;line-height:1px;font-size:1px;font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left">
	<span style="font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:18px;padding:0px;margin:0px;font-weight:300;line-height:100%;text-align:left">Dear Admin</span><br />
Please validate '.$_SESSION['GTUserFirstName'].' account so that he will be able to user Frentor Section.<br />

	</td>
  </tr>	  
  '.$emailfooter;
  
  sendmail($admin_toemail,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
  
  
  $subject = "$sitename - Become a Frentor Request Submitted Successfully";
				$body = $emailheader.'
  <tr>
    <td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">
      <tr>
        <td height="22" colspan="2" align="left" valign="middle">Dear '.$_SESSION['GTUserFirstName'].',<br>
<br>
Thank you for submitting become a frentor request. Please make sure your profile has been updated successfully. Then we will review your account and activate it for using frentor section.
<br>
<br>
</td>
        </tr>        
	   <tr>
        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>
        </tr>  
  '.$emailfooter;
		
			sendmail($_SESSION['GTUserEmail'],$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
						
		echo "<script>document.location.href='edit-profile-sp.php';</script>";
		
	}
	else
	{
		$_SESSION["GtThanksMsg"] = '<div id="rws-formsuccess">Your profile has been upgraded to Consumer successfully. You may browse our packages.</div>';
		$_SESSION['GTUserType']='B';
		
		echo "<script>document.location.href='dashboard-consumer.php';</script>";
	}
}
else
{
	echo "<script>document.location.href='dashboard-service-provider.php';</script>";
}
?>