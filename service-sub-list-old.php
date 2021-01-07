<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
$nquery="";

	
	if(isset($_GET["gtsearchcategory2"]))
	{
		$gtsearchcategory = $_GET["gtsearchcategory2"];
	}
	else
	{
		$gtsearchcategory = $_GET["gtsearchcategory"];
	}
	
	if($gtsearchcategory==4)
	{	
		$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesall(197)."'197')";
		$searchintext = 'People';
	}
	if($gtsearchcategory==5)
	{	
		$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesall(190)."'190')";
		$searchintext = 'Counselling';
	}
	if($gtsearchcategory==6)
	{	
		if(isset($_GET["service_id"]))
		{
			
			
			$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesall($_GET["service_id"])."'".$_GET["service_id"]."')";
		}
		else
		{
			$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesall(1)."'1')";
		}
		
		$searchintext = 'Mentors';
	}
	
	// echo $nquery;
	
	

	if($_GET["service_id"]==1)
	{
		
		$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesalllavel2(2).getlistofsubservicesalllavel2(121)."'100000000') ";
		
		$query="SELECT t1.*, IFNULL(t2.totalsubitems,0) as totalsubitems FROM ss_services as t1 LEFT JOIN (SELECT service_id, parent_id, COUNT(*) AS totalsubitems FROM ss_services GROUP BY service_id ) AS t2 ON t1.service_id = t2.parent_id WHERE t1.service_id > 0 ".$nquery." GROUP BY t1.service_id ";
	
	}
	else
	{
		$nquery .= ' AND t1.service_id IN ('.getlistofsubservicesalllatcategory($_GET["service_id"])."'100000000')  ";
		//$nquery .= ' AND t1.parent_id NOT IN ('.getlistofsubservicesall($_GET["service_id"])."'100000000')  ";
		
		$query="SELECT t1.*, IFNULL(t2.totalsubitems,0) as totalsubitems FROM ss_services as t1 LEFT JOIN (SELECT service_id, parent_id, COUNT(*) AS totalsubitems FROM ss_services GROUP BY service_id ) AS t2 ON t1.service_id = t2.parent_id WHERE t1.status=1 $nquery GROUP BY t1.service_id ";
	}

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

	if($orderfield !="") { $result = $db->query($query." ORDER BY $orderfield $orderby LIMIT $start, $per_page"); }
	else { $result = $db->query($query." ORDER BY name ASC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "service-sub-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "service-sub-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "service-sub-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "service-sub-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "service-sub-list.php?page=gclt&PageNo=1"; 
		$urltopage = "service-sub-list.php?page=gclt&search=".$search_txt; 
	}	


?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
	<?php if($foundnum>0) { ?>	
    	<h1><?php if(!empty(trim($search_txt))) { echo $search_txt.' in '; } echo $searchintext; ?></h1>
        <div class="row">    
              <?php
			  	$rowlist = $result->rows;
				$j=1; foreach($rowlist as $key => $row) { 
					if($row["totalsubitems"]==0)
					{
						echo '<div class="col-sm-3">
								<a href="'.$baseurl.'service-details.php?service_id='.$row["service_id"].'">
								<div class="gtinnerlist">
									'.$row["name"].'
								</div>
							</a>
						</div>';
					}
					else
					{
						echo '<div class="col-sm-3">
								<a href="'.$baseurl.'service-sub-list.php?service_id='.$row["service_id"].'">
								<div class="gtinnerlist">
									'.$row["name"].'
								</div>
							</a>
						</div>';
					}					
				}
			  ?>  
        </div>     
    <?php } else { ?>
		<div class="row">    
            <div class="col-sm-8 col-sm-offset-2">
            	<div id="rws-formfeedback">
                	<p>Sorry, there are no matching result for <strong><?php echo $search_txt;?></strong>.</p>                  
                    <ol>
                    <li>Try more general words. for example: If you want to search 'Mentoring for class 10', then use general keyword like 'Mentoring' 'Class' '10'.</li>
        <li>Try different words with similar meaning</li>
         <li>Please check your spelling</li>
         </ol>
                </div>
            </div>    
        </div>
	<?php } ?>
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 