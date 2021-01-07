<?php include('header.php'); $gtpage = 'course-list';  $listjs = 1; $gtdateopt = "on";
$_SESSION['myForm']=array();
// send mail code 

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];	

	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `newsletter` SET `status`='0' WHERE `id` in ($chkid)";
			$db->query($sql);
			$msg='Status has been updated successfully to Unpublished!';
			$class='successmsg';
		break;

		case "Active":
			$sql="UPDATE `newsletter` SET `status`='1'  WHERE `id` in ($chkid)";
			$db->query($sql);	
			$msg='Status has been updated successfully to Published!';
			$class='successmsg';
		break;

		case "Delete":
			$sql="delete from `newsletter` where `id` in ($chkid)";
			$db->query($sql);			
			$sql="delete from `newsletter_users` where `newsletter_id` in ($chkid)";
			$db->query($sql);
			
			$msg='Records has been deleted successfully!';
			$class='successmsg';

		break;

	}

}

if($orderfield !="") 
{ 
	$urltoshow = "newsletter.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby;
	$urltosearch = "newsletter.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
	$urltopage = "newsletter.php?page=gclt&field=".$orderfield."&order=".$orderby;
 }
else
{ 
	$urltoshow = "newsletter.php?page=gclt&PageNo=".$pagenum; 
	$urltosearch = "newsletter.php?page=gclt&PageNo=1"; 
	$urltopage = "newsletter.php?page=gclt";
}

$rwscid=$_GET["rwscid"];
foreach($rwscid as $key => $val)
{
	$sql="UPDATE `newsletter_dumpitems` SET `orderid`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
	mysql_query($sql);
	
}									
	
	$reg_title = 'Newsletter';
	$reg_subtitle = 'Newsletter';
	$reg_breadcrumb = 'Newsletter';
	$reg_button = 'Save';
	
	$orderfield = $_GET["field"];
	$orderby = $_GET["order"];	
	
	if($orderfield !="") {	
		$query = "SELECT t1.*, IFNULL(t2.totalusers,0) as totalusers FROM newsletter as t1 LEFT JOIN (SELECT newsletter_id, COUNT(*) AS totalusers FROM newsletter_users GROUP BY newsletter_id ) AS t2 ON t1.id = t2.newsletter_id  WHERE t1.id > 0 ORDER BY $orderfield $orderby LIMIT 0, 55 ";
	}
	else
	{
		$query = "SELECT t1.*, IFNULL(t2.totalusers,0) as totalusers FROM newsletter as t1 LEFT JOIN (SELECT newsletter_id, COUNT(*) AS totalusers FROM newsletter_users GROUP BY newsletter_id ) AS t2 ON t1.id = t2.newsletter_id  WHERE t1.id > 0 ORDER BY add_date DESC LIMIT 0, 55 ";
	}
	
	$result = $db->query($query);	

	$totalrows = $result->num_rows;

	$rowlist = $result->rows;
	
	
	if($orderby != "" && $orderby == "ASC")

	{

		$show_group = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=subject&order=DESC" title="Click to Sort in desending order.">Subject</a>';

		$show_groupcat = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=college_name&order=DESC" title="Click to Sort in desending order.">College Name</a>';
		$show_user = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=totalusers&order=DESC" title="Click to Sort in desending order.">Total Subscribers</a>';
		
		$show_senddate = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=start_date&order=DESC" title="Click to Sort in desending order.">Schedule Date</a>';	
		
		$show_date = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=created_date&order=DESC" title="Click to Sort in desending order.">Add Date</a>';		

		$show_status = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=status&order=DESC" title="Click to Sort in desending order.">Status</a>';

		

	}

	else

	{

		$show_group = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=subject&order=ASC" title="Click to Sort in desending order.">Subject</a>';

		$show_groupcat = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=college_name&order=ASC" title="Click to Sort in desending order.">College Name</a>';
		$show_user = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=totalusers&order=ASC" title="Click to Sort in desending order.">Total Subscribers</a>';
		
		$show_senddate = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=start_date&order=ASC" title="Click to Sort in desending order.">Schedule Date</a>';	
		
		$show_date = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=created_date&order=ASC" title="Click to Sort in desending order.">Add Date</a>';		

		$show_status = '<a href="newsletter.php?page=gclt&PageNo='.$pagenum.'&field=status&order=ASC" title="Click to Sort in desending order.">Status</a>';

	}

?>

<style type="text/css">
.gtiitprojects td{background:#edbf47 !important;}
.gtforeginprojects td{background:#89ce8f !important;}
.gtinterview td{background:#74cee4 !important;}
.gtinternship td{background:#ec774b !important;}
</style>

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
                        <li><a href="<?php echo $baseurl; ?>master/newsletter.php"><i class="fa fa-leaf"></i> News Letter </a></li>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>
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
                              
                            <form action="" method="get" name="form4" id="form4">
                            
                            <div class="box"><!-- /.box-header -->
                                <div class="box-body table-responsive">                                	
                                    <?php if($totalrows>0) { $sno=1; ?>
                                    <div style="padding-bottom:10px; padding-top:5px; clear:both; overflow:hidden; text-align:right;">
                                    <button class="btn btn-primary" type="button" name="delete" id="delete" onclick="javascript:deleteRecord();" > Delete </button> &nbsp;	

                                <button class="btn btn-primary" type="button" name="active" id="active" onclick="javascript:activeRecord();" > Active </button> &nbsp;

                                <button class="btn btn-primary" type="button" name="inactive" id="inactive" onclick="javascript:inactiveRecord();" > Inactive </button>	
                                
                                <input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]; ?>"/>

                                <input type="hidden" name="action" id="action" value="search"/>

                                <input type="hidden" name="PageNo" value="<?php echo $_GET["PageNo"]; ?>"/>

                                <input type="hidden" name="field" value="<?php echo $_GET["field"]; ?>"/>

                                <input type="hidden" name="order" value="<?php echo $_GET["order"]; ?>"/>
                                
                                </div>
                                
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10">#</th>
                                                <th>S. No.</th>
                                                <th><?php echo $show_group; ?></th>
                                                <th><?php echo $show_groupcat; ?></th>
                                                <th><?php echo $show_user; ?></th>
                                                <th><?php echo $show_senddate; ?></th>
                                                <th><?php echo $show_status; ?></th>
                                                <th><?php echo $show_date; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  $j=1; foreach($rowlist as $key => $row) 
											{	
											
											if($row["status"]=='0') 

											{ 

												$status = '<span style="color:#665252; font-weight:bold;">Unpublished</span>'; 

												$status_cls = 'style="border:1px solid #df8f8f; background: #ffcece;"'; 

											} 

											else 

											{ 

												$status = '<span style="color:#556652; font-weight:bold;">Published</span>'; 

												$status_cls = 'style="border:1px solid #9adf8f; background: #d5ffce;"';

											}											
											
										 ?>
                                            <tr class="<?php echo $trbgcolor; ?>">
                                                <td><input name="chkid[<? echo $j; ?>]" type="checkbox" id="chkid[<? echo $j; ?>]" value="<? echo $row['id']; ?>" /></td>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $row["subject"]; ?></td>
                                                <td><?php echo $row["college_name"]; ?></td>
                                                <td><?php echo $row["totalusers"].' Users'; ?> </td>
                                                <td><?php echo $row["start_date"]; ?></td>
                                                <td <?php echo $status_cls; ?>><?php echo $status; ?></td>
                                                <td><?php echo toshowdatewithtime($row["add_date"]); ?></td>                                                
                                            </tr> 
                                         <?php $sno++;  $j++; } ?>                                              
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="10">#</th>
                                                <th>S. No.</th>
                                                <th><?php echo $show_group; ?></th>
                                                <th><?php echo $show_groupcat; ?></th>
                                                <th><?php echo $show_user; ?></th>
                                                <th><?php echo $show_senddate; ?></th>
                                                <th><?php echo $show_status; ?></th>
                                                <th><?php echo $show_date; ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php } ?>                            
                                    <!-- /.Pagination Ends -->
                              </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          </form>
                      </div>
                    </div>

                </section><!-- /.content -->
              
              <footer>
              		<?php include('footer-copyright.php'); ?>
              </footer>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->        
<?php include('footer.php'); ?>