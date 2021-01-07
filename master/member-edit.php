<?php include('header.php'); $gtpage = 'member-list'; $rwseditor=0;   checkadminroles('members');

$_SESSION['myForm']=array();

if(isset($_POST["rws-submit"]))
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
		$errors[]='Please fill out the Date of birth field.';
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
	
	if($_GET["back"]!="c")
	{			
		if (empty($_POST['signinas']) ) 	{	$errors[]="Please fill out the Sign in as field.";		}
	
		if ($_POST['signinas']=="Institutional") 	{
			if (empty($_POST['organization']) ) 	{	$errors[]="Please fill out the Name of the organization field.";		}
		}	
	}

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
	
	if((!empty($_FILES["image_3"])) && ($_FILES['image_3']['error'] == 0)) {
	// basename -- Returns filename component of path
	$filename = basename($_FILES['image_3']['name']);
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$filesize=$_FILES['image_3']['size'];
	$max_bytes=$max_file_size*1024;
	//Check if the file type uploaded is a valid file type. 

	if (!in_array($ext, $allowtypes)) {
		$errors[]="Cover pic <strong>".$filename."</strong> has been rejected! Only the following corporate logo formats are allowed: .jpg, .JPG, .jpeg, .JPEG and .PNG.";
	// check the size of each file
	} elseif($filesize > $max_bytes) {
		$errors[]= "Cover pic: <strong>".$filename."</strong> is to big. Max file size is ".$max_file_size." kb.";
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

			$yearfolder = "../images/userserviceprovider/".$year;
			$monthfolder = '../images/userserviceprovider/'.$year.'/'.$month;
			$datefolder = '../images/userserviceprovider/'.$year.'/'.$month.'/'.$date;
			if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }
			if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }
			if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }

			$uploadfolder = $datefolder;
			$imgurl = '../images/userserviceprovider/'.$year.'/'.$month.'/'.$date.'/';

			for($k=1;$k<=3;$k++)
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
			$occupation				= addslashes($_POST['occupation']);
			$designation 			= addslashes($_POST['designation']);
			$signinas 				= addslashes($_POST['signinas']);			
			$organization			= addslashes($_POST['organization']);

			$about_yourself			= addslashes($_POST['about_yourself']);	
			$user_type			= addslashes($_POST['user_type']);
			
			$email			= addslashes($_POST['email']);	
			
			$post_id	= $_POST["post_id"];

			/* Update Data To Database */
			
			$update_query = "UPDATE `ss_users` SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', email = '$email', mobile = '$mobile', photograph = '".$imageuploadname[1]."', gender = '$gender', dateofbirth = '$dateofbirth', address = '$address', location = '$location', area = '$area', city = '$city', state = '$state', pincode = '$pincode', country = '$country', cover_pic = '".$imageuploadname[3]."', about_yourself = '$about_yourself', user_type = '$user_type' WHERE `user_id`=".$post_id;

			$update_result = $db->query($update_query);	
			
			if($_GET["back"]!="c")
			{			
				if($_POST["gtsecondtblitems"]==0)
				{
					$update_query = "INSERT INTO `ss_service_provider` SET resume = '".$imageuploadname[2]."', resume_text = '$resume_text', occupation = '$occupation', designation = '$designation', signinas = '$signinas', organization = '$organization', `user_id`=".$post_id;
				}
				else
				{
					$update_query = "UPDATE `ss_service_provider` SET resume = '".$imageuploadname[2]."', resume_text = '$resume_text', occupation = '$occupation', designation = '$designation', signinas = '$signinas', organization = '$organization' WHERE `user_id`=".$post_id;
				}			
			}
			$update_result = $db->query($update_query);	
			

			$_SESSION['GTUserFirstName']		=	$firstname;
			$_SESSION['GTUserLastName']			=	$lastname;				
			$_SESSION['GTUserMobile']			=	$mobile;
			$_SESSION['GTUserphotograph']		=	$imageuploadname[1];	

			$_SESSION['GTMsgtoUser'] = '<div id="rws-formsuccess">Great! Your profile has been updated.</div>';	

			echo "<script>document.location.href='".$baseurl."master/member-edit.php?fid=".$post_id."&back=".$_GET["back"]."'</script>";
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



if(isset($_GET["fid"]))
{
	$select_query = 'SELECT * FROM `ss_users` WHERE user_id = "'.$_GET["fid"].'"';
	$select_result = $db->query($select_query);
	$rowut = $select_result->row;
	
	$select_query = 'SELECT * FROM `ss_service_provider` WHERE user_id = "'.$_GET["fid"].'"';
	$select_result = $db->query($select_query);
	
	$numrows=$select_result->num_rows;
	
	$rowup = $select_result->row;
	
	if(empty($_SESSION['myForm']))
	{
	
	$_SESSION['myForm']['firstname'] = stripslashes($rowut['firstname']);
	$_SESSION['myForm']['middlename'] = stripslashes($rowut['middlename']);
	$_SESSION['myForm']['lastname'] = stripslashes($rowut['lastname']);
	$_SESSION['myForm']['gender'] = stripslashes($rowut['gender']);
	
	$_SESSION['myForm']['email'] = stripslashes($rowut['email']);
	$_SESSION['myForm']['about_yourself'] = stripslashes($rowut['about_yourself']);
	
	$_SESSION['myForm']['cover_pic'] = stripslashes($rowut['cover_pic']);
	
	$_SESSION['myForm']['dateofbirth'] = stripslashes($rowut['dateofbirth']);
	$_SESSION['myForm']['address'] = stripslashes($rowut['address']);
	$_SESSION['myForm']['location'] = stripslashes($rowut['location']);
	$_SESSION['myForm']['area'] = stripslashes($rowut['area']);
	$_SESSION['myForm']['city'] = stripslashes($rowut['city']);
	$_SESSION['myForm']['state'] = stripslashes($rowut['state']);
	$_SESSION['myForm']['pincode'] = stripslashes($rowut['pincode']);
	$_SESSION['myForm']['country'] = stripslashes($rowut['country']);
	$_SESSION['myForm']['mobile'] = stripslashes($rowut['mobile']);	
	$_SESSION['myForm']['resume'] = stripslashes($rowup['resume']);
	$_SESSION['myForm']['resume_text'] = stripslashes($rowup['resume_text']);
	$_SESSION['myForm']['occupation'] = stripslashes($rowup['occupation']);
	$_SESSION['myForm']['designation'] = stripslashes($rowup['designation']);
	$_SESSION['myForm']['signinas'] = stripslashes($rowup['signinas']);
	$_SESSION['myForm']['organization'] = stripslashes($rowup['organization']);	
	
	$_SESSION['myForm']['user_type'] =stripslashes($rowut['user_type']);
	
	$datearray = explode('-',$_SESSION['myForm']["dateofbirth"]);
	if($_SESSION['myForm']["dobdate"]=="")  { $_SESSION['myForm']["dobdate"] = $datearray[2]; 	}
	if($_SESSION['myForm']["dobmonth"]=="") { $_SESSION['myForm']["dobmonth"] = $datearray[1]; 	}
	if($_SESSION['myForm']["dobyear"]=="")  { $_SESSION['myForm']["dobyear"] = $datearray[0]; 	}
	
	
	
	$pos = strpos($rowut['photograph'], "userserviceprovider");


	if($pos===false) {
		$_SESSION['myForm']['profile_pic'] = stripslashes($rowut['photograph']);
	} else {
		$_SESSION['myForm']['profile_pic'] = $baseurl.stripslashes($rowut['photograph']);
	}
	
	}
	
	$reg_title = 'Member Details';
	$reg_subtitle = 'Member Details Page';
	$reg_breadcrumb = 'Member Details';
	$reg_button = 'Update';

}

else

{

	$reg_title = 'Add New Branch';
	$reg_subtitle = 'Branch Add Page';
	$reg_breadcrumb = 'Add New Branch';
	$reg_button = 'Save';
	if($_SESSION['myForm']['status']=="")
	{
		$_SESSION['myForm']['status'] = '1';
	}
}
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Left side column. contains the logo and sidebar -->

            <?php include('sidebar.php'); ?>



            <!-- Right side column. Contains the navbar and content of the page -->

            <aside class="right-side">

                <!-- Content Header (Page header) -->

                <section class="content-header">

                    <h1>

                        <?php echo $reg_title; ?>

                        <small><?php echo $reg_subtitle; ?></small>

                    </h1>

                    <ol class="breadcrumb">

                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<?php if($_GET["back"]=="sp") { ?>
                        <li><a href="<?php echo $baseurl; ?>master/member-list-sp.php"><i class="fa fa-leaf"></i> Member List </a></li>
						<?php } else { ?>
                        <li><a href="<?php echo $baseurl; ?>master/member-list.php"><i class="fa fa-leaf"></i> Member List </a></li>
                        <?php } ?>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>

                    </ol>

                </section>



                <!-- Main content -->

                <section class="content">

                <form role="form" name="rwsglobalform"  id="rwsglobalform" action="" method="post" enctype="multipart/form-data">

                	<div class="row">

                        <div class="col-md-12">
                        
                        

                        <?php 
						if(!empty($_SESSION["gtThanksMSG"])) { echo $_SESSION["gtThanksMSG"]; unset($_SESSION["gtThanksMSG"]); }
						
						if(!empty($errors)) {

                            	echo '<div id="gt-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';

                                foreach ($errors as $msg) { //prints each error

                                echo "<li>$msg</li>";

                                } // end of foreach

                                echo '</ul></div>'; }

                                

                                if($msg_result !="") { echo $msg_result; }

                        ?>

                        </div>

                    </div>

					<div class="row">

                    

                    	<div class="col-md-12">

                        	<div class="box box-primary">

                                <div class="box-header">

                                    <h3 class="box-title">Member Details</h3>

                                </div><!-- /.box-header -->

                                <!-- form start -->

                                	<?php if(trim($_GET['fid'])!="") { ?>

                                    	<input name="post_id" type="hidden" value="<?php echo $_GET["fid"]; ?>" />
                                        
                                        <input type="hidden" name="gtsecondtblitems" value="<?php echo $numrows; ?>" />

                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['profile_pic']; ?>" />                                      
                                        <input name="oldimage_2" type="hidden" value="<?php echo $_SESSION['myForm']['resume']; ?>" />
                                        
                                        <input name="oldimage_3" type="hidden" value="<?php echo $_SESSION['myForm']['cover_pic']; ?>" />

                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />

                                    <?php } ?>

                                    <div class="box-body">
                                    
                                    	<div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">User Type<span class="error">*</span></label></div>

                                            <div class="col-md-10"><?php 
											foreach($array_signinasadmin as $key=>$val)
											{
												if($_SESSION['myForm']['user_type']==$key)
												{
													echo '<input name="user_type" type="radio" value="'.$key.'" ="" checked="checked" />&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;';
												}
												else
												{
													echo '<input name="user_type" type="radio" value="'.$key.'" ="" />&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;';
												}
											}
					
											?></div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">First Name<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="firstname" placeholder="*First Name" id="firstname" class="form-control" value="<?php echo $_SESSION['myForm']['firstname']; ?>" required="required"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Middle Name</label></div>

                                            <div class="col-md-10"><input type="text" name="middlename" placeholder="Middle Name" id="middlename" class="form-control" value="<?php echo $_SESSION['myForm']['middlename']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Last Name<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="lastname" placeholder="Last Name" id="lastname" class="form-control" value="<?php echo $_SESSION['myForm']['lastname']; ?>" required="required"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Email ID<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="email" name="email" placeholder="Email" id="email" class="form-control" value="<?php echo $_SESSION['myForm']['email']; ?>" required="required"></div>

                                        </div>                              

                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Mobile </label></div>

                                            <div class="col-md-10"><input type="text" name="mobile" placeholder="Mobile" id="mobile" class="form-control" value="<?php echo $_SESSION['myForm']['mobile']; ?>" required="required"></div>

                                        </div>                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Gender </label></div>

                                            <div class="col-md-10"><?php echo todisplay($array_gender, 'gender', 'Gender', $_SESSION['myForm']['gender'], $onchange=''); ?> 
											</div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Date of Birth </label></div>

                                            <div class="col-md-10">
                                            
                                            <select name="dobdate" id="dobdate" class="gt-dateselectbox" style="min-width:100px;">
                                                <option value=""> Date </option>
                                                <?php echo dobdatelist($_SESSION['myForm']['dobdate']); ?>
                                            </select>

                                              <select name="dobmonth" id="dobmonth" class="gt-dateselectbox" style="min-width:100px;">
                                                <option value=""> Month </option>
                                                <?php echo dobmonthlist($_SESSION['myForm']['dobmonth']); ?>
                                              </select>

                                              <select name="dobyear" id="dobyear" class="gt-dateselectbox" style="min-width:100px;">
                                                <option value=""> Year </option>
                                                <?php echo dobyearlist($_SESSION['myForm']['dobyear']); ?>
                                              </select>
                              			</div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Address </label></div>

                                            <div class="col-md-10"><input type="text" name="address" placeholder="Address" id="address" class="form-control" value="<?php echo stripslashes($_SESSION['myForm']['address']); ?>" required="required"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Location </label></div>

                                            <div class="col-md-10"><input type="text" name="location" placeholder="Location" id="location" class="form-control" value="<?php echo $_SESSION['myForm']['location']; ?>" required="required"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Area </label></div>

                                            <div class="col-md-10"><input type="text" name="area" placeholder="Area" id="area" class="form-control" value="<?php echo $_SESSION['myForm']['area']; ?>" required="required"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">City </label></div>

                                            <div class="col-md-10"><input type="text" name="city" placeholder="City" id="city" class="form-control" value="<?php echo $_SESSION['myForm']['city']; ?>" required="required"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">State </label></div>

                                            <div class="col-md-10"><input type="text" name="state" placeholder="State" id="state" class="form-control" value="<?php echo $_SESSION['myForm']['state']; ?>" required="required"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Pincode </label></div>

                                            <div class="col-md-10"><input type="text" name="pincode" placeholder="Pincode" id="pincode" class="form-control" value="<?php echo $_SESSION['myForm']['pincode']; ?>" required="required"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Country </label></div>

                                            <div class="col-md-10"><input type="text" name="country" placeholder="Country" id="country" class="form-control" value="<?php echo $_SESSION['myForm']['country']; ?>" required="required"></div>

                                        </div>
                                        
                                        <?php  if($_GET["back"]!="c") { ?>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Occupation </label></div>

                                            <div class="col-md-10"><input type="text" name="occupation" placeholder="Occupation" id="occupation" class="form-control" value="<?php echo $_SESSION['myForm']['occupation']; ?>"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Designation </label></div>

                                            <div class="col-md-10"><input type="text" name="designation" placeholder="Designation" id="designation" class="form-control" value="<?php echo $_SESSION['myForm']['designation']; ?>"></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Signin As </label></div>

                                            <div class="col-md-10"><?php foreach($array_signinas as $key=>$val)
																{
																	if($_SESSION['myForm']['signinas']==$key)
																	{
																		echo '<input name="signinas" type="radio" value="'.$key.'" ="" checked="checked" />&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;';
																	}
																	else
																	{
																		echo '<input name="signinas" type="radio" value="'.$key.'" ="" />&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;';
																	}
																} ?></div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Organisation </label></div>

                                            <div class="col-md-10"><input type="text" name="organization" placeholder="Organization" id="organization" class="form-control" value="<?php echo $_SESSION['myForm']['organization']; ?>" required="required"></div>

                                        </div>
                                        
                                        <?php } ?>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Profile Pic (Allowed Types: .jpg, .jpeg, .png of maximum size 2 MB. ) </label></div>

                                            <div class="col-md-10">
											<input name="image_1" id="image_1" type="file" /><br />
                                            <?php if($_SESSION['myForm']['profile_pic']!="") { echo '<a href="'.$_SESSION['myForm']['profile_pic'].'" target="_blank">Click here to View</a>'; } else { echo "<strong>No image added yet!</strong>"; } ?>
											
											</div>

                                        </div>
                                        
                                        <?php  if($_GET["back"]!="c") { ?>  
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Cover Pic (Allowed Types: .jpg, .jpeg, .png of maximum size 2 MB. ) </label></div>
                                            <div class="col-md-10">
											<input name="image_3" id="image_3" type="file" /><br />
                                            <?php if($_SESSION['myForm']['cover_pic']!="") { echo '<br/><a href="'.$_SESSION['myForm']['cover_pic'].'" target="_blank">Click here to View</a>'; } else { echo "<strong>No resume added yet!</strong>"; } ?>											
											</div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Resume (Allowed Types: .doc, .docx, .pdf of maximum size 2 MB. )</label></div>
                                            <div class="col-md-10">
											<input name="image_2" id="image_2" type="file" /><br />
                                            <?php if($_SESSION['myForm']['resume']!="") { echo '<a href="'.$_SESSION['myForm']['resume'].'" target="_blank">Click here to View</a>'; } else { echo "<strong>No resume added yet!</strong>"; } ?>											
											</div>

                                        </div>
                                        
                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Resume Text </label></div>

                                            <div class="col-md-10"><textarea name="resume_text" id="resume_text" style="height:100px; width:100%;" placeholder="*Resume in Text Format"><?php echo $_SESSION['myForm']['resume_text']; ?></textarea> </div>

                                        </div>  
                                        
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">About Yourself </label></div>

                                            <div class="col-md-10"><textarea name="about_yourself" id="about_yourself" style="height:100px; width:100%;" placeholder="*About yourself"><?php echo $_SESSION['myForm']['about_yourself']; ?></textarea> </div>

                                        </div>
                                        
                                        <?php } ?>
                                        
                                                                             

                                    </div><!-- /.box-body -->                                    

                                

                            </div>

                        </div>

                        

                        </div>
                        
                        <?php if($_GET["back"]=="sp") { ?>
                                        
                        <!-- Get Service List Starts -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
									<div class="box-header"><h3 class="box-title">Service List </h3> <span style="float:right; margin-right:10px; font-weight:bold; font-size:20px;"><a href="member-service-add.php?user_id=<?php echo $_GET['fid'];?>">Add New</a></span></div><!-- /.box-header -->
                                    <?php
									$querysl="SELECT t1.*, t2.name as service_name, t2.parent_id FROM ss_service_provider_services as t1 INNER JOIN ss_services as t2 ON t1.service_id=t2.service_id WHERE t1.service_provider_service_id > 0 and user_id = ".$_GET['fid']." ".$nquery;
									
									$rs = $db->query($querysl);
									$foundnum = $rs->num_rows;
									
									?>
                                    
                                    <?php if($foundnum>0) { ?>
		<table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Service Name</th>
          <th>Price</th>
          <th>Add Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php  
		$rowlist = $rs->rows;
		$j=1; foreach($rowlist as $key => $row1) { 
			if($row1["status"]=='0') 
			{ 
				$status = '<span style="color:#665252; font-weight:bold;">Unpublished</span>'; 
				$status_cls = 'style="border:1px solid #df8f8f; background: #ffcece;"'; 
			} 
			else 
			{ 
				$status = '<span style="color:#556652; font-weight:bold;">Published</span>'; 
				$status_cls = 'style="border:1px solid #9adf8f; background: #d5ffce;"';
			}
		 ?>
        <tr>
          <th scope="row"><?php echo $row1["service_provider_service_id"]; ?></th>
          <td><?php echo todisplaypath($row1['parent_id']).' > '.$row1["service_name"]; ?></td>
          <td><?php echo $row1["price"]; ?></td>
          <td><?php echo toshowdatewithtime($row1["add_date"]); ?></td>
          <td><a href="member-service-add.php?fid=<?php echo $row1["service_provider_service_id"]; ?>&user_id=<?php echo $_GET['fid'];?>">Edit</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <?php } else { echo '<div id="gt-forminfo">There is no service added yet.</div>'; } ?>
    <p>&nbsp;</p>
								
                                </div>
                            </div>
                        </div>                        
                        <!-- Get Service List Ends -->
                        
                        <!-- Get Hour List Starts -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
									<div class="box-header"><h3 class="box-title">Availability List</h3><span style="float:right; margin-right:10px; font-weight:bold; font-size:20px;"><a href="member-hours-add.php?user_id=<?php echo $_GET['fid'];?>">Add New</a></span></div><!-- /.box-header -->
                                    <?php
									$querys2="SELECT * FROM ss_service_provider_availability WHERE service_provider_availablity_id > 0 AND user_id=".$_GET['fid']." ".$nquery;
									
									$rs2 = $db->query($querys2);
									$foundnum2 = $rs2->num_rows;
									
									?>
                                    
                                    <?php if($foundnum2>0) { ?>
		<table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Day</th>
          <th>Start Time</th>
         <th>End time</th> 
         <th>Action</th>       
        </tr>
      </thead>
      <tbody>
      <?php  
		$rowlist = $rs2->rows;
		$j=1; foreach($rowlist as $key => $row) { 
			if($row["status"]=='0') 
			{ 
				$status = '<span style="color:#665252; font-weight:bold;">Unpublished</span>'; 
				$status_cls = 'style="border:1px solid #df8f8f; background: #ffcece;"'; 
			} 
			else 
			{ 
				$status = '<span style="color:#556652; font-weight:bold;">Published</span>'; 
				$status_cls = 'style="border:1px solid #9adf8f; background: #d5ffce;"';
			}
		 ?>
        <tr>
          <th scope="row"><?php echo $row["service_provider_availablity_id"]; ?></th>
          <td><?php echo $array_daysnew[$row["day"]]; ?></td>
          <td><?php echo $array_timeslot[$row["start_time"]]; ?></td>
          <td><?php echo $array_timeslot[$row["end_time"]]; ?></td>  
          <td><a href="member-hours-add.php?fid=<?php echo $row["service_provider_availablity_id"]; ?>&user_id=<?php echo $_GET['fid'];?>">Edit</a></td>     
        </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <?php } else { echo '<div id="gt-forminfo">There is no availability added yet.</div>'; } ?>
    <p>&nbsp;</p>
								
                                </div>
                            </div>
                        </div>                        
                        <!-- Get Hour List Ends -->
                        
                        <?php } ?>

                        

                        <div class="row">

                            <div class="col-md-12">

                                <div class="box box-warning">

                                    <div class="box-footer" style="text-align:center">

                                          <button class="btn btn-primary" type="submit" name="rws-submit"> <?php echo $reg_button; ?> </button>

                                          &nbsp;&nbsp;&nbsp;&nbsp;
										<?php if($_GET["back"]=="sp") { echo '<button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href=\'member-list-sp.php\'"> Back </button>'; } else { echo '<button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href=\'member-list.php\'"> Back </button>';  }
										
										?>

                                     </div>

                                </div>

                            </div>

                        </div>

                        </form>                          	

              </section><!-- /.content -->

              

              <footer>

              		<?php include('footer-copyright.php'); ?>

              </footer>

            </aside><!-- /.right-side -->

        </div><!-- ./wrapper -->   
        
        <script type="text/javascript">
		
		</script>     

<?php include('footer.php'); ?>