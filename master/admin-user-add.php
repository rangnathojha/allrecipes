<?php include('header.php'); $gtpage = 'services-list'; $rwseditor=0; $gtdateopt="on";   checkadminroles('admin_users');

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

	$user_group_id 				= addslashes($_POST["user_group_id"]);
	$username					= addslashes($_POST["username"]);	
	$password					= md5($_POST["password"]);
	$firstname					= addslashes($_POST["firstname"]);
	$lastname			 		= addslashes($_POST["lastname"]);
	$email						= addslashes($_POST["username"]);
	$status 					= addslashes($_POST["status"]);	
	$post_id 					= $_POST["post_id"];
	
	

	// Form Validation Code

	$errors = array(); //Initialize error array 

	if (empty($_POST['user_group_id']) ) 		{	$errors[]="User role field can't be blank!";			}
	if (empty($_POST['firstname']) ) 		{	$errors[]="First name field can't be blank!";			}
	if (empty($_POST['lastname']) ) 		{	$errors[]="Last Name field can't be blank!";			}
	if (empty($_POST['username']) ) 		{	$errors[]="User Name field can't be blank!";			}
	
	if(empty($post_id))        	
	
	{
	if (empty($_POST['password']) ) 		{	$errors[]="Password field can't be blank!";			}
	}
	

	if(empty($errors)) {		
		
		$user_group_name = togetfieldvalue('name', 'ss_adminuser_groups', " user_group_id=".$_POST["user_group_id"]);

		if(trim($post_id)!="")
		{
			if(empty($post_id)) 
			{
			$update_query = "UPDATE `ss_adminuser` SET `user_group_id` = '$user_group_id', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname', `username` = '$username', `status` = '$status', `user_group_name` = '$user_group_name' WHERE `user_id`= '$post_id'";
			}
			else{
				$update_query = "UPDATE `ss_adminuser` SET `user_group_id` = '$user_group_id', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname', `username` = '$username', `password` = '$password', `status` = '$status', `user_group_name` = '$user_group_name' WHERE `user_id`= '$post_id'";
				}
			$update_result = $db->query($update_query);		

			$msg_result='<div id="gt-formsuccess">Admin User has been updated successfully.!</div>';	
			
			unset($_SESSION['myForm']);
			
		}
		else
		{
			if(isUnique("email", $_POST['username'], "ss_adminuser"))
			{
				
			$update_query = "INSERT INTO `ss_adminuser` SET `user_group_id` = '$user_group_id', `firstname` = '$firstname', `email` = '$email', `lastname` = '$lastname', `username` = '$username', `password` = '$password', `status` = '$status', `user_group_name` = '$user_group_name', `date_added` = NOW()";

			$update_result = $db->query($update_query);
			$msg_result='<div id="gt-formsuccess">Admin User has been added successfully.!</div>';
			
			unset($_SESSION['myForm']);
			
			}
			else{
				$msg_result ='<div id="gt-formfeedback">Email ID already exists to our database. Please use another email id for registration. </div>';
			}

		}
		
	}
}

if(isset($_GET["fid"]))
{
$select_query = 'SELECT * FROM `ss_adminuser` WHERE user_id = "'.$_GET["fid"].'"';
$select_result = $db->query($select_query);
$row = $select_result->row;

$_SESSION['myForm']['user_group_id'] 	= stripslashes($row['user_group_id']);
$_SESSION['myForm']['firstname'] 		= stripslashes($row['firstname']);
$_SESSION['myForm']['lastname'] 	= stripslashes($row['lastname']);
$_SESSION['myForm']['status'] 		= stripslashes($row['status']);
$_SESSION['myForm']['username'] 		= stripslashes($row['username']);


	$reg_title = 'Edit Admin User';
	$reg_subtitle = ' Admin User Edit Page';
	$reg_breadcrumb = 'Edit  Admin User';
	$reg_button = 'Update';
}
else
{	
	$reg_title = 'Add New  Admin User';
	$reg_subtitle = ' Admin User Add Page';
	$reg_breadcrumb = 'Add New  Admin User';
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
                        <li><a href="<?php echo $baseurl; ?>master/admin-user-list.php"><i class="fa fa-leaf"></i> Admin User List </a></li>
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

                                    <h3 class="box-title">Admin User Details</h3>

                                </div><!-- /.box-header -->

                                <!-- form start -->
                                	<?php if($_GET['fid']!="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $_GET['fid']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['service_image']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">
                                    
                                    <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">User Role<span class="error">*</span></label></div>
                                            <div class="col-md-10"><?php echo togetuseradminrole('user_group_id', $_SESSION['myForm']['user_group_id'], $others=""); ?></div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Firstname<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="firstname" name="firstname" placeholder="Firstname" id="firstname" class="form-control" value="<?php echo $_SESSION['myForm']['firstname']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Lastname<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="lastname" name="lastname" placeholder="Lastname" id="lastname" class="form-control" value="<?php echo $_SESSION['myForm']['lastname']; ?>"></div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">EMail ID (Username)<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="email" name="username" placeholder="User Name" id="username" class="form-control" value="<?php echo $_SESSION['myForm']['username']; ?>" autocomplete="off"></div>

                                        </div>
  
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Password<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="password" name="password" placeholder="Password" id="password" class="form-control" value="<?php echo $_SESSION['myForm']['password']; ?>" autocomplete="off"></div>

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

                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='admin-user-list.php'"> Back </button>

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