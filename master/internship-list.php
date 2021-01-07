<?php include('header.php'); $gtpage = 'group-list'; $listjs = 1; 

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	
	switch($action)
	{
		/*case "Inactive":
			$sql="UPDATE `wall_in_for_pro_internship` SET `status`='0' WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;
		case "Active":
			$sql="UPDATE `wall_in_for_pro_internship` SET `status`='1'  WHERE `id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Accepted!';
			$class='successmsg';					
		break;*/
		
		case "Delete":			
			$sql="delete from `wall` where `wall_id` in ($chkid) AND datatype=12";
			$db->query($sql);
			
			$sql="delete from `wall_in_for_pro_internship` where `id` in ($chkid)";
			$db->query($sql);
			$msg='Records has been deleted successfully!';
			$class='successmsg';
		break;
	}
}
/* ----- Action Code Ends HERE ----- */

/*$rwscid=$_GET["rwscid"];
foreach($rwscid as $key => $val)
{
	$sql="UPDATE `groups` SET `sort_order`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
	$db->query($sql);
	
}*/

?>

<style type="text/css">
#gtinternship #active, #gtinternship #inactive{ display:none; }
</style>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('sidebar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Internship List
                        <small>Front-End Group List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Group List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content" id="gtinternship">
                    <div class="row">
                        <div class="col-xs-12"><!-- /.box -->
                        	<?php if(!empty($msg)) { ?>
                              <div id="gt-formsuccess">                                
                                  <?php echo $msg; ?>
                              </div>
                              <?php } ?>
                              <?php
								$searcharray = array('t1.created_date');
								$fieldtoshowlists= array('id'=>'#ID','title'=>'Title/Profile', 'company'=>'Company','location'=>'Location','stipend'=>'Stipend','start_date'=>'Start Date','duration'=>'Duration','deadline'=>'Deadline','created_date'=>'Add Date');
								$query = "SELECT t1.* FROM wall_in_for_pro_internship as t1 WHERE t1.id > 0 ";
								
								listpages($searcharray,$fieldtoshowlists,'internship-list.php',$query,'created_date','status','id','internship-add.php','There is no internship added yet!',$sort_order=0);
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