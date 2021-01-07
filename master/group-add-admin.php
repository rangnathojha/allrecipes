<?php include('header.php'); $gtpage = 'group-list'; $rwseditor=1;
error_reporting('E_WARNING & E_NOTICE');
$_SESSION['myForm']=array();
function tocreatefolderifnotexistsforimages($path)
{
	$path = explode('/',$path);
	$yearfolder = "../images/groupcoverpic/";
	$yearfolder = "../images/groupcoverpic/".$path[2];
 	$monthfolder = '../images/groupcoverpic/'.$path[2].'/'.$path[3];
	$datefolder = '../images/groupcoverpic/'.$path[2].'/'.$path[3].'/'.$path[4];
	if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }
	if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }
	if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html');}
}
if(isset($_POST["rws-submit"]))
{
	$description				= addslashes($_POST["description"]);	
	
	$postdata = tocheckspam($_POST);
	$_SESSION['myForm'] = $postdata;	
	$_SESSION['myForm']["description"] = $description;
	
	$title 						= addslashes($postdata["title"]);
	$group_catid 				= addslashes($postdata["group_catid"]);
	$college_id 				= addslashes($postdata["college_id"]);
	$status 					= addslashes($postdata["status"]);	
	$groupuser 					= addslashes($postdata["groupuser"]);
	$college 					= addslashes($postdata["college"]);
	$course 					= addslashes($postdata["course"]);
	$branch 					= addslashes($postdata["branch"]);
	$year 						= addslashes($postdata["year"]);
	
	$showinalumni 				= $postdata["showinalumni"];
	$nameinalumnisection 		= addslashes($postdata["nameinalumnisection"]);
	$askbrachname				= $postdata["askbrachname"];	
	
	$extra_field_alumni_news_type_heading				= $postdata["extra_field_alumni_news_type_heading"];		  
				
	$post_id 					= $postdata["post_id"];
	// Form Validation Code
	$errors = array(); //Initialize error array 
	if (empty($_POST['title']) ) 		{	$errors[]="Group Name field can't be blank!";	 }
	//if (empty($_POST['group_catid']) ) 	{	$errors[]="Group Category Name field can't be blank!";		}	
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
			$yearfolder = "../images/groupcoverpic/".$year;
			$monthfolder = '../images/groupcoverpic/'.$year.'/'.$month;
			$datefolder = '../images/groupcoverpic/'.$year.'/'.$month.'/'.$date;
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
			$imgurl = 'images/groupcoverpic/'.$year.'/'.$month.'/'.$date.'/';
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
				$yearfolder = "../images/groupcoverpic/".$year;
				$monthfolder = '../images/groupcoverpic/'.$year.'/'.$month;
				$datefolder = '../images/groupcoverpic/'.$year.'/'.$month.'/'.$date;
				if (!file_exists($yearfolder)) { mkdir("$yearfolder", 0777); copy('../images/index.html', $yearfolder.'/index.html'); }
				if (!file_exists($monthfolder)) { mkdir("$monthfolder", 0777); copy('../images/index.html', $monthfolder.'/index.html'); }
				if (!file_exists($datefolder)) { mkdir("$datefolder", 0777); copy('../images/index.html', $datefolder.'/index.html'); }
				$uploadfolder = $datefolder;
				$imgurl = 'images/groupcoverpic/'.$year.'/'.$month.'/'.$date.'/';
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
		$group_catid_insert = '';
		if(trim($post_id)!="")
		{
			tocreatefolderifnotexistsforimages($imgurl);
			$update_query = "UPDATE `groups_dummy` SET `name` = '$title', `status` = '$status', `groupuser` = '$groupuser', `college` = '$college', `course` = '$course', `branch` = '$branch', `year` = '$year', `description` = '$description', `groupimage` = '".$imageuploadname[1]."', `imgurl` = '$imgurl', `group_catid` = '$group_catid_insert', `college_id` = '$college_id_insert', `showinalumni` = '$showinalumni', `nameinalumnisection` = '$nameinalumnisection', `askbrachname` = '$askbrachname',`extra_field_alumni_news_type_heading` = '$extra_field_alumni_news_type_heading' WHERE `id`= '$post_id'";  
			$update_result = $db->query($update_query);
			$msg_result='<div id="gt-formsuccess">Group has been updated successfully.!</div>';			
		}
		else
		{			
$update_query = "INSERT INTO `groups_dummy` (`id`, `name`, `group_catid`, `college_id`, `status`, `groupuser`, `college`, `course`, `branch`, `year`, `description`, `groupimage`, `createdby`, `imgurl`, `created_date`, `showinalumni`, `nameinalumnisection`, `askbrachname`,`extra_field_alumni_news_type_heading`) VALUES (NULL, '$title', '$group_catid_insert', '$college_id_insert', '$status', '$groupuser', '$college', '$course', '$branch', '$year', '$description', '".$imageuploadname[1]."', 'A', '$imgurl', '$gtcurrenttime', '$showinalumni','$nameinalumnisection','$askbrachname','$extra_field_alumni_news_type_heading')";
			$update_result = $db->query($update_query);
			$group_id = $db->getLastId();
			$msg_result='<div id="gt-formsuccess">Group has been added successfully.!</div>';
		}
		unset($_SESSION['myForm']);
	}
}

if(isset($_GET["fid"]))
{
$select_query = 'SELECT * FROM `groups_dummy` WHERE id = "'.$_GET["fid"].'"';
$select_result = $db->query($select_query);
$row = $select_result->row;

$_SESSION['myForm']['id'] = stripslashes($row['id']);
$_SESSION['myForm']['title'] = stripslashes($row['name']);
$_SESSION['myForm']['group_type'] = stripslashes($row['group_type']);
$_SESSION['myForm']['college_id'] = explode(',',$row['college_id']);
$_SESSION['myForm']['group_catid'] = explode(',',$row['group_catid']);
$_SESSION['myForm']['groupuser'] = stripslashes($row['groupuser']);
$_SESSION['myForm']['college'] = stripslashes($row['college']);
$_SESSION['myForm']['course'] = stripslashes($row['course']);
$_SESSION['myForm']['branch'] = stripslashes($row['branch']);
$_SESSION['myForm']['year'] = stripslashes($row['year']);
$_SESSION['myForm']['description'] = stripslashes($row['description']);
$_SESSION['myForm']['groupimage'] = stripslashes($row['groupimage']);
$_SESSION['myForm']['imgurl'] = stripslashes($row['imgurl']);
$_SESSION['myForm']['status'] = stripslashes($row['status']);

$_SESSION['myForm']['extra_field_alumni_news_type_heading'] = stripslashes($row['extra_field_alumni_news_type_heading']);
$_SESSION['myForm']['showinalumni'] = stripslashes($row['showinalumni']);
$_SESSION['myForm']['nameinalumnisection'] = stripslashes($row['nameinalumnisection']);
$_SESSION['myForm']['askbrachname'] = stripslashes($row['askbrachname']);


	$reg_title = 'Edit Group';
	$reg_subtitle = 'Group Edit Page';
	$reg_breadcrumb = 'Edit Group';
	$reg_button = 'Update';

}
else
{	
	$reg_title = 'Add New Group';
	$reg_subtitle = 'Group Add Page';
	$reg_breadcrumb = 'Add New Group';
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
                        <li><a href="<?php echo $baseurl; ?>master/group-list.php"><i class="fa fa-leaf"></i> Group List </a></li>
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
                                    <h3 class="box-title">Group Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<?php if(trim($row['id']) !="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $row['id']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['groupimage']; ?>" />
                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Group Name<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="title" placeholder="Group Name" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Group Cover Pic</label></div>
                                            <div class="col-md-10">
                                            	<input name="image_1" id="image_1" type="file" /><br />
												<span class="error">(Image type should be <strong>jpg</strong> and maximum size will be <strong>1024 kb</strong> only. )</span><br />
												<?php if(trim($row['id']) !="") { if($row['groupimage']!="") { ?><a href="<?php echo $baseurl.$_SESSION['myForm']['imgurl'].$_SESSION['myForm']['groupimage']; ?>" title="View Group Cover Pic" target="_blank">View Group Cover Pic</a><?php } else { echo "<strong>No Group Cover Pic  added yet!</strong>"; } }?>
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
                                            <div class="col-md-2">
                                              <label for="exampleInputPassword1">Tell Me:</label></div>
                                            <div class="col-md-10"><input type="radio" name="askbrachname" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['askbrachname']=='1') { echo 'checked="checked"'; } ?>  />Notice
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="askbrachname" value="2" id="RadioGroup1_0" <?php if($_SESSION['myForm']['askbrachname']=='2') { echo 'checked="checked"'; } ?>  />College Highlights
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="askbrachname" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['askbrachname']=='0') { echo 'checked="checked"'; } ?>  /> Directory&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                              
                                            </div>
                                        </div> 
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Extra Field on Wall</label></div>
                                            <div class="col-md-10"><input type="radio" name="extra_field_alumni_news_type_heading" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['extra_field_alumni_news_type_heading']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="extra_field_alumni_news_type_heading" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['extra_field_alumni_news_type_heading']=='0') { echo 'checked="checked"'; } ?>  />  No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                              
                                            </div>
                                        </div> 
                                        

                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">College</label></div>
                                            <div class="col-md-10"><input type="radio" name="college" value="1" <?php if($_SESSION['myForm']['college']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="college" value="0" <?php if($_SESSION['myForm']['college']=='0') { echo 'checked="checked"'; } ?>  />  No                                              
                                            </div>
                                        </div>  
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Course</label></div>
                                            <div class="col-md-10"><input type="radio" name="course" value="1" <?php if($_SESSION['myForm']['course']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="course" value="0" <?php if($_SESSION['myForm']['course']=='0') { echo 'checked="checked"'; } ?>  />  No                                              
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Branch</label></div>
                                            <div class="col-md-10"><input type="radio" name="branch" value="1" <?php if($_SESSION['myForm']['branch']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="branch" value="0" <?php if($_SESSION['myForm']['branch']=='0') { echo 'checked="checked"'; } ?>  />  No                                              
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Year</label></div>
                                            <div class="col-md-10"><input type="radio" name="year" value="1" <?php if($_SESSION['myForm']['year']=='1') { echo 'checked="checked"'; } ?>  /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="year" value="0" <?php if($_SESSION['myForm']['year']=='0') { echo 'checked="checked"'; } ?>  />  No                                              
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
                                            <div class="col-md-2"><label for="exampleInputPassword1">About Group</label></div>
                                            <div class="col-md-10"><textarea name="description" cols="80" rows="10" id="rwscontenteditor" placeholder="About Group....."><?php echo $_SESSION['myForm']['description']; ?></textarea>                                                                               
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