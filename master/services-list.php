<?php include('header.php'); $gtpage = 'services-list'; $listjs = 1;  checkadminroles('services');

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];	

	switch($action)
	{
		case "Inactive":
			echo $sql="UPDATE `ss_services` SET `status`='0' WHERE `service_id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;

		case "Active":

			echo $sql="UPDATE `ss_services` SET `status`='1'  WHERE `service_id` in ($chkid)";

			$db->query($sql);			

			$msg='Status has been updated successfully to Accepted!';

			$class='successmsg';					

		break;

		

		case "Delete":
			$sql="DELETE FROM `ss_services` WHERE `service_id` in ($chkid)";
			$db->query($sql);
			
			$sql="DELETE FROM `ss_services` WHERE `parent_id` in ($chkid)";
			$db->query($sql);

			$msg='Records has been deleted successfully!';
			$class='successmsg';

		break;

	}

}

/* ----- Action Code Ends HERE ----- */

	$orderfield = $_GET["field"];
	$orderby = $_GET["order"];
	$search_txt = trim($_GET["search_txt"]);
	
	if($search_txt !="")
	{
		$search_exploded = explode (" ", $search_txt);

		foreach($search_exploded as $search_txt){
				
		$x++;

		if($x==1)
			$nquery .= " AND (t1.name LIKE '%$search_txt%') ";
		else
			$nquery .= " AND (t1.name LIKE '%$search_txt%') ";
		}
	}



	$query="SELECT t1.service_id, t1.name, t1.status, t1.date_added, (select t2.name from ss_services as t2 where t2.service_id=t1.parent_id ) as parent_name FROM ss_services as t1 WHERE t1.service_id > 0 ".$nquery;
	
	$rs = $db->query($query);

	$foundnum = $rs->num_rows;
	$per_page = 50;

	$max_pages = ceil($foundnum / $per_page);	
	$pagenum = trim($_GET['PageNo']);	
	$max_pages = ceil($foundnum / $per_page);	
	$pagenum = trim($_GET['PageNo']);
	if(is_numeric($pagenum))
	{
		if($pagenum >= $max_pages) { $pageshow = $max_pages; }
		elseif($pagenum < $max_pages && $pagenum > 0) { $pageshow = $pagenum; } 
		elseif($pagenum <= 0) { $pageshow = '1'; }
		else { $pageshow = '1';	 }
	}
	else
	{
		$pageshow = '1';
	}
	
	if($pageshow==0) { $begin = $pageshow; } else { $begin = $pageshow - 1; }
	$start = $begin * $per_page;
	if(!$start)
	$start=0; 	

	/*echo $query." ORDER BY $orderfield $orderby LIMIT $start, $per_page";
	echo "<br>";
	echo $query." ORDER BY t1.date_added DESC LIMIT $start, $per_page";*/	

	if($orderfield !="") { $result = $db->query($query." ORDER BY $orderfield $orderby LIMIT $start, $per_page"); }
	else { $result = $db->query($query." ORDER BY service_id ASC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "services-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "services-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "services-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "services-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "services-list.php?page=gclt&PageNo=1"; 
		$urltopage = "services-list.php?page=gclt&search=".$search_txt; 
	}	

	$_SESSION["Viewrcturl"] = $urltoshow;
	/* Sort Code */

	if($orderby != "" && $orderby == "ASC")
	{
		$show_firmid = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_id&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_title = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=name&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Services Name</a>';	
		$show_location = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=parent_name&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Parent</a>';	
		$show_short = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=shortname&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Short Name</a>';	
		$show_date_added = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=date_added&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		$show_member = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Posted By</a>';
		$show_status = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Status</a>';
		$show_year = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=year_start&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Year Start</a>';
		$show_branch = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=branch_start&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Branch Start</a>';	

	}
	else
	{
		$show_firmid = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_id&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_title = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=name&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Services Name</a>';
		$show_location = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=parent_name&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Parent</a>';
		$show_short = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=shortname&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Short Name</a>';
		$show_date_added = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=date_added&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		$show_member = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Posted By</a>';
		$show_status = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Status</a>';
		$show_year = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=year_start&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Year Start</a>';
		$show_branch = '<a href="services-list.php?page=gclt&PageNo='.$pagenum.'&field=branch_start&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Branch Start</a>';
	}

	/* Sort Code */
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Left side column. contains the logo and sidebar -->

            <?php include('sidebar.php'); ?>



            <!-- Right side column. Contains the navbar and content of the page -->

            <aside class="right-side">

                <!-- Content Header (Page header) -->

                <section class="content-header">
                    <h1>
                        Category List
                        <small>Front-End Category List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Category List</li>
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
                                	<?php if($foundnum>0) { echo '<div class="rws-messageshow">'.$foundnum.' '.trim($_GET["search_txt"]).'  results found!</div>'; } ?>
                                	<div class="row" style="padding-bottom:10px; padding-top:5px;">
                                    	<div class="col-xs-6">
                                        <button class="btn btn-primary" type="button" name="rws-addbtn" onclick="document.location.href='services-add.php'"> Add New </button> &nbsp;
								<?php if($foundnum>0) { ?>
                                <button class="btn btn-primary" type="button" name="delete" id="delete" onclick="javascript:deleteRecord();" > Delete </button> &nbsp;	
                                <button class="btn btn-primary" type="button" name="active" id="active" onclick="javascript:activeRecord();" > Active </button> &nbsp;
                                <button class="btn btn-primary" type="button" name="inactive" id="inactive" onclick="javascript:inactiveRecord();" > Inactive </button> &nbsp;							                                
                                <input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]; ?>"/>
                                <input type="hidden" name="action" id="action" value="search"/>
                                <input type="hidden" name="PageNo" value="<?php echo $_GET["PageNo"]; ?>"/>
                                <input type="hidden" name="field" value="<?php echo $_GET["field"]; ?>"/>
                                <input type="hidden" name="order" value="<?php echo $_GET["order"]; ?>"/>
                                <?php } ?>
                                        </div>

                                    

                                        <div class="col-xs-6" >

                                           <div id="dataTables_filter"  class="dataTables_filter">

                                           		<label>Search: <input class="form-control" type="text" name="search_txt" id="search_txt" value="<?php echo trim($_GET["search_txt"]);?>" style="max-width:260px; display:inline-block; margin:0 10px;" /> <button class="btn btn-primary" type="submit" name="rws-submit"> Search </button></label>

                                           </div>

                                        </div>

                                    </div>

                                    <?php if($foundnum>0) { ?>

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>

                                            <tr>

                                                <th width="10"><input name="chkSelectAll" type="checkbox" id="chkSelectAll" value="checkbox" onclick="javascript:selectAllChk();" /></th>

                                                <th><?php echo $show_firmid; ?></th>

                                                <th><?php echo $show_title; ?></th>

                                                <th><?php echo $show_location; ?></th>                                                

                                                <th><?php echo $show_date_added; ?></th>

                                                <th><?php echo $show_status; ?></th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                        <?php  

										$rowlist = $result->rows;
										$j=1; foreach($rowlist as $key => $row) { 

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
											
											if($row["parent_name"]=="") { $parentname = ""; } else { $parentname = ""; }

										 ?>

                                            <tr>

                                                <td><input name="chkid[<? echo $j; ?>]" type="checkbox" id="chkid[<? echo $j; ?>]" value="<? echo $row['service_id']; ?>" /></td>
                                                <td><?php echo $row["service_id"]; ?></td>
                                                <td><?php echo $row["name"]; ?></td>
                                                <td><?php echo $row["parent_name"]; ?></td>
                                                <!--<td><?php echo $row["shortname"]; ?></td>
                                                <td><?php echo $row["year_start"]; ?></td>
                                                <td><?php echo $row["branch_start"]; ?></td>-->
                                                <td><?php echo toshowdatewithtime($row["date_added"]); ?></td>
                                                <td <?php echo $status_cls; ?>><?php echo $status; ?></td>
                                                <td><a href="services-add.php?fid=<?php echo $row["service_id"]; ?>">Edit</a></td>
                                            </tr> 

                                         <?php  $j++; } ?>                                              

                                        </tbody>

                                        <tfoot>

                                            <tr>

                                                <th>#</th>

                                                <th><?php echo $show_firmid; ?></th>

                                                <th><?php echo $show_title; ?></th> 

                                                <th><?php echo $show_location; ?></th>

                                                <th><?php echo $show_date_added; ?></th>

                                                <th><?php echo $show_status; ?></th>

                                                <th>Action</th>

                                            </tr>

                                        </tfoot>

                                    </table>

                                    <?php } ?>                            

                                    <div class="row"  style="padding-top:10px; padding-bottom:10px;">

                                    	<div class="col-xs-6">

                                        	<div class="dataTables_info" id="example1_info">

												<?php if($foundnum>0) { echo 'Showing  '.($start+1).' to '.($start+$per_page).' of '.$foundnum.' entries'; } else { echo '<strong style="color:#FF0000;">There is no category added yet.</strong>'; }?>

                                            </div>

                                        </div>

                                    	<div class="col-xs-6">

                                        	<div class="dataTables_paginate paging_bootstrap">

                                            	<?php echo generate_pagination_new($urltopage, $max_pages, $pagenum, $foundnum, $per_page, $pageshow, $start); ?>

                                            </div>

                                        </div>

                                    </div><!-- /.Pagination Ends -->

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