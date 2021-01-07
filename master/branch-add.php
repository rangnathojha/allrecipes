<?php include('header.php'); $gtpage = 'branch-list'; $rwseditor=0;

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
	
	$branch_short_name 			= addslashes($_POST["branch_short_name"]);
	
	$course_id 					= addslashes($_POST["course_id"]);	

	$college_id 				= addslashes($_POST["college_id"]);

	$status 					= addslashes($_POST["status"]);	

	$post_id 					= $_POST["post_id"];

	$course_branch_id 			= addslashes($_POST["course_branch_id"]);	

	

	// Form Validation Code

	$errors = array(); //Initialize error array 

	

	if (empty($_POST['title']) ) 		{	$errors[]="Branch Name field can't be blank!";			}
	
	if (empty($_POST['branch_short_name']) ) 		{	$errors[]="Branch Name field can't be blank!";			}	

	if (empty($_POST['course_branch_id']) ) {	$errors[]="Branch ID field can't be blank!";			}	

	if (empty($_POST['college_id']) ) 	{	$errors[]="College Name field can't be blank!";	}

	else

	{

		if (empty($_POST['course_id']) ) {	$errors[]="Course Name field can't be blank!";		}

	}

	

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

			

			$yearfolder = "../images/coursepic/".$year;

			$monthfolder = '../images/coursepic/'.$year.'/'.$month;

			$datefolder = '../images/coursepic/'.$year.'/'.$month.'/'.$date;

			

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

			

			$imgurl = 'images/coursepic/'.$year.'/'.$month.'/'.$date.'/';

		

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

				$yearfolder = "../images/coursepic/".$year;

				$monthfolder = '../images/coursepic/'.$year.'/'.$month;

				$datefolder = '../images/coursepic/'.$year.'/'.$month.'/'.$date;

				

				if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }

				if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }

				if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }

				

				$uploadfolder = $datefolder;

				$imgurl = 'images/coursepic/'.$year.'/'.$month.'/'.$date.'/';

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

			$update_query = "UPDATE `branch` SET `branchname` = '$title', `branch_short_name` = '$branch_short_name', `status` = '$status', `course_id` = '$course_id', `college_id` = '$college_id', `course_branch_id` = '$course_branch_id' WHERE `id`= '$post_id'";

			$update_result = $db->query($update_query);

			

			$msg_result='<div id="gt-formsuccess">Branch has been updated successfully.!</div>';			

		}

		else

		{			

			

			$update_query = "INSERT INTO `branch` (`id`, `branchname`, `branch_short_name`, `course_id`, `college_id`, `status`, `course_branch_id`, `add_date`) VALUES (NULL, '$title', '$branch_short_name', '$course_id', '$college_id', '$status', '$course_branch_id', '$gtcurrenttime')";

			$update_result = $db->query($update_query);

			

			$msg_result='<div id="gt-formsuccess">Branch has been added successfully.!</div>';

			

		}

		

		unset($_SESSION['myForm']);

	}

}



if(isset($_GET["fid"]))

{

$select_query = 'SELECT * FROM `branch` WHERE id = "'.$_GET["fid"].'"';

$select_result = $db->query($select_query);

$row = $select_result->row;



$_SESSION['myForm']['id'] = stripslashes($row['id']);

$_SESSION['myForm']['title'] = stripslashes($row['branchname']);

$_SESSION['myForm']['course_id'] = stripslashes($row['course_id']);

$_SESSION['myForm']['college_id'] = stripslashes($row['college_id']);

$_SESSION['myForm']['status'] = stripslashes($row['status']);

$_SESSION['myForm']['course_branch_id'] = stripslashes($row['course_branch_id']);
$_SESSION['myForm']['branch_short_name'] = stripslashes($row['branch_short_name']);




	$reg_title = 'Edit Branch';

	$reg_subtitle = 'Branch Edit Page';

	$reg_breadcrumb = 'Edit Branch';

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

                        <li><a href="<?php echo $baseurl; ?>master/branch-list.php"><i class="fa fa-leaf"></i> Branch List </a></li>

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

                                    <h3 class="box-title">Branch Details</h3>

                                </div><!-- /.box-header -->

                                <!-- form start -->

                                	<?php if(trim($row['id']) !="") { ?>

                                    	<input name="post_id" type="hidden" value="<?php echo $row['id']; ?>" />

                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['coursephoto']; ?>" />

                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />

                                    <?php } ?>

                                    <div class="box-body">

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Branch Name<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="title" placeholder="Branch Name" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Branch Sort Name<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="branch_short_name" placeholder="Branch Sort Name" id="branch_short_name" class="form-control" value="<?php echo $_SESSION['myForm']['branch_short_name']; ?>"></div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Branch ID<span class="error">*</span></label></div>

                                            <div class="col-md-10"><input type="text" name="course_branch_id" placeholder="Branch ID" id="course_branch_id" class="form-control" value="<?php echo $_SESSION['myForm']['course_branch_id']; ?>"></div>

                                        </div>

                                                                                

                                         <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">College </label></div>

                                            <div class="col-md-10"><?php echo togetcollegelistadmin('college_id', $_SESSION['myForm']['college_id'], 'onchange="javascript:togetcollegecourselist(this.value);"'); ?></div>

                                        </div>

                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Course </label></div>

                                            <div class="col-md-10"><div class="gt-courselist"><?php if($_SESSION['myForm']['college_id']!="") { echo togetcollegecourselist('course_id', $_SESSION['myForm']['course_id'], $_SESSION['myForm']['college_id'], $others=""); } ?></div></div>

                                        </div>

                                        

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputPassword1">Status</label></div>

                                            <div class="col-md-10"><input type="radio" name="status" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['status']=='1') { echo 'checked="checked"'; } ?>  /> Published &nbsp;&nbsp;&nbsp;&nbsp;

                                                  <input type="radio" name="status" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['status']=='0') { echo 'checked="checked"'; } ?>  />  Unpublished                                              

                                            </div>

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

                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='course-list.php'"> Back </button>

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