<?php include("includes/config.php"); 
$gt_msgerror= "";

if(isset($_POST["rwsformsubmit"]))
{
	$_SESSION['myForm'] = $_POST;
		
	if (empty($_POST['rwsusername']) ) 	{	$errors[]="Username/Email ID field can't be blank!";		}
	else {
		if (!eregi('^[[:alnum:]][a-z0-9_\.\-]*@[a-z0-9\.\-]+\.[a-z]{2,4}$', stripslashes(trim($_POST['rwsusername'])))) {
		$errors[]='Please provide a valid email address!';
		} 
	}
	if (empty($_POST['rwspassword']) ) 	{	$errors[]="Password field can't be blank!";		}

	if(empty($errors)) 
	{
		$rwsusername	=	$db->escape($_POST['rwsusername']);
		$rwspassword	=	md5($_POST['rwspassword']);
		$rwsusertype	=	$_POST['rwsusertype'];
		
		
		$query_login="SELECT * FROM `ss_users` WHERE `email`='$rwsusername' AND `password`='$rwspassword' ";	
		
		
		$result = $db->query($query_login);
		
		
		$numrows=$result->num_rows;
		
		if($numrows>0)
		{
			$row = $result->row;
			if($row["validate"] == 0)
			{
				$firstname 	= $row["firstname"];
				$email 		= $row["email"];
				
				if(empty($firstname))
				{
					$firstname 	= "User";
				}
						
				$validateid = base64_encode("SS-".$row["id"]);		
				$activeurl = $baseurl."validate.php?vid=".str_replace('=','rEN',$validateid);
				
				
				$subject = "$sitename - Validate your Account";
				$body = $emailheader.'
  <tr>
    <td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">
      <tr>
        <td height="22" colspan="2" align="left" valign="middle">Dear '.$firstname.',<br>
<br>
Please click on the below link to Validate Your Account:<br>
<br>
<div style="text-align:center">
<a href="'.$activeurl.'" title="Click Here to Validate your email id" style="display:inline-block; background:#2f4f99; border:2px solid #55acee; text-decoration:none; border-radius:10px; padding:10px 25px; text-transform:uppercase; color:#FFF; font-size:16px; font-weight:600; margin:17px 0 0 0;" target="_blank">Validate Account »</a>
</div>
<br>
<br>
</td>
        </tr>        
	   <tr>
        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>
        </tr>  
  '.$emailfooter;
		
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
				$_SESSION['GTUserID']				=	$row["id"];				
				$_SESSION['GTUserFirstName']		=	$row["firstname"];
				$_SESSION['GTUserLastName']			=	$row["lastname"];
				$_SESSION['GTUserEmail']			=	$row["email"];
				$_SESSION['GTUserMobile']			=	$row["mobile"];
				$_SESSION['GTUserType']				=	$row["user_type"];			
				
				if($_POST["remember_me"]==1)
				{
					// generate cooked of username and password
					setcookie("RWSSSUsername", $_POST['rwsusername']);
					setcookie("RWSSSPassword", $_POST['rwspassword']);
					setcookie("RWSSSSelected", 1);
				}
				else
				{
					setcookie("RWSSSUsername", "");
					setcookie("RWSSSPassword", "");
					setcookie("RWSSSSelected", 0);
				}
				
				
				$_SESSION['GTUserCurrentLogin']		=	$gtcurrenttime;
				
				$query_update_logintime = "UPDATE `ss_users` SET `last_login` = $gtcurrenttime WHERE `id` =".$row["id"];
				
				
				$result_logintime = $db->query($query_update_logintime);
				
				unset($_SESSION['myForm']);
				if($_SESSION['GTUserType']=="SP")
				{
					echo "<script>document.location.href='".$baseurl."dashboard-service-provider.php'</script>";
				}
				else
				{
					echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
				}
				
			}
		}
		else
		{
			$gt_msgerror='<div id="rws-formfeedback">The email and password you entered do not match.</div>';
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
<?php $loginbg = 1; include("application/gtheader-beforelogin.php"); ?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
    <div class="row"> 

    <div class=" col-sm-offset-4 col-sm-4 rws-userformdesign">
        	<h1 style="margin-top:0; font-size:22px;">Member's Login</h1>
            <?php 	echo $gt_msgerror; 	
					
					if(isset($_SESSION["GTMsgtoUser"])) { echo $_SESSION["GTMsgtoUser"]; unset($_SESSION["GTMsgtoUser"]); } 
			?>
            <form action="" method="post" enctype="multipart/form-data" name="gtregisterforms" id="gtregisterforms">
        	<div class="rws-fields">    
                <input type="text" name="rwsusername" id="rwsusername" value="" placeholder="*Email ID" required />    
            </div>
            <div class="rws-fields">    
                <input type="password" name="rwspassword" id="rwspassword" value="" placeholder="*Password" required />    
            </div>
            <div class="rws-fields">    
                <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Login" class="rwsbutton width_100"/>    
            </div>
            </form>
            <div class="rws-fields" style="text-align:center;">
            or
            </div>
            
            <div class="rws-fields" style="text-align:center;">
            <a href="members-facebook-login.php" class="rwssocialbtn rwsfacebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="members-google-login.php" class="rwssocialbtn rwsgoogle"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
            </div>
    
            <div class="rws-fields">
                <div class="row">
                	<div class="col-sm-6"><a href="forget-password.php">Forgot Password?</a></div>
                    <div class="col-sm-6" style="text-align:right;"><a href="register-as-service-consumer.php">Register</a></div>
                </div>
            </div>
            
            <div class="rws-fields">
           	By logging in, you agree to our <a href="terms-of-service.php">Terms of Service</a> and <a href="privacy-policy.php">Privacy Policy</a>.</div>
        
        </div>
        
    	
        
       
    
    </div>        
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 