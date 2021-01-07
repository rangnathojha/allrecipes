<?php include("includes/config.php"); $gtpage="editprofile"; checkuserlogin();?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php"); 
$gt_msgerror= "";
 
if($_SESSION['GTUserType']=="C")	{ } else { echo "<script>document.location.href='".$baseurl."edit-profile-sp.php'</script>";  }

if(isset($_POST["rwsformsubmit"]))
{
	$_SESSION['myForm'] = $_POST;
	if (empty($_POST['firstname']) ) 	{	$errors[]="Please fill out the First Name field.";		}
	/*elseif(preg_match('/[^A-Za-z]/', $_POST['rwsfname'])) { $errors[]= "First Name field contains only alphabet."; }*/
	if (empty($_POST['lastname']) ) 	{	$errors[]="Please fill out the Last Name field.";	}
	/*elseif(preg_match('/[^A-Za-z]/', $_POST['lastname'])) { $errors[]= "Last Name field contains only alphabet."; }	*/

	if(empty($_POST['mobile']) ) { $errors[]="Please fill out the Mobile field."; } 
	else if(!is_numeric($_POST['mobile'])) { $errors[]="Mobile number should be numeric only."; }
	else if(strlen($_POST['mobile'])!=10) { $errors[]="Mobile Number should be 10 digits."; }

	if (empty($_POST['gender']) ) 	{	$errors[]="Please fill out the Gender field.";		}
	
	if (empty($_POST['dobdate']) || empty($_POST['dobmonth']) || empty($_POST['dobyear'])) {
		$errors[]='Please fill out the Date of birth.';
	}
	else
	{
		if(checkdate($_POST['dobmonth'], $_POST['dobdate'], $_POST['dobyear']))
		{			

		}
		else
		{
			$errors[]='The selected date of birth '.$_POST['dobdate'].'/'.$_POST['dobmonth'].'/'.$_POST['dobyear'].' is not Valid! Please Select a valid Date of Birth!';
		}
	}
	
	if (empty($_POST['address']) ) 	{	$errors[]="Please fill out the Address field.";		}
	/*if (empty($_POST['location']) ) 	{	$errors[]="Please fill out the Location field.";		}*/

	// Allowed file types. add file extensions WITHOUT the dot.
	$allowtypes=array("jpg", "JPG", "JPEG", "jpeg", "PNG", "png");
	$max_file_size="2048";
	// checks that profile pic condition
	if((!empty($_FILES["image_1"])) && ($_FILES['image_1']['error'] == 0)) {
	// basename -- Returns filename component of path
	$filename = basename($_FILES['image_1']['name']);
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$filesize=$_FILES['image_1']['size'];
	$max_bytes=$max_file_size*1024;
	//Check if the file type uploaded is a valid file type. 

	if (!in_array($ext, $allowtypes)) {
		$errors[]="Profile pic <strong>".$filename."</strong> has been rejected! Only the following corporate logo formats are allowed: .jpg, .JPG, .jpeg, .JPEG and .PNG.";
	// check the size of each file
	} elseif($filesize > $max_bytes) {
		$errors[]= "Profile pic: <strong>".$filename."</strong> is to big. Max file size is ".$max_file_size." kb.";
	}
	} // if !empty FILES
	// checks that profile pic condition
	if((!empty($_FILES["image_2"])) && ($_FILES['image_2']['error'] == 0)) {
	// basename -- Returns filename component of path
	$filename = basename($_FILES['image_2']['name']);
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$filesize=$_FILES['image_2']['size'];
	$max_bytes=$max_file_size*1024;	
	$allowtypes=array("doc", "docx", "pdf");
	//Check if the file type uploaded is a valid file type. 
	if (!in_array($ext, $allowtypes)) {
		$errors[]="Resume <strong>".$filename."</strong> has been rejected! Only the following corporate logo formats are allowed: .doc, .docx, .pdf.";	
	// check the size of each file
	} elseif($filesize > $max_bytes) {
		$errors[]= "Resume: <strong>".$filename."</strong> is to big. Max file size is ".$max_file_size." kb.";
	}
	} // if !empty FILES

	
	if(empty($errors)) 
	{
			$array_rand = array("rad", "dfd","met","axz", "yza", "tst", "tms", "lpg","art","mec","efc","mar","kar","lad","mah");
			$rand1 = mt_rand(100,999);
			$rand2 = mt_rand(100000,999999);
			$rand_keys = array_rand($array_rand, 2);

			$year = date("Y");
			$month = date("m");
			$date = date("d");			

			$yearfolder = "images/userserviceprovider/".$year;
			$monthfolder = 'images/userserviceprovider/'.$year.'/'.$month;
			$datefolder = 'images/userserviceprovider/'.$year.'/'.$month.'/'.$date;
			if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }
			if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }
			if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }

			$uploadfolder = $datefolder;
			$imgurl = 'images/userserviceprovider/'.$year.'/'.$month.'/'.$date.'/';

			for($k=1;$k<=2;$k++)
			{
				if(!empty($_FILES['image_'.$k]['name']))
				{
					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];
					$arrayimage[$k] = $_FILES['image_'.$k]['name'];
					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];
					if (is_uploaded_file($fileThumbnail))
					{
						move_uploaded_file ($fileThumbnail, $add_thumbnail);
					}
					$imageuploadname[$k] = $imgurl.$k."_".$rand2."_".$arrayimage[$k];	
				}
				else
				{
					$imageuploadname[$k]=$_POST['oldimage_'.$k];
				}
			}
			$dateofbirth = $_POST['dobyear'].'-'.$_POST['dobmonth'].'-'.$_POST['dobdate'];

			$firstname 				= addslashes($_POST["firstname"]);
			$middlename				= addslashes($_POST["middlename"]);
			$lastname 				= addslashes($_POST["lastname"]);
			$gender 				= addslashes($_POST["gender"]);
			$address 				= addslashes($_POST['address']);
			$mobile 				= addslashes($_POST['mobile']);
			$location 				= addslashes($_POST['location']);
			$area 					= addslashes($_POST['area']);
			$city 					= addslashes($_POST['city']);
			$higher_education 		= addslashes($_POST['city']);
			$state 					= addslashes($_POST['state']);
			$pincode 				= addslashes($_POST['pincode']);
			$country 				= addslashes($_POST['country']);			
			$resume_text			= addslashes($_POST['resume_text']);			

			/* Update Data To Database */
			
			$update_query = "UPDATE `ss_users` SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', mobile = '$mobile', photograph = '".$imageuploadname[1]."', gender = '$gender', dateofbirth = '$dateofbirth', address = '$address', location = '$location', area = '$area', city = '$city', state = '$state', pincode = '$pincode', country = '$country' WHERE `user_id`=".$_SESSION['GTUserID'];

			$update_result = $db->query($update_query);	
			
			$_SESSION['GTUserFirstName']		=	$firstname;
			$_SESSION['GTUserLastName']			=	$lastname;				
			$_SESSION['GTUserMobile']			=	$mobile;	
			$_SESSION['GTUserphotograph']		=	$imageuploadname[1];

			$_SESSION['GTMsgtoUser'] = '<div id="rws-formsuccess">Great! Your profile has been updated.</div>';	

			echo "<script>document.location.href='".$baseurl."edit-profile.php'</script>";
			exit;
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

if(empty($_POST)) {
	$select_query = 'SELECT * FROM `ss_users` WHERE user_id = "'.$_SESSION['GTUserID'].'"';
	$select_result = $db->query($select_query);
	$rowut = $select_result->row;
	
	$_SESSION['myForm']['firstname'] = stripslashes($rowut['firstname']);
	$_SESSION['myForm']['middlename'] = stripslashes($rowut['middlename']);
	$_SESSION['myForm']['lastname'] = stripslashes($rowut['lastname']);
	$_SESSION['myForm']['gender'] = stripslashes($rowut['gender']);
	$_SESSION['myForm']['profile_pic'] = stripslashes($rowut['photograph']);
	$_SESSION['myForm']['birthday'] = stripslashes($rowut['dateofbirth']);
	$_SESSION['myForm']['address'] = stripslashes($rowut['address']);
	$_SESSION['myForm']['location'] = stripslashes($rowut['location']);
	$_SESSION['myForm']['area'] = stripslashes($rowut['area']);
	$_SESSION['myForm']['city'] = stripslashes($rowut['city']);
	$_SESSION['myForm']['state'] = stripslashes($rowut['state']);
	$_SESSION['myForm']['pincode'] = stripslashes($rowut['pincode']);
	$_SESSION['myForm']['country'] = stripslashes($rowut['country']);
	$_SESSION['myForm']['mobile'] = stripslashes($rowut['mobile']);	
	$datearray = explode('-',$_SESSION['myForm']["birthday"]);
	if($_SESSION['myForm']["dobdate"]=="")  { $_SESSION['myForm']["dobdate"] = $datearray[2]; 	}
	if($_SESSION['myForm']["dobmonth"]=="") { $_SESSION['myForm']["dobmonth"] = $datearray[1]; 	}
	if($_SESSION['myForm']["dobyear"]=="")  { $_SESSION['myForm']["dobyear"] = $datearray[0]; 	}
}

?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">	

    <div class="row">  
    	<?php if(!empty($_SESSION['GTUserMobile']))
		{  
			include("application/left-sidebar.php");
		}
		?>
        

    	<div class="<?php if(!empty($_SESSION['GTUserMobile'])) { ?>col-sm-9<?php } else { ?>col-sm-offset-2 col-sm-8<?php } ?> rws-userformdesign">
        	<h1 style="margin-top:0; font-size:24px; text-align:center; margin-bottom:15px;">Edit Profile</h1>

        	<?php echo $gt_msgerror; if(isset($_SESSION["GTMsgtoUser"])) { echo $_SESSION["GTMsgtoUser"]; unset($_SESSION["GTMsgtoUser"]); }?>
			<form action="" method="post" enctype="multipart/form-data" name="gtregisterforms" id="gtregisterforms">
        	<div class="rws-fields">    
                <?php echo $_SESSION['myForm']['rwsusername']; ?>
            </div>
                
            <div class="rws-fields row">    
                <div class="col-sm-4">
                	<input type="text" name="firstname" id="firstname" value="<?php echo $_SESSION['myForm']['firstname']; ?>" placeholder="*Firstname" required />            	</div>                    
                <div class="col-sm-4">
                	<input type="text" name="middlename" id="middlename" value="<?php echo $_SESSION['myForm']['middlename']; ?>" placeholder="Middlename" />            	</div>                    
                <div class="col-sm-4">
                	 <input type="text" name="lastname" id="lastname" value="<?php echo $_SESSION['myForm']['lastname']; ?>" placeholder="*Lastname" required />            	</div>                
           </div>
                
                
           <div class="rws-fields row">
           		<div class="col-sm-6">      
                	<input type="text" name="mobile" id="mobile" value="<?php echo $_SESSION['myForm']['mobile']; ?>" placeholder="*Mobile" required />            
                </div>
                
                <div class="col-sm-6"> 
                	<?php echo todisplay($array_gender, 'gender', 'Select', $_SESSION['myForm']['gender'], $onchange=""); ?>
                </div>
            </div>
            
            <div class="rws-fields row">
           		<div class="col-sm-6">    
                <span style="float:left; display:inline-block; margin:3px 10px 0 0;">*Date of Birth</span>
                	<select name="dobdate" id="dobdate" class="gt-dateselectbox">

                                <option value=""> Date </option>

                                <?php echo dobdatelist($_SESSION['myForm']['dobdate']); ?>

                              </select>

                              <select name="dobmonth" id="dobmonth" class="gt-dateselectbox">

                                <option value=""> Month </option>

                                <?php echo dobmonthlist($_SESSION['myForm']['dobmonth']); ?>

                              </select>

                              <select name="dobyear" id="dobyear" class="gt-dateselectbox">

                                <option value=""> Year </option>

                                <?php echo dobyearlist($_SESSION['myForm']['dobyear']); ?>

                              </select>
                </div>
                
                <div class="col-sm-6"> 
                	<input type="text" name="address" id="address" value="<?php echo $_SESSION['myForm']['address']; ?>" placeholder="*Address" required />
                </div>
            </div>
            
            <div class="rws-fields row">
           		<div class="col-sm-6">      
                	<input type="text" name="location" id="location" value="<?php echo $_SESSION['myForm']['location']; ?>" placeholder="Location" />         
                </div>
                
                <div class="col-sm-6"> 
                	<input type="text" name="area" id="area" value="<?php echo $_SESSION['myForm']['area']; ?>" placeholder="Area" />
                </div>
            </div>
            
            <div class="rws-fields row">
           		<div class="col-sm-6">      
                	<input type="text" name="city" id="city" value="<?php echo $_SESSION['myForm']['city']; ?>" placeholder="*City" required />         
                </div>
                
                <div class="col-sm-6"> 
                	<input type="text" name="state" id="state" value="<?php echo $_SESSION['myForm']['state']; ?>" placeholder="*state" required />
                </div>
            </div>
            
            <div class="rws-fields row">
           		<div class="col-sm-6">      
                	<input type="text" name="pincode" id="pincode" value="<?php echo $_SESSION['myForm']['pincode']; ?>" placeholder="*pincode" required />         
                </div>
                
                <div class="col-sm-6"> 
                	<input type="text" name="country" id="country" value="<?php echo $_SESSION['myForm']['country']; ?>" placeholder="*country" required />
                </div>
            </div>
            
            <div class="rws-fields row">
           		<div class="col-sm-6">      
                  Profile Pic: <input name="image_1" id="image_1" type="file" style="display:inline-block;" /> <small>(Allowed Types: .jpg, .jpeg, .png of maximum size 2 MB. )</small>
                  <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['profile_pic']; ?>" /> 
                  <?php if(!empty($_SESSION['myForm']['profile_pic'])) { echo '<br/><a href="'.$_SESSION['myForm']['profile_pic'].'" target="_blank">Click here to View</a>'; } ?>
                        
                </div>
                
                <div class="col-sm-6"> 
                	&nbsp;
                </div>
            </div>
            
            
            
			<div class="rws-fields row">
                <div class="col-sm-offset col-sm-4">    
                    <input type="submit" name="rwsformsubmit" id="rwsformsubmit" value="Submit" class="rwsbutton width_100" />    
                </div>
            </div>
            </form>                    

        </div>

    

    </div>        

</div>

<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 