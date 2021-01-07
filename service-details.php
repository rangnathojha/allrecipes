<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
$nquery="";
	$service_id = $_GET["service_id"];
	$query="SELECT t1.* FROM ss_services as t1 INNER JOIN ss_services_package as t2 ON t1.service_id=t2.service_id WHERE t1.service_id='$service_id' GROUP BY t1.service_id";
	
	$query="SELECT t1.* FROM ss_services as t1 WHERE t1.service_id='$service_id'";

	$rs = $db->query($query);
	$foundnum = $rs->num_rows;
	$row = $rs->row;


?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
	<?php if($foundnum>0) { ?>	
    	<h1><?php echo $row["name"]; ?></h1>
        <?php include_once('application/package-list.php'); ?>     
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