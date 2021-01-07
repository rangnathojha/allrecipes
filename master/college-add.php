<?php include('header.php'); $gtpage = 'college-list'; $rwseditor=1;

$_SESSION['myForm']=array();

if(isset($_POST["rws-submit"]))

{

	global $gt_exploits, $gt_profanity, $gt_spamwords;

	foreach ($_POST as $key => $val) {

		$_POST["$key"] = cleandatafromspam($val);

	

		if (preg_match($gt_exploits, $val)) {

			exit("<p>Exploits/malicious scripting attributes aren't allowed.</p>");

		} elseif (preg_match($gt_profanity, $val) || preg_match($gt_spamwords, $val)) {

			exit("<p>That kind of language is not allowed through our form.</p>");

		}

	}

	

	$_SESSION['myForm'] = $_POST;

	



	$title 						= addslashes($_POST["title"]);

	$location 					= addslashes($_POST["location"]);	

	$shortname 					= addslashes($_POST["shortname"]);

	$status 					= addslashes($_POST["status"]);	

	$post_id 					= $_POST["post_id"];

	$year_start 				= $_POST["year_start"];

	$branch_start 				= $_POST["branch_start"];
	
	$year_end 					= $_POST["year_end"];

	$branch_end 				= $_POST["branch_end"];
	$account_validation 		= $_POST["account_validation"];
	$college_tld 		= $_POST["college_tld"];

	

	// Form Validation Code

	$errors = array(); //Initialize error array 

	if (empty($_POST['title']) ) 		{	$errors[]="College Name field can't be blank!";			}

	if (empty($_POST['location']) ) 	{	$errors[]="College Location field can't be blank!";		}

	if (empty($_POST['shortname']) ) 	{	$errors[]="College Short Name field can't be blank!";	}

	if (empty($_POST['year_start']) ) 	{	$errors[]="Year Start field can't be blank!";	}

	if (empty($_POST['branch_start']) ) {	$errors[]="Branch Start field can't be blank!";	}
	
	if (empty($_POST['year_end']) ) 	{	$errors[]="Year upto character field can't be blank!";	}

	if (empty($_POST['branch_end']) ) {	$errors[]="Branch upto character field can't be blank!";	}

	

	// Allowed file types. add file extensions WITHOUT the dot.

	$allowtypes=array("jpg", "JPG", "JPEG", "jpeg", "gif", "GIF", "PNG", "png");

	$max_file_size="2048";

	

	// checks that we have a file

	if((!empty($_FILES["image_1"])) && ($_FILES['image_1']['error'] == 0)) {

	// basename -- Returns filename component of path

	$filename = basename($_FILES['image_1']['name']);

	$ext = substr($filename, strrpos($filename, '.') + 1);

	$filesize=$_FILES['image_1']['size'];

	$max_bytes=$max_file_size*1024;

	

	//Check if the file type uploaded is a valid file type. 

	if (!in_array($ext, $allowtypes)) {

		$errors[]="File <strong>".$filename."</strong> has been rejected! Only the following corporate logo formats are allowed: .jpg, .JPG, .jpeg, .JPEG, .gif and .PNG.";	

	// check the size of each file

	} elseif($filesize > $max_bytes) {

		$errors[]= "Your file: <strong>".$filename."</strong> is to big. Max file size is ".$max_file_size." kb.";

	}

	

	} // if !empty FILES

	

	

	

	if(empty($errors)) {		

		

		// UPLOAD FILE CODE STARTS 

		

		if(trim($post_id) =="")

		{

		

			$array_rand = array("rad", "dfd","met","axz", "yza", "tst", "tms", "lpg","art","mec","efc","mar","kar","lad","mah");

			$rand1 = mt_rand(100,999);

			$rand2 = mt_rand(100000,999999);

			$rand_keys = array_rand($array_rand, 2);

			

			$year = date("Y");

			$month = date("m");

			$date = date("d");

			

			$yearfolder = "../images/collegepic/".$year;

			$monthfolder = '../images/collegepic/'.$year.'/'.$month;

			$datefolder = '../images/collegepic/'.$year.'/'.$month.'/'.$date;

			

			if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }

			if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }

			if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }

			

			$uploadfolder = $datefolder;

			

			for($k=1;$k<=2;$k++)

			{

				$img_name_rand[$k] = $array_rand[$rand_keys[0]]."_".$rand2."_".$array_rand[$rand_keys[1]]."_".$rand1."_".$k.".jpg";

				

				if(!empty($_FILES['image_'.$k]['name']))

				{

					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];

					$arrayimage[$k] = $_FILES['image_'.$k]['name'];

					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];

					if (is_uploaded_file($fileThumbnail))

					{

						move_uploaded_file ($fileThumbnail, $add_thumbnail);

					}

					

					$imageuploadname[$k] = $k."_".$rand2."_".$arrayimage[$k];			

			

				}

				else

				{

					$imageuploadname[$k]="";

				}

			}

			

			$imgurl = 'images/collegepic/'.$year.'/'.$month.'/'.$date.'/';

		

		}

		else

		{		

			$array_rand = array("rad", "dfd","met","axz", "yza", "tst", "tms", "lpg","art","mec","efc","mar","kar","lad","mah");

			$rand1 = mt_rand(100,999);

			$rand2 = mt_rand(100000,999999);

			$rand_keys = array_rand($array_rand, 2);

			

			$year = date("Y");

			$month = date("m");

			$date = date("d");

			

			if(trim($_POST['uploadfolder'])=="")

			{

				$yearfolder = "../images/collegepic/".$year;

				$monthfolder = '../images/collegepic/'.$year.'/'.$month;

				$datefolder = '../images/collegepic/'.$year.'/'.$month.'/'.$date;

				

				if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }

				if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }

				if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }

				

				$uploadfolder = $datefolder;

				$imgurl = 'images/collegepic/'.$year.'/'.$month.'/'.$date.'/';

			}

			else

			{			

				$uploadfolder = '../'.$_POST['uploadfolder'];

				$imgurl = trim($_POST['uploadfolder']);	

			}

			

			for($k=1;$k<=2;$k++)

			{

				$img_name_rand[$k] = $array_rand[$rand_keys[0]]."_".$rand2."_".$array_rand[$rand_keys[1]]."_".$rand1."_".$k.".jpg";

				

				if(!empty($_FILES['image_'.$k]['name']))

				{

					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];

					$arrayimage[$k] = $_FILES['image_'.$k]['name'];

					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];

					if (is_uploaded_file($fileThumbnail))

					{

						move_uploaded_file ($fileThumbnail, $add_thumbnail);

					}

					

					$imageuploadname[$k] = $k."_".$rand2."_".$arrayimage[$k];			

			

				}

				else

				{

					$imageuploadname[$k]=$_POST['oldimage_'.$k];

				}

			}		

		}

		

		// UPLOAD FILE CODE STARTS 

		

		if(trim($post_id)!="")

		{

			$update_query = "UPDATE `college_name` SET `name` = '$title', `status` = '$status', `location` = '$location', `shortname` = '$shortname', `college_photo` = '".$imageuploadname[1]."', `imgurl` = '$imgurl', `year_start` = '$year_start', `branch_start` = '$branch_start', `year_end` = '$year_end', `branch_end` = '$branch_end', `account_validation` = '$account_validation', `college_tld`='$college_tld' WHERE `id`= '$post_id'";

			$update_result = $db->query($update_query);

			

			$msg_result='<div id="gt-formsuccess">College has been updated successfully.!</div>';			

		}

		else

		{			

			

			$update_query = "INSERT INTO `college_name` (`id`, `name`, `location`, `shortname`, `college_photo`, `imgurl`, `status`, `year_start`, `branch_start`, `year_end`, `branch_end`, `account_validation`, `college_tld`, `add_date`) VALUES (NULL, '$title', '$location', '$shortname', '".$imageuploadname[1]."', '$imgurl', '$status', '$year_start', '$branch_start', '$year_end', '$branch_end', '$account_validation', '$college_tld', '$gtcurrenttime')";

			$update_result = $db->query($update_query);

			

			$msg_result='<div id="gt-formsuccess">College has been added successfully.!</div>';

			

		}

		

		unset($_SESSION['myForm']);

	}

}



if(isset($_GET["fid"]))

{

$select_query = 'SELECT * FROM `college_name` WHERE id = "'.$_GET["fid"].'"';

$select_result = $db->query($select_query);

$row = $select_result->row;



$_SESSION['myForm']['id'] = stripslashes($row['id']);

$_SESSION['myForm']['title'] = stripslashes($row['name']);

$_SESSION['myForm']['location'] = stripslashes($row['location']);

$_SESSION['myForm']['shortname'] = stripslashes($row['shortname']);

$_SESSION['myForm']['college_photo'] = stripslashes($row['college_photo']);

$_SESSION['myForm']['imgurl'] = stripslashes($row['imgurl']);

$_SESSION['myForm']['status'] = stripslashes($row['status']);

$_SESSION['myForm']['year_start'] = stripslashes($row['year_start']);

$_SESSION['myForm']['branch_start'] = stripslashes($row['branch_start']);

$_SESSION['myForm']['year_end'] = stripslashes($row['year_end']);

$_SESSION['myForm']['college_tld'] = stripslashes($row['college_tld']);

$_SESSION['myForm']['branch_end'] = stripslashes($row['branch_end']);
$_SESSION['myForm']['account_validation'] = stripslashes($row['account_validation']);

	$reg_title = 'Edit College';

	$reg_subtitle = 'College Edit Page';

	$reg_breadcrumb = 'Edit College';

	$reg_button = 'Update';



}

else

{	

	$reg_title = 'Add New College';

	$reg_subtitle = 'College Add Page';

	$reg_breadcrumb = 'Add New College';

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

                        <li><a href="<?php echo $baseurl; ?>master/ukc-submissions.php"><i class="fa fa-leaf"></i> Category List </a></li>

                        <li class="active"><?php echo $reg_breadcrumb; ?></li>

                    </ol>

                </section>



                <!-- Main content -->

                <section class="content">

                <form role="form" name="rwsglobalform"  id="rwsglobalform" action="" method="post" enctype="multipart/form-data">

                	<div class="row">

                        <div class="col-md-12">

                        <?php if(!empty($errors)) {

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

                                    <h3 class="box-title">College Details</h3>

                                </div><!-- /.box-header -->

                                <!-- form start -->

                                	<?php if(trim($row['id']) !="") { ?>

                                    	<input name="post_id" type="hidden" value="<?php echo $row['id']; ?>" />

                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['college_photo']; ?>" />

                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />

                                    <?php } ?>

                                    <div class="box-body">

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">College Name<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="title" placeholder="College Name" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">College Email TLD<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="college_tld" placeholder="College Email TLD" id="college_tld" class="form-control" value="<?php echo $_SESSION['myForm']['college_tld']; ?>"></div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">College Location</label></div>

                                            <div class="col-md-10"><input type="text" name="location" placeholder="College Location" id="location" class="form-control" value="<?php echo $_SESSION['myForm']['location']; ?>"></div>

                                        </div>

                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">College Short Name</label></div>

                                            <div class="col-md-10"><input type="text" name="shortname" placeholder="College Short Name" id="shortname" class="form-control" value="<?php echo $_SESSION['myForm']['shortname']; ?>"></div>

                                        </div>

                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">College Pic</label></div>

                                            <div class="col-md-10">

                                            	<input name="image_1" id="image_1" type="file" /><br />

												<span class="error">(Image type should be <strong>jpg</strong> and maximum size will be <strong>1024 kb</strong> only. )</span><br />

												<?php if(trim($row['id']) !="") { if($row['college_photo']!="") { ?><a href="<?php echo $baseurl.$_SESSION['myForm']['imgurl'].$_SESSION['myForm']['college_photo']; ?>" title="View College Pic" target="_blank">View College Pic</a><?php } else { echo "<strong>No College Pic added yet!</strong>"; } }?>

                                             </div>

                                        </div>

                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Status</label></div>

                                            <div class="col-md-10"><input type="radio" name="status" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['status']=='1') { echo 'checked="checked"'; } ?>  /> Published &nbsp;&nbsp;&nbsp;&nbsp;

                                                  <input type="radio" name="status" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['status']=='0') { echo 'checked="checked"'; } ?>  />  Unpublished                                              

                                            </div>

                                        </div> 
                                        
                                       <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Account Verification</label></div>

                                            <div class="col-md-10"><input type="radio" name="account_validation" value="1" id="RadioGroup2_0" <?php if($_SESSION['myForm']['account_validation']=='1') { echo 'checked="checked"'; } ?>  /> Enable &nbsp;&nbsp;&nbsp;&nbsp;

                                                  <input type="radio" name="account_validation" value="0" id="RadioGroup2_1" <?php if($_SESSION['myForm']['account_validation']=='0') { echo 'checked="checked"'; } ?>  />  Disable                                              

                                            </div>

                                        </div>  

                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Enroll - Year Start</label></div>

                                            <div class="col-md-10"><input type="text" name="year_start" placeholder="Enrollment - Year Start position" id="year_start" class="form-control" value="<?php echo $_SESSION['myForm']['year_start']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Enroll - Year upto char</label></div>

                                            <div class="col-md-10"><input type="text" name="year_end" placeholder="Enrollment - Year total char" id="year_end" class="form-control" value="<?php echo $_SESSION['myForm']['year_end']; ?>"></div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Enroll - Branch Start</label></div>

                                            <div class="col-md-10"><input type="text" name="branch_start" placeholder="Enrollment - Branch Start position" id="branch_start" class="form-control" value="<?php echo $_SESSION['myForm']['branch_start']; ?>"></div>

                                        </div>  
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Enroll - Branch upto char</label></div>

                                            <div class="col-md-10"><input type="text" name="branch_end" placeholder="Enrollment - Branch total char" id="branch_end" class="form-control" value="<?php echo $_SESSION['myForm']['branch_end']; ?>"></div>

                                        </div>                                    

                                        

                                    </div><!-- /.box-body -->                                    

                                

                            </div>

                        </div>

                        

                        </div>

                        

                        <div class="row">

                            <div class="col-md-12">

                                <div class="box box-warning">

                                    <div class="box-footer" style="text-align:center">

                                          <button class="btn btn-primary" type="submit" name="rws-submit"> <?php echo $reg_button; ?> </button>

                                          &nbsp;&nbsp;&nbsp;&nbsp;

                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='college-list.php'"> Back </button>

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

<?php include('footer.php'); ?>