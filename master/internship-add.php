<?php include('header.php'); $gtpage = 'group-list'; $rwseditor=1; $gtdateopt = "on";
$_SESSION['myForm']=array();
if(isset($_POST["rws-submit"]))
{
	$description				= addslashes($_POST["description"]);	
	
	$postdata = tocheckspam($_POST);
	$_SESSION['myForm'] = $postdata;	
	
	$title 					= addslashes($postdata["title"]);
	$company 				= addslashes($postdata["company"]);
	$location 				= addslashes($postdata["location"]);
	$stipend 				= addslashes($postdata["stipend"]);	
	$start_date 			= addslashes($postdata["start_date"]);
	$duration 				= addslashes($postdata["duration"]);
	$deadline 				= addslashes($postdata["deadline"]);
	$company_info 			= addslashes($postdata["company_info"]);
	$about_info 			= addslashes($postdata["about_info"]);
	
	$eligibility 			= $postdata["eligibility"];
	$additional_info 		= addslashes($postdata["additional_info"]);
	$googleform				= $postdata["googleform"];	
	$group_id				= '20';		  
	$post_id 				= $postdata["post_id"];
	$college_id 			= $postdata["college_id"];
	
	// Form Validation Code
	$errors = array(); //Initialize error array 
	//if (empty($_POST['title']) ) 		{	$errors[]="Title/Profile field can't be blank!";	 }
	if (empty($_POST['company']) ) 	{	$errors[]="Company Name field can't be blank!";		}	
	if (empty($_POST['college_id']) ) 	{	$errors[]="College Name field can't be blank!";		}
	if(empty($errors)) {	
		
	// UPLOAD FILE CODE STARTS 		
		if(trim($post_id)!="")
		{
			$update_query = "UPDATE `wall_in_for_pro_internship` SET `title` = '$title', `company` = '$company', `location` = '$location', `stipend` = '$stipend', `start_date` = '$start_date', `duration` = '$duration', `deadline` = '$deadline', `company_info` = '$company_info', `about_info` = '$about_info', `eligibility` = '$eligibility', `additional_info` = '$additional_info', `googleform` = '$googleform', `group_id` = '$group_id', `college_id` = '$college_id'  WHERE `id`= '$post_id'";  
			$update_result = $db->query($update_query);
			// Insert Category
			/*$update_querycat = $db->query("DELETE FROM `groups_college` WHERE `group_id`='$post_id'");
			foreach($_POST["college_id"] as $key=>$val)
			{
				$update_querycat = $db->query("INSERT INTO `groups_college` (`group_id`, `college_id`) VALUES ('$post_id', '$val')");
			}*/
			
			$update_query = "UPDATE `wall` SET `college_id` = '$college_id'  WHERE `wall_id`= '$post_id' AND `datatype= '12'";  
			$update_result = $db->query($update_query);
			
			$msg_result='<div id="gt-formsuccess">Internship has been updated successfully.!</div>';			
		}
		else
		{			
$update_query = "INSERT INTO `wall_in_for_pro_internship` (`id`, `title`, `company`, `location`, `stipend`, `start_date`, `duration`, `deadline`, `company_info`, `about_info`, `eligibility`, `additional_info`, `googleform`, `group_id`, `created_date`, `college_id`) VALUES (NULL, '$title', '$company', '$location', '$stipend', '$start_date', '$duration', '$deadline', '$company_info', '$about_info', '$eligibility', '$additional_info', '$googleform', '$group_id', '$gtcurrenttime', '$college_id')";
		$update_result = $db->query($update_query);
			$wall_id = $db->getLastId();
			/*foreach($_POST["college_id"] as $key=>$val)
			{
				$update_querycat = $db->query("INSERT INTO `groups_college` (`group_id`, `college_id`) VALUES ('$group_id', '$val')");
			}*/
			
			$query_insert = "INSERT INTO `wall` (`id`, `wall_id`, `datatype`, `user_id`, `college_id`, `course_id`, `branch_id`, `group_id`, `group_type`, `created_date`, `reach_alumni_advice_new`, `heading`, `grouptable`) VALUES (NULL, '$wall_id', '12', '0', '$college_id', '0', '0', '$group_id', 'Admin_default_New', '$gtcurrenttime', '$reach_alumni_advice_new', '$heading', '1')";
		$update_result = $db->query($query_insert);
			
			$msg_result='<div id="gt-formsuccess">Internship has been added successfully.!</div>';
		}
		unset($_SESSION['myForm']);
	}
}

if(isset($_GET["fid"]))
{
$select_query = 'SELECT * FROM `wall_in_for_pro_internship` WHERE id = "'.$_GET["fid"].'"';
$select_result = $db->query($select_query);
$row = $select_result->row;

$_SESSION['myForm']['id'] = stripslashes($row['id']);
$_SESSION['myForm']['title'] = stripslashes($row['title']);
$_SESSION['myForm']['company'] = stripslashes($row['company']);
$_SESSION['myForm']['location'] = stripslashes($row['location']);
$_SESSION['myForm']['stipend'] = stripslashes($row['stipend']);
$_SESSION['myForm']['start_date'] = stripslashes($row['start_date']);
$_SESSION['myForm']['duration'] = stripslashes($row['duration']);
$_SESSION['myForm']['deadline'] = stripslashes($row['deadline']);
$_SESSION['myForm']['company_info'] = stripslashes($row['company_info']);
$_SESSION['myForm']['about_info'] = stripslashes($row['about_info']);
$_SESSION['myForm']['eligibility'] = stripslashes($row['eligibility']);
$_SESSION['myForm']['additional_info'] = stripslashes($row['additional_info']);
$_SESSION['myForm']['googleform'] = stripslashes($row['googleform']);
$_SESSION['myForm']['group_id'] = stripslashes($row['group_id']);
$_SESSION['myForm']['college_id'] = stripslashes($row['college_id']);

	$reg_title = 'Edit Internship';
	$reg_subtitle = 'Internship Edit Page';
	$reg_breadcrumb = 'Edit Internship';
	$reg_button = 'Update';

}
else
{	
	$reg_title = 'Add New Internship';
	$reg_subtitle = 'Internship Add Page';
	$reg_breadcrumb = 'Add New Internship';
	$reg_button = 'Save';
	
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
                                    <h3 class="box-title">Internship Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<?php if(trim($row['id']) !="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $row['id']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['groupimage']; ?>" />
                        				<input name="uploadfolder" type="hidden" value="<?php echo $_SESSION['myForm']['imgurl']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Title<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="title" placeholder="Title" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>"></div>
                                        </div>
                                        
                                       <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Company<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="company" placeholder="Company" id="company" class="form-control" value="<?php echo $_SESSION['myForm']['company']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Location<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="location" placeholder="Location" id="location" class="form-control" value="<?php echo $_SESSION['myForm']['location']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Stipend<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="stipend" placeholder="Stipend" id="stipend" class="form-control" value="<?php echo $_SESSION['myForm']['stipend']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Start Date<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="start_date" placeholder="Start Date" id="start_date" class="form-control gtdatedropdown" value="<?php echo $_SESSION['myForm']['start_date']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Duration<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="duration" placeholder="Duration" id="duration" class="form-control " value="<?php echo $_SESSION['myForm']['duration']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Application Deadline<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="deadline" placeholder="Application Deadline" id="deadline" class="form-control gtdatedropdown" value="<?php echo $_SESSION['myForm']['deadline']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Google Form Link<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="googleform" placeholder="Google Form Link" id="googleform" class="form-control " value="<?php echo $_SESSION['myForm']['googleform']; ?>"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">College<span class="error">*</span></label></div>
                                            <div class="col-md-10"><?php  echo togetcollegelistadmin('college_id', $_SESSION['myForm']['college_id'], ''); //echo togetcollegelistmultiple('college_id', $_SESSION['myForm']['college_id'], $others=""); ?></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Company info<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                              <textarea name="company_info" class="form-control" id="company_info" placeholder="Company info"><?php echo $_SESSION['myForm']['company_info']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Additional Info<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                              <textarea name="additional_info" class="form-control" id="additional_info" placeholder="Additional Info"><?php echo $_SESSION['myForm']['additional_info']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Who can apply<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                              <textarea name="eligibility" class="form-control" id="eligibility" placeholder="Who can apply"><?php echo $_SESSION['myForm']['eligibility']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">About the internship<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                              <textarea name="about_info" class="form-control" id="about_info" placeholder="About the internship"><?php echo $_SESSION['myForm']['about_info']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                                                                
                                        <!--<div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">About the internship</label></div>
                                            <div class="col-md-10"><textarea name="about_info" cols="80" rows="10" id="rwscontenteditor" placeholder="About the internship....."><?php echo $_SESSION['myForm']['about_info']; ?></textarea>                                                                               
                                            </div>
                                        </div>
                                        -->
                                                                             
                                        
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