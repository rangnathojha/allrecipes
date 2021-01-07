<?php include('header.php'); $gtpage = 'group-list'; $listjs = 1; 

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	
	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `groups` SET `status`='0' WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;
		case "Active":
			$sql="UPDATE `groups` SET `status`='1'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;
		
		case "Delete":			
			$sql="delete from `groups` where `id` in ($chkid)";
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
	$sql="UPDATE `groups` SET `sort_order`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
	$db->query($sql);
	
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
                        Group List
                        <small>Front-End Group List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Group List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12"><!-- /.box -->
                        	<?php if(!empty($msg)) { ?>
                              <div id="gt-formsuccess">                                
                                  <?php echo $msg; ?>
                              </div>
                              <?php } ?>
                              <?php
								$searcharray = array('t1.created_date');
								$fieldtoshowlists= array('id'=>'#ID','name'=>'Group Name', 'groupuser'=>'Group For','status'=>'Status','created_date'=>'Add Date');
								$query = "SELECT t1.id,t1.name,t1.status,t1.created_date,t1.sort_order,( case t1.groupuser
        when 'S' then 'Students'
        when 'A' then 'Alumni'
		when 'B' then 'Alumni & Students'
    end )as groupuser FROM groups  as t1 WHERE t1.id > 0 ";
								
								listpages($searcharray,$fieldtoshowlists,'group-list.php',$query,'created_date','status','name','group-add.php','There is no group added yet!',$sort_order=1);
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