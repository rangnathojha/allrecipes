<?php include('header.php'); $gtpage = 'users-list'; $listjs = 1;    checkadminroles('members');

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	
	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `users` SET `status`='0' WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;
		case "Active":
			$sql="UPDATE `users` SET `status`='1'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;
		
		case "Verify":
			$sql="UPDATE `users` SET `verification`='1' , `verifyby` = 'Admin'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Verification Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;
		
		case "DoNotVerify":
			$sql="UPDATE `users` SET `verification`='0'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Verification Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;
		
		case "Delete":		
			// DELETE All User created Groups
			$sql="delete from `groups` where `user_id` in ($chkid)";
			$db->query($sql);
			
			// DELETE All Joined Groups
			$sql="delete from `group_user_join` where `user_id` in ($chkid)";
			$db->query($sql);
			
			// Delele All walls 
			$query="SELECT user_id, wall_id, datatype FROM wall WHERE `user_id` in ($chkid) ";
			$rowlist = $db->query($query);	
			$foundnum = $rs->num_rows;
			if($foundnum>0)
			{
				foreach($rowlist as $key => $rowd) 
				{ 
					$datatype = $rowd["datatype"];
					$wall_id = $rowd["wall_id"];
					$user_id = $rowd["user_id"];
					switch($datatype)
					{
						case 1:
							$sql="DELETE FROM `wall_text` WHERE `id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);			
							$sql="DELETE FROM `wall_text_image_list` WHERE `wall_img_id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);
						break;
						case 2:
							$sql="DELETE FROM `wall_image` WHERE `id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);			
							$sql="DELETE FROM `wall_image_list` WHERE `wall_img_id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);
						break;
						case 3:
							$sql="DELETE FROM `wall_video` WHERE `id`='$wall_id'  AND `user_id`='$user_id'";
							$db->query($sql);
						break;
						case 4:
							$sql="DELETE FROM `wall_file` WHERE `id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);			
							$sql="DELETE FROM `wall_file_list` WHERE `wall_file_id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);
						break;
						case 5:
							$sql="DELETE FROM `wall_events` WHERE `id`='$wall_id' AND `user_id`='$user_id'";
							$db->query($sql);
						break;
						case 6:
							$sql="DELETE FROM `wall_poll_question` WHERE `id`='$wall_id'  AND `user_id`='$user_id'";
							$db->query($sql);			
							$sql="DELETE FROM `wall_poll_options` WHERE `qid`='$wall_id'  AND `user_id`='$user_id'";
							$db->query($sql);
							$sql="DELETE FROM `wall_poll_answer` WHERE `qid`='$wall_id'";
							$db->query($sql);
						break;
					}
					
				}
			}
			
			
			$sql="delete from `wall` where `user_id` in ($chkid)";
			$db->query($sql);
			
			$sql="delete from `users` where `id` in ($chkid)";
			$db->query($sql);
			$msg='Records has been deleted successfully!';
			$class='successmsg';
		break;
	}
}
/* ----- Action Code Ends HERE ----- */

$rwscid=$_GET["rwscid"];
foreach($rwscid as $key => $val)
{
	$sql="UPDATE `users` SET `sort_order`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
	$db->query($sql);
	
}

?>

        <div class="wrapper">
            <!-- Left side column. contains the logo and sidebar -->
            <?php //include('sidebar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                	<h1>
                        Members List Not Verified 
                        <small>Front-End Group List</small>
                    </h1>
                    
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Members List Not Verified</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12"><!-- /.box -->
                        <div class="sublinks" style="text-align:right; ">
                        <button onclick="document.location.href='members-verification.php'" name="rws-addbtn" type="button" class="btn btn-primary" > Member Verification</button>&nbsp;&nbsp;<button onclick="document.location.href='member-list.php'" name="rws-addbtn" type="button" class="btn btn-primary" > All Users </button>
                        </div>
                        	<?php if(!empty($msg)) { ?>
                              <div id="gt-formsuccess">                                
                                  <?php echo $msg; ?>
                              </div>
                              <?php } ?>
                              <?php
								$searcharray = array('t1.created_date');
								$fieldtoshowlists= array('id'=>'#ID','firstname'=>'Name','college_emailid'=>'College Email ID','college_icard'=>'I-Card','enrollment_number'=>'Enroll No.', 'email'=>'Email','gender'=>'Gender','college'=>'College','course'=>'Course','branch'=>'Banch','start_year'=>'Batch Year','verification'=>'Verify','verifyby'=>'Verify By','status'=>'Status','created_date'=>'Add Date');
								$query = "SELECT u.id, concat(u.firstname,'&nbsp;', u.lastname) as firstname, u.college_emailid, u.college_icard, u.enrollment_number, cn.name as college, c.coursename as course, b.branch_short_name as branch, u.start_year, u.verification, u.verifyby, u.status ,u.created_date, u.email,u.gender, u.last_login FROM users  as u  LEFT JOIN college_name as cn ON cn.id = u.college LEFT JOIN course as c ON c.id = u.course  LEFT JOIN branch as b ON b.id = u.branch WHERE u.id > 0 AND u.verification=0 ";
								
								listpages($searcharray,$fieldtoshowlists,'member-list-not-verified.php',$query,'created_date','status','firstname','member-edit.php','There is no user added yet!',$sort_order=0);
								?>

                      </div>
                    </div>

                </section><!-- /.content -->
              
              <footer>
              		<?php include('footer-copyright.php'); ?>
              </footer>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->        
<?php include('footer.php'); ?>