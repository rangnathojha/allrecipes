<?php include('header.php'); $gtpage = 'category-order-list'; $listjs = 1;  checkadminroles('order');



if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `ss_consumer_order` SET `status`='0' WHERE `order_id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Pending!';
			$class='successmsg';
		break;

		case "Active":
			$sql="UPDATE `ss_consumer_order` SET `status`='1'  WHERE `order_id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Accepted!';
			$class='successmsg';	
		break;		

		case "Delete":
			$sql="DELETE FROM `ss_consumer_order` WHERE `order_id` in ($chkid)";
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
			$nquery = " AND (t1.order_reference_number LIKE '%$search_txt%' OR t1.service_provider_name LIKE '%$search_txt%' OR t1.service_name LIKE '%$search_txt%' OR t1.package_name LIKE '%$search_txt%' OR t2.firstname LIKE '%$search_txt%' OR t2.lastname LIKE '%$search_txt%' OR t2.email LIKE '%$search_txt%') ";
		else
			$nquery = " AND (t1.order_reference_number LIKE '%$search_txt%' OR t1.service_provider_name LIKE '%$search_txt%' OR t1.service_name LIKE '%$search_txt%' OR t1.package_name LIKE '%$search_txt%' OR t2.firstname LIKE '%$search_txt%' OR t2.lastname LIKE '%$search_txt%' OR t2.email LIKE '%$search_txt%') ";
		}
		
	}

	$query="SELECT t1.*, t2.firstname, t2.lastname, t2.email FROM ss_consumer_order as t1 LEFT JOIN ss_users as t2 ON t1.user_id=t2.user_id WHERE t1.order_id>0 GROUP BY t1.order_id ".$nquery;

	$rs = $db->query($query);

	$foundnum = $rs->num_rows;
	$per_page = 40;

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
	else { $result = $db->query($query." ORDER BY order_id DESC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "category-order-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "category-order-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "category-order-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "category-order-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "category-order-list.php?page=gclt&PageNo=1"; 
		$urltopage = "category-order-list.php?page=gclt&search=".$search_txt; 
	}	

	$_SESSION["Viewrcturl"] = $urltoshow;
	/* Sort Code */

	if($orderby != "" && $orderby == "ASC")
	{
		$show_firmid = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_id&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_title = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_subtitle&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Order Reference Number</a>';	
		$show_amount = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_name&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Amount Paid(In Rs.)</a>';		
		$show_service = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_price&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Service Name</a>';		
		$show_package = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=duration&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Package Name</a>';
		$show_servicep = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=hourly_cost&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Frentor</a>';
		$show_total_hours = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=total_hours&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Total Hours</a>';
		$show_duration = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=discounted_hourly_cost&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Duration(in Days)</a>';		
		$show_status = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Order Status</a>';
		$show_date_added = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=dateoforder&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		
		$show_customername = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Customer Name</a>';
		$show_customeremail = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=email&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Customer Email</a>';	
	

	}
	else
	{
		$show_firmid = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_id&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_title = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_subtitle&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Order Reference Number</a>';	
		$show_amount = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_name&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Amount Paid(In Rs.)</a>';		
		$show_service = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=package_price&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Service Name</a>';		
		$show_package = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=duration&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Package Name</a>';
		$show_servicep = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=hourly_cost&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Frentor</a>';
		$show_total_hours = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=total_hours&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Total Hours</a>';
		$show_duration = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=discounted_hourly_cost&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Duration(in Days)</a>';		
		$show_status = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Order Status</a>';
		$show_date_added = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=dateoforder&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		
		$show_customername = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Customer Name</a>';
		$show_customeremail = '<a href="category-order-list.php?page=gclt&PageNo='.$pagenum.'&field=email&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Customer Email</a>';	
			
		
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
                       Order List
                        <small>Front-End Consumer Order List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Consumer Order List</li>
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
                                        <!--<button class="btn btn-primary" type="button" name="rws-addbtn" onclick="document.location.href='package-add.php'"> Add New </button> &nbsp;-->
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
                                                <th><?php echo $show_customername; ?></th>
                                                <th><?php echo $show_amount; ?></th>  
                                                <th><?php echo $show_service; ?></th>     
                                                <th><?php echo $show_package; ?></th>
                                                <th><?php echo $show_servicep; ?></th>
                                                <th><?php echo $show_total_hours; ?></th>
                                                <th><?php echo $show_duration; ?></th>
                                                <th><?php echo $show_status; ?></th>                                                
                                                <th><?php echo $show_date_added; ?></th>
                                                <th>Action</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                        <?php  

										$rowlist = $result->rows;
										$j=1; foreach($rowlist as $key => $row) { 

											if($row["status"]=='0') 
											{ 
												$status = '<span style="color:#525e66; font-weight:bold;">Pending</span>'; 
												$status_cls = 'style="border:1px solid #8fc6df; background: #cee4ff;"'; 
											} 
											elseif($row["status"]=='2') 
											{ 
												$status = '<span style="color:#665252; font-weight:bold;">Failed</span>'; 
												$status_cls = 'style="border:1px solid #df8f8f; background: #ffcece;"'; 
											} 
											elseif($row["status"]=='3') 
											{ 
												$status = '<span style="color:#665252; font-weight:bold;">Canceled</span>'; 
												$status_cls = 'style="border:1px solid #df8f8f; background: #ffcece;"'; 
											} 
											else 
											{
												$status = '<span style="color:#556652; font-weight:bold;">Successful</span>'; 
												$status_cls = 'style="border:1px solid #9adf8f; background: #d5ffce;"';
											}
											
											if(empty($row["service_provider_id"]))
											{
												$service_provider_name = '<span style="color:#525e66; font-weight:bold;">Not Assigned</a>';	
												$sps_cls = 'style="border:1px solid #8fc6df; background: #cee4ff;"'; 
												$linktoshow = '<a href="category-order-assign.php?fid='.$row['order_id'].'" title="Assign Frentor">Assign Frentor</a> | ';
											}
											else
											{
												$service_provider_name = '<span style="color:#556652; font-weight:bold;">'.$row["service_provider_name"].'</span>';										$sps_cls = 'style="border:1px solid #9adf8f; background: #d5ffce;"';
												$linktoshow = '<a href="category-order-assign.php?fid='.$row['order_id'].'" title="Assign Frentor">Assign Frentor</a> | ';
											}

										 ?>

                                            <tr>
                                                <td><input name="chkid[<? echo $j; ?>]" type="checkbox" id="chkid[<? echo $j; ?>]" value="<? echo $row['order_id']; ?>" /></td>
                                                <td><?php echo $row["order_id"]; ?></td>
                                                <td><?php echo $row["order_reference_number"]; ?></td>
                                                <td><?php echo $row["firstname"].' '.$row["lastname"]; ?></td>
                                                <td><?php echo $row["totalamount"]; ?></td>
                                                <td><?php echo $row["service_name"]; ?></td>
                                                <td><?php echo $row["package_name"]; ?></td>
                                                <td <?php echo $sps_cls; ?>><?php echo $service_provider_name; ?></td>
                                                <td><?php echo $row["totalhours"]; ?></td>
                                                <td><?php echo $row["duration"]; ?></td>                                                 
                                                <td <?php echo $status_cls; ?>><?php echo $status; ?></td>
                                                <td><?php echo toshowdatewithtime($row["dateoforder"]); ?></td>
                                                <td><?php echo $linktoshow; ?><a href="category-order-details.php?fid=<?php echo $row["order_id"]; ?>">Details</a></td>
                                            </tr> 
                                         <?php  $j++; } ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $show_firmid; ?></th>
                                                <th><?php echo $show_title; ?></th>
                                                <th><?php echo $show_customername; ?></th>
                                                <th><?php echo $show_amount; ?></th>  
                                                <th><?php echo $show_service; ?></th>     
                                                <th><?php echo $show_package; ?></th>
                                                <th ><?php echo $show_servicep; ?></th>
                                                <th><?php echo $show_total_hours; ?></th>
                                                <th><?php echo $show_duration; ?></th>
                                                <th><?php echo $show_status; ?></th>                                                
                                                <th><?php echo $show_date_added; ?></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php } ?>                            

                                    <div class="row"  style="padding-top:10px; padding-bottom:10px;">

                                    	<div class="col-xs-6">

                                        	<div class="dataTables_info" id="example1_info">

												<?php if($foundnum>0) { echo 'Showing  '.($start+1).' to '.($start+$per_page).' of '.$foundnum.' entries'; } else { echo '<strong style="color:#FF0000;">There is no consumer order yet.</strong>'; }?>

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