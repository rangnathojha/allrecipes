<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
	$nquery="";
	$user_id = $_GET["user_id"];
	$query="SELECT t1.firstname, t1.lastname, t1.photograph, t1.location, t1.area, t1.city, t1.state, t1.pincode, t1.add_date, t1.cover_pic, t1.about_yourself, t2.resume_text, t2.occupation, t2.designation, t2.organization FROM ss_users as t1 LEFT JOIN ss_service_provider as t2 ON t1.user_id=t2.user_id WHERE t1.user_id=".$user_id.' GROUP BY t1.user_id';

	$rs = $db->query($query);
	$foundnum = $rs->num_rows;
	$row = $rs->row;
	
	if(file_exists($row["cover_pic"]))
	{
		$coverimage = $baseurl.$row["cover_pic"];
	}
	else
	{
		$coverimage = $baseurl.'images/idea-picture.jpg';
	}


?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">

	<h1 style="margin-top:0;"><?php echo $row["firstname"].' '.$row["lastname"]; ?></h1>

    

    <div class="row">
        <div class="col-sm-8"> 
        	<div class="rws-module">
        		<img src="<?php echo $coverimage; ?>" alt="<?php echo $row["firstname"].' '.$row["lastname"]; ?>" title="<?php echo $row["firstname"].' '.$row["lastname"]; ?>" class="img-responsive" style="width:100%;">   
            </div>
            
            <div class="rws-module">
        	<h3>Services Offered</h3>
            
            <div class="mcontent">
            	<?php 
				$query2 = "SELECT t1.service_id, t1.user_id, t1.price, t2.firstname, t2.lastname, t2.photograph, t2.location, t2.area, t2.city, t2.state, t2.pincode, t2.add_date, t3.resume_text, t3.occupation, t3.designation, t3.organization, t4.name, t4.description FROM ss_service_provider_services as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id LEFT JOIN ss_service_provider as t3 ON t1.user_id=t3.user_id INNER JOIN ss_services as t4 ON t1.service_id=t4.service_id WHERE t1.user_id=$user_id GROUP BY t1.service_id";
				
				$rs2 = $db->query($query2);
				$foundnum2 = $rs2->num_rows;
				$per_page = 30;
				
				$max_pages = ceil($foundnum2 / $per_page);	
				$pagenum = trim($_GET['PageNo']);	
				$max_pages = ceil($foundnum2 / $per_page);	
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
				
				if($orderfield !="") { $result = $db->query($query2." ORDER BY $orderfield $orderby LIMIT $start, $per_page"); }
				else { $result = $db->query($query2." ORDER BY name ASC LIMIT $start, $per_page"); }

				?>
                <?php $rowlist = $result->rows;
				$j=1; foreach($rowlist as $key => $rows) { 
            	echo '<div class="mentoring">
							<div class="row">
								<div class="col-sm-1">'.$j.'</div>
								<div class="col-sm-7">'.$rows["name"].'</div>
								<div class="col-sm-4"><a href="'.$baseurl.'service-details.php?service_id='.$rows["service_id"].'&amp;user_id='.$rows["user_id"].'" class="gtactivesession">Buy</a></div>
							</div>
						</div>';			
						
			$j++;
			}
			
			?> 
            </div>
        </div> 

        </div>

        <div class="col-sm-4">
        	<div class="rws-module">
            <div class="mcontent">

            	<div class="row">
                	<div class="col-lg-4 rwsprofileimg col-xs-4">
                    	<?php if(file_exists($row["photograph"])) { ?>
                            
                            <img src="<?php echo $row["photograph"]; ?>" alt="" title="" width="80" height="80" />
                        <?php  } else { ?>
                            <div class="gtprofileicon"><?php echo substr($row["firstname"],0,1); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-8 rwsrating  col-xs-8" style="padding-left:0px;">
                    	<p style="margin-bottom:5px;"><strong><?php echo $row["firstname"].' '.$row["lastname"]; ?></strong></p>
                        <p style="margin-bottom:5px;"><?php echo $row["city"]; ?></p>
                        <p  style="margin-bottom:0;"><?php echo $row["state"]; ?></p>
                   	<!--<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i> (<a href="#">26578</a>)--> </div>
                </div>

                <!--<div class="userinfo">
                	Response Rate <span>100%</span>
                </div>
                <div class="userinfo">
                	Order Completed <span>100%</span>
                </div>
                <div class="userinfo">
                	Delivery on Time <span>100%</span>
                </div>-->
            </div>
            </div>  

            <div class="rws-module">
                <div class="mcontent">
                	<p>Member Since <em><?php echo toshowdatetime($row["add_date"]); ?></em></p>
                    <?php if(!empty($row["about_yourself"])) { ?>
                        <h4>About</h4>
                        <div style="text-align:justify;"><?php echo $row["about_yourself"]; ?></div>
                    <?php } ?>                   
                </div> 
            </div>  

        </div>

    </div>

</div>

</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 