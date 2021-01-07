<?php include('header.php'); $gtpage = 'group-category-list'; $rwseditor=1;
$_SESSION['myForm']=array();
if(isset($_POST["rws-submit"]))
{
	$postdata = tocheckspam($_POST);
	
	$_SESSION['myForm'] = $postdata;
	

	$title 						= addslashes($postdata["title"]);
	$group_type 				= addslashes($postdata["group_type"]);	
	$college_id 				= addslashes($postdata["college_id"]);
	$status 					= addslashes($postdata["status"]);	
	$default 					= addslashes($postdata["default"]);	
	$groupuser 					= addslashes($postdata["groupuser"]);	
	$post_id 					= $postdata["post_id"];
	$showinalumni 				= $postdata["showinalumni"];
	$nameinalumnisection 		= addslashes($postdata["nameinalumnisection"]);
	// Form Validation Code
	$errors = array(); //Initialize error array 
	
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
	
	if (empty($_POST['title']) ) 		{	$errors[]="Group Category Name field can't be blank!";	 }
	if (empty($_POST['college_id']) ) 	{	$errors[]="College Name field can't be blank!";		}
	
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
			
			$yearfolder = "../images/groupcatimg/".$year;
			$monthfolder = '../images/groupcatimg/'.$year.'/'.$month;
			$datefolder = '../images/groupcatimg/'.$year.'/'.$month.'/'.$date;
			
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
			
			$imgurl = 'images/groupcatimg/'.$year.'/'.$month.'/'.$date.'/';
		
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
				$yearfolder = "../images/groupcatimg/".$year;
				$monthfolder = '../images/groupcatimg/'.$year.'/'.$month;
				$datefolder = '../images/groupcatimg/'.$year.'/'.$month.'/'.$date;
				
				if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }
				if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }
				if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }
				
				$uploadfolder = $datefolder;
				$imgurl = 'images/groupcatimg/'.$year.'/'.$month.'/'.$date.'/';
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
		
		$college_id_insert = implode(',',$_POST["college_id"]);
		if(trim($post_id)!="")
		{
			$update_query = "UPDATE `group_categories` SET `name` = '$title', `default` = '$default', `group_cat_img`='".$imageuploadname[1]."', `groupuser` = '$groupuser', `status` = '$status', `imgurl` = '$imgurl', `group_type` = '$group_type', `college_id` = '$college_id_insert', `showinalumni` = '$showinalumni', `nameinalumnisection` = '$nameinalumnisection' WHERE `id`= '$post_id'";
			$update_result = $db->query($update_query);
			
			// Insert Category
			$update_querycat = $db->query("DELETE FROM `group_category_college` WHERE `group_catid`='$post_id'");
			foreach($_POST["college_id"] as $key=>$val)
			{
				$update_querycat = $db->query("INSERT INTO `group_category_college` (`group_catid`, `college_id`) VALUES ('$post_id', '$val')");
			}
			$msg_result='<div id="gt-formsuccess">Group Category has been updated successfully.!</div>';			
		}
		else
		{			
			
			$update_query = "INSERT INTO `group_categories` (`id`, `name`, `group_type`, `group_cat_img`, `imgurl`, `college_id`, `status`, `default`, `groupuser`, `created_date`, `showinalumni`, `nameinalumnisection`) VALUES (NULL, '$title', '$group_type', '".$imageuploadname[1]."', '$imgurl', '$college_id_insert', '$status', '$default', '$groupuser', '$gtcurrenttime', '$showinalumni','$nameinalumnisection')";
			$update_result = $db->query($update_query);
			
			$group_catid = $db->getLastId();
			
			foreach($_POST["college_id"] as $key=>$val)
			{
				$update_querycat = $db->query("INSERT INTO `group_category_college` (`group_catid`, `college_id`) VALUES ('$group_catid', '$val')");
			}
			
			$msg_result='<div id="gt-formsuccess">Group Category has been added successfully.!</div>';
		}

		unset($_SESSION['myForm']);
	}
}

if(isset($_GET["fid"]))
{
$select_query = 'SELECT * FROM `group_categories` WHERE id = "'.$_GET["fid"].'"';
$select_result = $db->query($select_query);
$row = $select_result->row;


$_SESSION['myForm']['id'] = stripslashes($row['id']);
$_SESSION['myForm']['title'] = stripslashes($row['name']);
$_SESSION['myForm']['group_type'] = stripslashes($row['group_type']);
$_SESSION['myForm']['college_id'] = explode(',',$row['college_id']);
$_SESSION['myForm']['status'] = stripslashes($row['status']);
$_SESSION['myForm']['default'] = stripslashes($row['default']);
$_SESSION['myForm']['groupuser'] = stripslashes($row['groupuser']);

$_SESSION['myForm']['group_cat_img'] = stripslashes($row['group_cat_img']);
$_SESSION['myForm']['imgurl'] = stripslashes($row['imgurl']);
$_SESSION['myForm']['group_type'] = stripslashes($row['group_type']);

$_SESSION['myForm']['showinalumni'] = stripslashes($row['showinalumni']);
$_SESSION['myForm']['nameinalumnisection'] = stripslashes($row['nameinalumnisection']);

	$reg_title = 'Edit Group Category';
	$reg_subtitle = 'Group Category Edit Page';
	$reg_breadcrumb = 'Edit Group Category';
	$reg_button = 'Update';

}
else
{	
	$reg_title = 'Add New Group Category';
	$reg_subtitle = 'Group Category Add Page';
	$reg_breadcrumb = 'Add New Group Category';
	$reg_button = 'Save';
	if($_SESSION['myForm']['status']=="")
	{
		$_SESSION['myForm']['status'] = '1';
	}	
	if($_SESSION['myForm']['group_type']=="")
	{
		$_SESSION['myForm']['group_type'] = 'D';
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
                        <li><a href="<?php echo $baseurl; ?>master/group-category-list.php"><i class="fa fa-leaf"></i> Group Category List </a></li>
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
                                    <h3 class="box-title">Group Category Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<?php if(trim($row['id']) !="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $row['id']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['group_cat_img']; ?>" />
                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Group Category Name<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="title" placeholder="Group Category Name" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Group Category Thumb</label></div>
                                            <div class="col-md-10">
                                            	<input name="image_1" id="image_1" type="file" /><br />
												<span class="error">(Image type should be <strong>jpg</strong> and maximum size will be <strong>1024 kb</strong> only. )</span><br />
												<?php if(trim($row['id']) !="") { if($row['group_cat_img']!="") { ?><a href="<?php echo $baseurl.$_SESSION['myForm']['imgurl'].$_SESSION['myForm']['group_cat_img']; ?>" title="View Group Thurm Pic" target="_blank">View Group Thurm Pic</a><?php } else { echo "<strong>No group thumb pic added yet!</strong>"; } }?>
                                             </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">College<span class="error">*</span></label></div>
                                            <div class="col-md-10"><?php echo togetcollegelistmultiple('college_id', $_SESSION['myForm']['college_id'], $others=""); ?></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Status</label></div>
                                            <div class="col-md-10"><input type="radio" name="status" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['status']=='1') { echo 'checked="checked"'; } ?>  /> Published &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="status" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['status']=='0') { echo 'checked="checked"'; } ?>  />  Unpublished                                              
                                            </div>
                                        </div>   
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Show in alumni Secton</label></div>
                                            <div class="col-md-10"><input type="radio" name="showinalumni" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['showinalumni']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="showinalumni" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['showinalumni']=='0') { echo 'checked="checked"'; } ?>  />  No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                              
                                                  if Yes Enter Name <input name="nameinalumnisection" value="<?php echo $_SESSION['myForm']['nameinalumnisection']; ?>" type="text" />
                                            </div>
                                        </div>  
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Default Group</label></div>
                                            <div class="col-md-10"><input type="radio" name="default" value="1" id="RadioGroup2_0" <?php if($_SESSION['myForm']['default']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="default" value="0" id="RadioGroup2_1" <?php if($_SESSION['myForm']['default']=='0') { echo 'checked="checked"'; } ?>  />  No                                              
                                            </div>
                                        </div>  
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Group User</label></div>
                                            <div class="col-md-10"><input type="radio" name="groupuser" value="S" id="RadioGroup3_0" <?php if($_SESSION['myForm']['groupuser']=='S') { echo 'checked="checked"'; } ?>  /> Student &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="groupuser" value="A" id="RadioGroup3_1" <?php if($_SESSION['myForm']['groupuser']=='A') { echo 'checked="checked"'; } ?>  />  Alumni     &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="groupuser" value="B" id="RadioGroup3_2" <?php if($_SESSION['myForm']['groupuser']=='B') { echo 'checked="checked"'; } ?>  />  Both                                             
                                            </div>
                                        </div>     
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Group Type</label></div>
                                            <div class="col-md-10"><input type="radio" name="group_type" value="D" id="RadioGroup4_0" <?php if($_SESSION['myForm']['group_type']=='D') { echo 'checked="checked"'; } ?>  /> Default &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="group_type" value="I" id="RadioGroup4_1" <?php if($_SESSION['myForm']['group_type']=='I') { echo 'checked="checked"'; } ?>  />  Intra-College     &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="group_type" value="S" id="RadioGroup4_2" <?php if($_SESSION['myForm']['group_type']=='S') { echo 'checked="checked"'; } ?>  />  Secret     &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="group_type" value="AD" id="RadioGroup4_3" <?php if($_SESSION['myForm']['group_type']=='AD') { echo 'checked="checked"'; } ?>  />  Admin Default User Group                                            
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
                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='group-category-list.php'"> Back </button>
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