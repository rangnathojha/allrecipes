<?php include('header.php'); $gtpage = 'member-list'; $rwseditor=0;   checkadminroles('members');

$_SESSION['myForm']=array();

if(isset($_POST["rws-submit"]))
{
	if(empty($errors)) 
	{
			
			$status			= addslashes($_POST['status']);	
			
			$post_id	= $_POST["post_id"];

			/* Update Data To Database */
			
			$update_query = "UPDATE `ss_service_provider_bank_account_details` SET status = '$status' WHERE `service_provider_id`=".$post_id;

			$update_result = $db->query($update_query);	
			
			echo "<script>document.location.href='".$baseurl."master/member-sp-account-details.php?fid=".$post_id."'</script>";
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
	
	$select_query = 'SELECT * FROM `ss_service_provider_bank_account_details` WHERE service_provider_id = "'.$_GET["fid"].'"';
	$select_result = $db->query($select_query);
	
	$numrows=$select_result->num_rows;
	
	$rowup = $select_result->row;
	
	if(empty($_SESSION['myForm']))
	{
	
	$_SESSION['myForm']['firstname'] = stripslashes($rowut['firstname']);
	$_SESSION['myForm']['middlename'] = stripslashes($rowut['middlename']);
	$_SESSION['myForm']['lastname'] = stripslashes($rowut['lastname']);
	$_SESSION['myForm']['gender'] = stripslashes($rowut['gender']);
	
	$_SESSION['myForm']['accountname'] 			= stripslashes($rowup['accountname']);
	$_SESSION['myForm']['accountnubmer'] 		= stripslashes($rowup['accountnubmer']);
	$_SESSION['myForm']['ifsccode'] 			= stripslashes($rowup['ifsccode']);
	$_SESSION['myForm']['bankname'] 			= stripslashes($rowup['bankname']);
	$_SESSION['myForm']['bankaddress'] 			= stripslashes($rowup['bankaddress']);
	$_SESSION['myForm']['cancelchequephoto'] 	= stripslashes($rowup['cancelchequephoto']);
	$_SESSION['myForm']['status'] 				= stripslashes($rowup['status']);
	
	$reg_title = 'Member Account Details';
	$reg_subtitle = 'Member Account Details Page';
	$reg_breadcrumb = 'Member Account Details';
	$reg_button = 'Update';
	}
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

                                    <h3 class="box-title">Member Account Details</h3>

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
                                    <div class="clonedInput2" id="nameinput_new1">
        
                                        <div class="row rws-fields">
                                            <div class="col-sm-4">
                                                <strong>Name</strong><br/>
                                                <?php echo $_SESSION['myForm']["accountname"]; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Account Number</strong><br/>
                                                <?php echo $_SESSION['myForm']["accountnubmer"]; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>IFSC Code</strong><br/>
                                               <?php echo $_SESSION['myForm']["ifsccode"]; ?>
                                            </div>                
                                        </div>
                                        <div class="row rws-fields" style="margin-top:20px;">
                                            <div class="col-sm-4">
                                                <strong>Bank Name</strong><br/>
                                                <?php echo $_SESSION['myForm']["bankname"]; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Bank Address</strong><br/>
                                                <?php echo $_SESSION['myForm']["bankaddress"]; ?>
                                            </div>
                                            <div class="col-sm-4"><strong>Canceled Cheque</strong>               
                                              <?php if(!empty($_SESSION['myForm']['cancelchequephoto'])) { echo '<br/><a href="'.$baseurl.$_SESSION['myForm']['cancelchequephoto'].'" target="_blank">Click here to View</a>'; } ?>
                                            </div>                
                                        </div>
                                        
                                        
                                        <div class="row rws-fields" style="margin-top:20px;">
                                            <div class="col-sm-4"><strong>Status</strong></div>
                                            <div class="col-sm-8"><input name="status" id="status_1" type="radio" value="0" <?php if($_SESSION['myForm']['status']==0) { echo 'checked="checked"'; } ?> /> Pending &nbsp;&nbsp;&nbsp;&nbsp; <input name="status" id="status_2" type="radio" value="1" <?php if($_SESSION['myForm']['status']==1) { echo 'checked="checked"'; } ?> /> Approved &nbsp;&nbsp;&nbsp;&nbsp; <input name="status" id="status_3" type="radio" value="2" <?php if($_SESSION['myForm']['status']==2) { echo 'checked="checked"'; } ?> /> Disapproved  </div>             
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
										<?php echo '<button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href=\'member-list-sp.php\'"> Back </button>';										
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