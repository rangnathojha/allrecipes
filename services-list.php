<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php include("application/gtheader.php");
$service_id=$_GET["service_id"]; 
$services_category = getlistofsubservicesall($service_id)."'$service_id'";

$query = "SELECT t1.service_id, t1.user_id, t1.price, t2.firstname, t2.lastname, t2.photograph, t2.location, t2.area, t2.city, t2.state, t2.pincode, t2.add_date, t3.resume_text, t3.occupation, t3.designation, t3.organization, t4.name, t4.description FROM ss_service_provider_services as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id LEFT JOIN ss_service_provider as t3 ON t1.user_id=t3.user_id INNER JOIN ss_services as t4 ON t1.service_id=t4.service_id WHERE t1.service_id IN ($services_category) GROUP BY t1.user_id";

$rs = $db->query($query);
$foundnum = $rs->num_rows;
$per_page = 30;

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
echo $query." ORDER BY firstname ASC LIMIT $start, $per_page"*/	

if($orderfield !="") { $result = $db->query($query." ORDER BY $orderfield $orderby LIMIT $start, $per_page"); }
else { $result = $db->query($query." ORDER BY firstname ASC LIMIT $start, $per_page"); }


?>
<!-- RWS Header Starts -->
<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">
<h1><?php echo getservicename($service_id); ?></h1>
<?php if($foundnum>0) { ?>
    <div class="row">
	<!--<div class="col-sm-3" id="rws-leftcolumn">
    	<div class="rws-module">
            <h3 style="text-align:left;">Category <span><a href="javascript:void(0);" class="gtclearcategory">Clear</a></span></h3>
            <div class="gt-modulecontent"> 
                <ul>
                    <li><input class="gtcategoryfilter" value="6" name="gtcategory[]" type="checkbox"> Books &amp; Educational</li>
                    <li><input class="gtcategoryfilter" value="34" name="gtcategory[]" type="checkbox"> Dance</li>
                    <li><input class="gtcategoryfilter" value="50" name="gtcategory[]" type="checkbox"> Fun</li>
                    <li><input class="gtcategoryfilter" value="64" name="gtcategory[]" type="checkbox"> Games &amp; Indoor Activity</li>
                    <li><input class="gtcategoryfilter" value="7" name="gtcategory[]" type="checkbox"> Music</li>
                    <li><input class="gtcategoryfilter" value="9" name="gtcategory[]" type="checkbox"> Parenting</li>
                    <li><input class="gtcategoryfilter" value="1" name="gtcategory[]" type="checkbox"> Quizzing, Debating &amp; Elocution</li>
                    <li><input class="gtcategoryfilter" value="8" name="gtcategory[]" type="checkbox"> Sports and Outdoor Activities</li>
                </ul>
            </div>
        </div>         

        <div class="rws-module">
            <h3 style="text-align:left;">Date <span><a href="javascript:void(0);" class="gtclearcategory">Clear</a></span></h3>
            <div class="gt-modulecontent"> 
                <ul>
                	<li><input class="gtcategoryfilter" value="6" name="gtcategory[]" type="checkbox"> Books &amp; Educational</li>
                    <li><input class="gtcategoryfilter" value="34" name="gtcategory[]" type="checkbox"> Dance</li>
                    <li><input class="gtcategoryfilter" value="50" name="gtcategory[]" type="checkbox"> Fun</li>
                    <li><input class="gtcategoryfilter" value="64" name="gtcategory[]" type="checkbox"> Games &amp; Indoor Activity</li>
                    <li><input class="gtcategoryfilter" value="7" name="gtcategory[]" type="checkbox"> Music</li>
                    <li><input class="gtcategoryfilter" value="9" name="gtcategory[]" type="checkbox"> Parenting</li>
                    <li><input class="gtcategoryfilter" value="1" name="gtcategory[]" type="checkbox"> Quizzing, Debating &amp; Elocution</li>
                    <li><input class="gtcategoryfilter" value="8" name="gtcategory[]" type="checkbox"> Sports and Outdoor Activities</li>
                </ul>
            </div>
        </div>        

        <div class="rws-module">
            <h3 style="text-align:left;">Order by <span><a href="javascript:void(0);" class="gtclearcategory">Clear</a></span></h3>
            <div class="gt-modulecontent">  
                <ul>
                	<li><input class="gtcategoryfilter" value="6" name="gtcategory[]" type="checkbox"> Money Paid by Frentor</li>
                    <li><input class="gtcategoryfilter" value="34" name="gtcategory[]" type="checkbox"> Perfromance</li>
                </ul>
            </div>
        </div>
    </div>-->

    <div class="col-sm-12" id="rws-rightcolumn">
		<div class="row">
        	<?php $rowlist = $result->rows;
				$j=1; foreach($rowlist as $key => $row) { 
            	echo '<div class="col-sm-3">
                <div class="rwslistcontent">
                <div class="gtlistimg"><img src="images/idea-picture.jpg" alt="" title="" class="img-responsive" ></div>
                <div class="gtlisttitle">'.$row["firstname"].' '.$row["lastname"].'</div>
                <div class="gtlistdate">Member Since <span>'.toshowdatetime($row["add_date"]).'</span></div>
                <div class="gtlistexcert">'.$row["location"].'</div>
                <div class="gtlistreadmore"><a href="service-provider-details.php?user_id='.$row["user_id"].'" title="">Read More</a></div>
                </div>
            </div>';			
			if($j%4==0) { echo '<div class="clearfix"></div>'; }
			
			$j++;
			}
			
			?>

        </div>

        



        <!-- Mentoring Ends -->



    </div>



</div>
<?php } else { echo '<div id="rws-formfeedback">Sorry There is no services listed under <strong>'.getservicename($service_id).'</strong></div>'; } ?>

</div>

<!-- RWS Dashboard Starts -->        



<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 