<?php include("includes/config.php"); checkuserlogin(); ?>
<!-- RWS Header Starts -->
<?php include("application/gtheader.php"); ?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">
<div class="row">
	<?php include("application/left-sidebar.php"); ?>

    <div class="col-sm-9" id="rws-rightcolumn">
    
<div class="rws-module">
<h1>Services List</h1>
<?php 
	include("application/services-menu.php"); 
	if($_SESSION['GTAdminValidate']==1) { 
	
	$orderfield = $_GET["field"];	
	$orderby = $_GET["order"];
	$search_txt = trim($_GET["search_txt"]);

	if($search_txt !="")
	{
		$search_exploded = explode (" ", $search_txt);
		foreach($search_exploded as $search_txt){
		mysql_set_charset("utf8");
		$search_txt = mysql_real_escape_string($search_txt);
		$x++;
		if($x==1)
			$nquery = " AND (t1.price LIKE '%$search_txt%' OR t2.service_name LIKE '%$search_txt%') ";
		else
			$nquery = " AND (t1.price LIKE '%$search_txt%' OR t2.service_name LIKE '%$search_txt%') ";
		}	
	}

	$query="SELECT t1.*, t2.name as service_name, t2.parent_id FROM ss_service_provider_services as t1 INNER JOIN ss_services as t2 ON t1.service_id=t2.service_id WHERE t1.service_provider_service_id > 0 and user_id = ".$_SESSION['GTUserID']." ".$nquery;
	
	$rs = $db->query($query);
	$foundnum = $rs->num_rows;

	$per_page = 20;
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
	echo $query." ORDER BY t1.add_date DESC LIMIT $start, $per_page";*/	

	if($orderfield !="") { $result = $db->query($query." ORDER BY $orderfield $orderby LIMIT $start, $per_page"); }
	else { $result = $db->query($query." ORDER BY add_date ASC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "sp-services-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "sp-services-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "sp-services-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "sp-services-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "sp-services-list.php?page=gclt&PageNo=1"; 
		$urltopage = "sp-services-list.php?page=gclt&search=".$search_txt; 
	}

	$_SESSION["Viewrcturl"] = $urltoshow;

	/* Sort Code */
	if($orderby != "" && $orderby == "ASC")
	{
		$show_firmid = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_provider_service_id&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_service = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_name&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Service Name</a>';	
		$show_price = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=price&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Price(In Rs.)</a>';
		$show_add_date = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=add_date&order=DESC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
		
	}
	else
	{
		$show_firmid = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_provider_service_id&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">ID</a>';
		$show_service = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=service_name&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Service Name</a>';	
		$show_price = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=price&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Price(In Rs.)</a>';
		$show_add_date = '<a href="sp-services-list.php?page=gclt&PageNo='.$pagenum.'&field=add_date&order=ASC&search='.$search_txt.'" title="Click to Sort in desending order.">Add Date</a>';
	}

?>
    
    <form name="gtservices" id="gtservices" method="post" action="" enctype="multipart/form-data">
    <?php echo $gt_msgerror; if($foundnum>0) { ?>
		<table class="table">
      <thead>
        <tr>
          <th><?php echo $show_firmid; ?></th>
          <th style="width:500px;"><?php echo $show_service; ?></th>
          <th><?php echo $show_price; ?></th>
          <th><?php echo $show_add_date; ?></th>
          <!--<th>Action</th>-->
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
          <th scope="row"><?php echo $row["service_provider_service_id"]; ?></th>
          <td><?php echo todisplaypath($row['parent_id']).' > '.$row["service_name"]; ?></td>
          <td><?php echo $row["price"]; ?></td>
          <td><?php echo toshowdatewithtime($row["add_date"]); ?></td>
          <!--<td <?php echo $status_cls; ?>><?php echo $status; ?></td>-->
          <!--<td><a href="add-village-survey-step-1.php?sid=<?php echo $row["id"]; ?>">Edit</a></td>-->
        </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <?php } ?>
    
    <div class="row"  style="padding-top:10px; padding-bottom:10px;">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example1_info">
                    <?php if($foundnum>0) { echo 'Showing  '.($start+1).' to '.($start+$per_page).' of '.$foundnum.' entries'; } else { echo '<strong style="color:#FF0000;">There is no services added yet.</strong>'; }?>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_bootstrap">
                    <?php echo generate_pagination_new($urltopage, $max_pages, $pagenum, $foundnum, $per_page, $pageshow, $start); ?>
                </div>
            </div>
        </div><!-- /.Pagination Ends -->
    
	</form>
    <?php } else { echo '<div id="rws-forminfo">Your profile is under review. Once it will validated by admin, You will be able to use the Frentor Section.</div>'; } ?>
    </div>
    </div>
   </div> 
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 