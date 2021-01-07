<?php include('header.php'); $gtpage = 'change-password'; 
$_SESSION['myForm']=array();
if(isset($_POST["rws-submit"]))
{
	
	$_SESSION['myForm'] = $_POST;

	$newpassword = md5($_POST["newpassword"]);
	
	// Form Validation Code
	$errors = array(); //Initialize error array 
	
	if (empty($_POST['oldpassword']) ) {$errors[]="Old Password field can't be blank!";}
	else { if(tocheckoldpwd($_POST['oldpassword'], $_SESSION['GTadminuserID'])!=1) { $errors[]='Old Password does not match with our database. Please try once again!'; } }
	
	if (empty($_POST['newpassword']) ) {$errors[]="New Password  field can't be blank!";}
	 else { if(strlen($_POST['newpassword']) < 6) { $errors[]='Minimum password length is 6 characters!'; } }	
	
	if (empty($_POST['cnewpassword']) ) {$errors[]="Confirm New Password field can't be blank!";}
	
	if($_POST['newpassword'] != $_POST['cnewpassword'] ) { $errors[]='New Password does not matches with Confirm New Password!'; }	
	
	if(empty($errors)) {
	
	$update_query = "UPDATE `ss_adminuser` SET `password` = '$newpassword' WHERE `user_id`=".$_SESSION['GTadminuserID'];
		$result = $db->query($update_query);
		
	$msg_result='<div id="gt-formsuccess">Password has been updated successfully!</div>';
	
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
                        Change Password
                        <small>Your Login Password Change</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Change Password</li>
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
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <div class="col-md-4"><label for="exampleInputEmail1">Old Password<span class="error">*</span></label></div>
                                            <div class="col-md-4"><input type="password" name="oldpassword" placeholder="Enter Old Password" id="oldpassword" class="form-control" value="" autocomplete="off"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4"><label for="exampleInputPassword1">New Password<span class="error">*</span></label></div>
                                            <div class="col-md-4"><input type="password" name="newpassword" placeholder="Enter New Password" id="newpassword" class="form-control" value="" autocomplete="off"></div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4"><label for="exampleInputFile">Confirm New Password<span class="error">*</span></label></div>
                                           <div class="col-md-4"><input type="password" name="cnewpassword" placeholder="Enter New Password" id="cnewpassword" class="form-control" value="" autocomplete="off"></div>
                                        </div>                                        
                                        
                                    </div><!-- /.box-body -->                                    
                                
                            </div>
                        </div>                        
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-footer" style="text-align:center">
                                                <button class="btn btn-primary" type="submit" name="rws-submit"> Save </button>
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