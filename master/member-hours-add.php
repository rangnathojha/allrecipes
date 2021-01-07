<?php include('header.php'); $gtpage = 'services-list'; $rwseditor=0; $gtdateopt="on";   checkadminroles('members');

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
	$parent_id 					= addslashes($_POST["parent_id"]);	
	$status 					= addslashes($_POST["status"]);	
	$post_id 					= $_POST["post_id"];
	
	$service_description		= $_POST["service_description"];
	
	

	// Form Validation Code

	$errors = array(); //Initialize error array 

	if (empty($_POST['days'])) {	$errors[]="Day field can't be blank!";		}
	if (empty($_POST['start_time']) ){	$errors[]="Start Time field can't be blank!";		}
	if (empty($_POST['end_time']) )	{	$errors[]="End Time field can't be blank!";		}

	if(empty($errors)) {		
		
		$days = $_POST["days"];
		$start_time = $_POST["start_time"];
		$end_time = $_POST["end_time"];
		$user_id = $_POST["user_id"];
		
		if(trim($post_id)!="")
		{
			$update_query = "UPDATE `ss_service_provider_availability` SET user_id='".$user_id."', day = '$days', start_time = '".$start_time."', end_time = '".$end_time."', status = '1' WHERE `service_provider_availablity_id`= '$post_id'";

			$update_result = $db->query($update_query);		

			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Service Provoider Availability has been updated successfully.!</div>';	
		}
		else
		{
			$update_query = "INSERT INTO `ss_service_provider_availability` SET user_id='".$user_id."', day = '$days', start_time = '".$start_time."', end_time = '".$end_time."', status = '1', add_date = '$gtcurrenttime'";

			$update_result = $db->query($update_query);
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Service Provoider Availability has been added successfully.!</div>';

		}
		unset($_SESSION['myForm']);
		
	}
	echo "<script>document.location.href='member-edit.php?fid=".$user_id."&back=sp'</script>";	
}

if(isset($_GET["fid"]))
{
$select_query = 'SELECT * FROM `ss_service_provider_availability` WHERE service_provider_availablity_id = "'.$_GET["fid"].'"';
$select_result = $db->query($select_query);
$row = $select_result->row;

$_SESSION['myForm']['day'] 			= stripslashes($row['day']);
$_SESSION['myForm']['start_time'] 	= stripslashes($row['start_time']);
$_SESSION['myForm']['end_time'] 	= stripslashes($row['end_time']);
$_SESSION['myForm']['status'] 		= stripslashes($row['status']);
$_SESSION['myForm']['user_id'] 		= stripslashes($row['user_id']);

	$reg_title = 'Edit Service Provoider Availability';
	$reg_subtitle = 'Service Provoider Availability Edit Page';
	$reg_breadcrumb = 'Edit Service Provoider Availability';
	$reg_button = 'Update';
}
else
{	
	$reg_title = 'Add New Service Provoider Availability';
	$reg_subtitle = 'Service Provoider Availability Add Page';
	$reg_breadcrumb = 'Add New Service Provoider Availability';
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
                        <li><a href="<?php echo $baseurl; ?>master/member-edit.php?fid=<?php echo $_GET["user_id"]; ?>&back=sp"><i class="fa fa-leaf"></i> Member Details </a></li>
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

                                    <h3 class="box-title">Hours Details</h3>

                                </div><!-- /.box-header -->

                                <!-- form start -->
                                	<?php if($_GET['fid']!="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $_GET['fid']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['service_image']; ?>" />
                                    <?php } ?>
                                    <input name="user_id" type="hidden" value="<?php echo $_GET['user_id']; ?>" />
                                    <div class="box-body">

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Day<span class="error">*</span></label></div>
                                            <div class="col-md-10"><?php echo todisplay($array_daysnew, 'days', "Day", $_SESSION['myForm']['day'], $onchange=""); ?></div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Start Time<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                                <?php echo todisplay($array_timeslot, 'start_time', "Start Time", $_SESSION['myForm']['start_time'], $onchange=""); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">End Time</label></div>
                                            <div class="col-md-10">
                                            <?php echo todisplay($array_timeslot, 'end_time', "End Time", $_SESSION['myForm']['end_time'], $onchange=""); ?>
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

                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='member-edit.php?fid=<?php echo $_GET["user_id"]; ?>&back=sp'"> Back </button>

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