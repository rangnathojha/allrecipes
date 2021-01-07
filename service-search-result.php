<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
$nquery="";

$search_txt = $_GET["search_txt"];
if($search_txt!="")
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

	$query="SELECT t1.* FROM ss_services as t1 INNER JOIN ss_services_package as t2 ON t1.service_id=t2.service_id WHERE t1.service_id > 0 ".$nquery." group by t1.service_id ";

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
	else { $result = $db->query($query." ORDER BY package_id ASC LIMIT $start, $per_page"); }

	/* URL For Dynamic Order by and pagination*/
	if($orderfield !="") 
	{ 
		$urltoshow = "package-list.php?page=gclt&PageNo=".$pagenum."&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
		$urltosearch = "package-list.php?page=gclt&PageNo=1&field=".$orderfield."&order=".$orderby;
		$urltopage = "package-list.php?page=gclt&field=".$orderfield."&order=".$orderby.'&search='.$search_txt;
	 }
	else 
	{ 
		$urltoshow = "package-list.php?page=gclt&PageNo=".$pagenum.'&search='.$search_txt; 
		$urltosearch = "package-list.php?page=gclt&PageNo=1"; 
		$urltopage = "package-list.php?page=gclt&search=".$search_txt; 
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
					echo '<div class="col-sm-3">
							<a href="'.$baseurl.'service-details.php?service_id='.$row["service_id"].'">
							<div class="gtinnerlist">
								'.$row["name"].'
							</div>
						</a>
					</div>';
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