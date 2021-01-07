<?php include('header.php'); $gtpage = 'member-list'; $listjs = 1;    checkadminroles('admin_users');

if(isset($_REQUEST["action"]))
{
	$action=$_REQUEST["action"];
	$chkid="'".implode("','",$_GET["chkid"])."'";
	$chkidid=$_GET["chkid"];
	
	switch($action)
	{
		case "Inactive":
			$sql="UPDATE `ss_adminuser` SET `status`='0' WHERE `user_id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Unpublished!';
			$class='successmsg';
		break;
		case "Active":
			$sql="UPDATE `ss_adminuser` SET `status`='1'  WHERE `user_id` in ($chkid)";
			$db->query($sql);			
			$msg='Status has been updated successfully to Published!';
			$class='successmsg';					
		break;		
		case "Delete":				
			$sql="delete from `ss_adminuser` where `user_id` in ($chkid)";
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
			$nquery .= " AND (firstname LIKE '%$search_txt%' OR lastname LIKE '%$search_txt%' OR email LIKE '%$search_txt%') ";
		else
			$nquery .= " AND (firstname LIKE '%$search_txt%' OR lastname LIKE '%$search_txt%' OR email LIKE '%$search_txt%') ";
		}
	}
	
	

	$query="SELECT user_id, firstname, lastname, email, username, user_group_name, IF(status=1,'Published','Unpublished') AS status, last_login, date_added FROM `ss_adminuser` WHERE user_id!='1' ".$nquery;

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
	else { $result = $db->query($query." ORDER BY date_added DESC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "admin-user-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "admin-user-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "admin-user-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "admin-user-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "admin-user-list.php?page=gclt&PageNo=1"; 
		$urltopage = "admin-user-list.php?page=gclt&search=".$search_txt; 
	}	

	$_SESSION["Viewrcturl"] = $urltoshow;
	/* Sort Code */

	if($orderby != "" && $orderby == "ASC")
	{
		$show_firmid = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=user_id&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_firstname = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Firstname</a>';	
		$show_lastname = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=lastname&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Lastname</a>';		
		$show_email = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=email&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Email ID</a>';		
		$show_mobile = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=mobile&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Mobile</a>';	
		
		$show_dateofbirth = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=dateofbirth&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Date of Birth</a>';
		$show_user_type = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=user_group_name&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Usertype</a>';		
		$show_status = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Status</a>';
		$show_add_date = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=date_added&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';	
		
		$show_validate = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=last_login&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Last Login</a>';			

	}
	else
	{
		$show_firmid = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=user_id&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_firstname = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Firstname</a>';	
		$show_lastname = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=lastname&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Lastname</a>';		
		$show_email = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=email&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Email ID</a>';		
		$show_mobile = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=mobile&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Mobile</a>';		
		$show_gender = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=gender&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Gender</a>';
		$show_dateofbirth = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=dateofbirth&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Date of Birth</a>';
		$show_user_type = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=user_group_name&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Usertype</a>';		
		$show_status = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=status&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Status</a>';
		$show_add_date = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=date_added&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		$show_validate = '<a href="admin-user-list.php?page=gclt&PageNo='.$pagenum.'&field=last_login&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Last Login</a>';		
		
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
                        Admin User List
                        <small>Back-End User User</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Admin User List</li>
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
                                        <button class="btn btn-primary" type="button" name="rws-addbtn" onclick="document.location.href='admin-user-add.php'"> Add New </button> &nbsp;
                                                                             
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
                                                <th><?php echo $show_firstname; ?></th>
                                                <th><?php echo $show_lastname; ?></th>  
                                                <th><?php echo $show_email; ?></th>
                                                <th><?php echo $show_user_type; ?></th>
                                                <th><?php echo $show_status; ?></th>                                                
                                                <th><?php echo $show_validate; ?></th>                                                
                                                <th><?php echo $show_add_date; ?></th>
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

										 ?>

                                            <tr>
                                                <td><input name="chkid[<? echo $j; ?>]" type="checkbox" id="chkid[<? echo $j; ?>]" value="<? echo $row['user_id']; ?>" /></td>
                                                <td><?php echo $row["user_id"]; ?></td>
                                                <td><?php echo $row["firstname"]; ?></td>
                                                <td><?php echo $row["lastname"]; ?></td>
                                                <td><?php echo $row["email"]; ?></td>
                                                <td><?php echo $row["user_group_name"]; ?></td>                                                 
                                                <td <?php echo $status_cls; ?>><?php echo $status; ?></td>
                                                <td><?php echo toshowdatewithtime($row["last_login"]); ?></td>
                                                <td><?php echo toshowdatewithtime($row["date_added"]); ?></td>
                                                <td><a href="admin-user-add.php?fid=<?php echo $row["user_id"]; ?>">Edit</a></td>
                                            </tr> 
                                         <?php  $j++; } ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $show_firmid; ?></th>
                                                <th><?php echo $show_firstname; ?></th>
                                                <th><?php echo $show_lastname; ?></th>  
                                                <th><?php echo $show_email; ?></th>
                                                <th><?php echo $show_user_type; ?></th>
                                                <th><?php echo $show_status; ?></th>                                                
                                                <th><?php echo $show_validate; ?></th>                                                
                                                <th><?php echo $show_add_date; ?></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php } ?>                            

                                    <div class="row"  style="padding-top:10px; padding-bottom:10px;">

                                    	<div class="col-xs-6">

                                        	<div class="dataTables_info" id="example1_info">

												<?php if($foundnum>0) { echo 'Showing  '.($start+1).' to '.($start+$per_page).' of '.$foundnum.' entries'; } else { echo '<strong style="color:#FF0000;">There is no admin user added yet.</strong>'; }?>

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