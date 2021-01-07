<?php include("includes/config.php"); 
$_SESSION['myForm']=array();
$gt_msgerror= ""; 
if(isset($_POST["rwsformsubmit"]))
{
	$_SESSION['myForm'] = $_POST;
	
	if(empty($_POST['rwsusername']) ) {$errors[]='Email ID field can\'t be blank!';}
		
	if (empty($_POST['rwspassword']) ) 	{	$errors[]="Password field can't be blank!";		}
	else { 

		if(strlen($_POST['rwspassword']) < 6) { $errors[]='The minimum characters for passwords to be set at 6!'; } 
		
		/*if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,20}$/',$_POST['rwsupass'])) {
			$errors[]="Password field contain at least one lowercase char, at least one uppercase char, at least one digit, at least one special sign of @#-_$%^&+=!?";
		}*/
	
	}
	
	if(empty($errors)) 
	{
		if(isUnique("email", $_POST['rwsusername'], "ss_users"))
		{
			$email 				= $_POST["rwsusername"];
			$password 			= md5($_POST["rwspassword"]);
			$sendpass 			= $_POST["rwspassword"];
					
			/* Insert Code to Database */
			$query_insert = "INSERT INTO `ss_users` SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', mobile = '$mobile', email = '$email', password = '$password', photograph = '$photograph', gender = '$gender', dateofbirth = '$dateofbirth', address = '$address', location = '$location', area = '$area', city = '$city', state = '$state', pincode = '$pincode', country = '$country', user_type = 'C', status = '1', validate = '0', add_date = '$gtcurrenttime'";
			
			$update_result = $db->query($query_insert);
			
			$userid = $db->getLastId();
			
			$query_insert = "INSERT INTO `ss_service_provider` SET user_id = '$userid'";			
			$update_result = $db->query($query_insert);
			
			$validateid = base64_encode("SS-".$userid);
			
			$activeurl = $baseurl."validate.php?vid=".str_replace('=','rEN',$validateid);
					
			/* Email Verification Code */
			$subject = "Hello $email, Your Account has been created successfully. [Account Validation Required]";
			$body = $emailheader.'
	  <tr>
		<td style="padding:10px;margin:0;line-height:1px;font-size:1px;font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left">
		<span style="font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:18px;padding:0px;margin:0px;font-weight:300;line-height:100%;text-align:left">Final step...</span><br />
	Confirm your email address to validate your '.$sitename.' account. It\'s simple — just click the link below. 
		</td>
	  </tr>
	  <tr>
		<td style="padding-bottom:20px; text-align:center;"><a href="'.$activeurl.'" title="Click Here to Validate your Account"><strong>CLICK HERE</strong></a><br />
	<br />
	OR Copy paste the below link to your browser:<br />
	<br />
	'.$activeurl.'
	</td>
	  </tr>
	  '.$emailfooter;
	
	
			
			sendmail($email,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
			
			$_SESSION["GTMsgtoUser"] = '<div id="rws-formsuccess">Dear User, you have successfully register with us. We have sent a verification mail. Please validate your account before you get login.<br><br>Check your mail. All please check in <br><strong style="font-size:18px;">Spam or Junk</strong> folder too.</div>';
			
			unset($_SESSION['myForm']);
			
			echo "<script>document.location.href='".$baseurl."register-as-service-consumer.php'</script>";
			exit;
			
		}
		else
		{
			
			$gt_msgerror ='<div id="rws-formfeedback">Email ID already exists to our database. Please use another email id for registration. </div>';
			
			$json['proceed'] = '0';			 
			$json['info'] = $gt_msgerror;
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

<?php $loginbg = 1;  include("application/gtheader.php"); ?>

<!-- RWS Header Starts -->        



<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">	

    <div class="row">    

    	<div class="col-sm-offset-4 col-sm-4">
		<div class="rws-userformdesign">
        	<h1 style="margin-top:0;">Register as Consumer</h1>
            <?php echo $gt_msgerror; if(isset($_SESSION["GTMsgtoUser"])) { echo $_SESSION["GTMsgtoUser"]; unset($_SESSION["GTMsgtoUser"]); }?>
			<form action="" method="post" enctype="multipart/form-data" name="gtregisterforms" id="gtregisterforms">
                <div class="rws-fields">    
                    <input type="email" name="rwsusername" id="rwsusername" value="<?php echo $_SESSION['myForm']['rwsusername']; ?>" placeholder="*Email ID" required />    
                </div>
                 <div class="rws-fields">    
                    <input type="password" name="rwspassword" id="rwspassword" value="" placeholder="*Password" required autocomplete="off" />    
                </div>
                <div class="rws-fields">    
                    <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Register" class="rwsbutton width_100" />    
                </div>
			</form>
            
            <div class="rws-fields" style="text-align:center;">

            or

            </div>
            
			<div class="rws-fields" style="text-align:center;">
                <a href="members-facebook-login.php" class="rwssocialbtn rwsfacebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="members-google-login.php" class="rwssocialbtn rwsgoogle"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="members-twitter-login.php" class="rwssocialbtn rwstwitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>

            <div class="rws-fields">

                <div class="row">

                	<div class="col-sm-6"><a href="forget-password.php">Forgot Password?</a></div>

                    <div class="col-sm-6" style="text-align:right;"><a href="login.php">Login</a></div>

                </div>

            </div>

            

            <div class="rws-fields">
           	By registering with ShapingSteps, you agree to our <a href="http://www.shapingsteps.com/terms-of-service-for-services/" target="_blank">Terms of Service</a> and <a href="http://www.shapingsteps.com/privacy-policy/" target="_blank">Privacy Policy</a>. </div>

        

        </div>
        </div>

    

    </div>        

</div>

<!-- RWS Dashboard Starts -->        



<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 