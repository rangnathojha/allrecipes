<?php include('header.php'); $gtpage = 'group-category-list'; $listjs = 1; 

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	
	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `group_categories` SET `status`='0' WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;
		case "Active":
			$sql="UPDATE `group_categories` SET `status`='1'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;
		
		case "Delete":			
			$sql="delete from `group_categories` where `id` in ($chkid)";
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
	$sql="UPDATE `group_categories` SET `sort_order`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
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
                        Group Category List
                        <small>Front-End Group Category List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Group Category List</li>
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
								$searcharray = array('t1.name');
								$fieldtoshowlists= array('id'=>'#ID','name'=>'Group Category Name', 'groupuser'=>'Group For','status'=>'Status','created_date'=>'Add Date');
						$query = "SELECT t1.id,t1.name,t1.status,t1.created_date,t1.sort_order,( case t1.groupuser
        when 'S' then 'Students'
        when 'A' then 'Alumni'
		 when 'B' then 'Alumni & Students'
    end )as groupuser FROM group_categories as t1 WHERE t1.id > 0 ";
						listpages($searcharray,$fieldtoshowlists,'group-category-list.php',$query,'created_date','status','name','group-category-add.php','There is no group category added yet!',$sort_order=1);
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