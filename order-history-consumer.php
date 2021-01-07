\<?php include("includes/config.php"); checkuserlogin();?>

<!-- RWS Header Starts -->
<?php include("application/gtheader.php"); $pageuser = "Consumer";?>

<!-- RWS Header Starts -->

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap"> 

<div class="row">

	<?php include("application/left-sidebar.php"); ?>
    
    <?php
    $query="SELECT t1.* FROM ss_consumer_order as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id WHERE t1.user_id=".$_SESSION['GTUserID']." GROUP BY t1.order_id ORDER BY t1.dateoforder LIMIT 0, 100";
    $rs = $db->query($query);
    $foundnum = $rs->num_rows;
?>

    <div class="col-sm-9" id="rws-rightcolumn">

    	<div class="rws-module">

        	<h3>Your Order</h3>

            <div class="mcontent">

            	<div class="orderlist">
					
                	<?php if($foundnum>0) { ?>
                	<table class="rwsorderitems" cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<thead>
                        	<tr>
                                <th>Order No.</th>
                                <th>Service Name</th>
                                <th>Frentor</th>
                                <th>Dated</th>
                                <th>End Date</th>
                                <th>Hours</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
						$rowlist = $rs->rows;
						$j=1; foreach($rowlist as $key => $row) { 
						
						if($row["order_status"]==1) 
						{ 
							$order_status = 'Successful';
						}
						elseif($row["order_status"]==0) 
						{ 
							$order_status = 'Pending';
						}
						elseif($row["order_status"]==2) 
						{ 
							$order_status = '<strong>Completed</strong>';
						}
						else 
						{ 
							$order_status = 'Failed';
						}
						if(!empty($row["service_provider_name"])) { $gtclasstr = ' class="orderactive" '; } else { $gtclasstr = ' class="orderinactive" '; }
						?>
                        	<tr <?php echo $gtclasstr; ?>> 
                                <td><?php echo $row["order_reference_number"]; ?></td>
                                <td><?php echo $row["service_name"]; ?></td>
                                <td><?php if(!empty($row["service_provider_name"])) { echo $row["service_provider_name"]; } else { echo '-'; } ?></td>
                                <td><?php echo toshowdatetime($row["dateoforder"]); ?></td>
                                <td><?php echo toshowdatetime($row["enddate"]); ?></td>
                                <td><?php echo $row["totalhours"]; ?> Hours</td>
                                <td><?php echo $row["duration"]; ?> Days</td>
                                <td><?php echo $order_status; ?></td>
                                <td><div class="dropdown">
                                  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                                  		<?php if(tocheckorderschedule($row["order_id"])==0) { if(!empty($row["service_provider_name"])) {
										?>
                                        	<li><a href="<?php echo $baseurl.'schedule-classes.php?order_id='.$row["order_id"]; ?>">Schedule Classes</a></li>
                                        <?php
										}} else { 
										if($row["order_status"]==1)
										{
										?>
                                        	<li><a href="<?php echo $baseurl.'view-schedule.php?order_id='.$row["order_id"]; ?>">View Schedule</a></li>
                                        <?php 
										}
										else
										{
											if(tocheckorderreviewstatus($row["order_id"])==0) {
											?>
                                            <li><a href="<?php echo $baseurl.'rate-and-review-order.php?order_id='.$row["order_id"]; ?>">Rate &amp; Review</a></li>                                      <?php 
											}
											if($row["enddate"]>=date('Y-m-d')) 
											{
											?>
                                            <li><a href="<?php echo $baseurl.'service-details.php?service_id='.$row["services_id"]; ?>">Re Order</a></li>
                                            <?php
											}
										}
										
										} ?>
                                        <?php if($row["enddate"]<date('Y-m-d')) { ?>
                                        <li><a href="<?php echo $baseurl.'service-details.php?service_id='.$row["services_id"]; ?>">Re Order</a></li>
                                        <?php } ?>
                                        <!--<li><a href="#">Message</a></li>
                                        <li><a href="#">Request Cancel</a></li>-->
                                  </ul>
                                </div>
                                </td>
                            </tr>
                           <?php } ?> 
                        </tbody>
                    </table>
                    
                    <div class="rws-pagination" style="display:none;">

                	<nav aria-label="Page navigation">

                      <ul class="pagination">

                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>

                        <li class="active"><a href="#">1</a></li>

                        <li><a href="#">2</a></li>

                        <li><a href="#">3</a></li>

                        <li><a href="#">4</a></li>

                        <li><a href="#">5</a></li>

                        <li>

                          <a href="#" aria-label="Next">

                            <span aria-hidden="true">&raquo;</span>

                          </a>

                        </li>

                      </ul>

                    </nav>

                </div>
                
                    <?php } else { echo '<div id="rws-formfeedback">There is no order history.</div>'; }?>

                </div>

                

            </div>

        </div>

        <!-- ORDER Code Ends -->

        

        

    </div>

</div>

</div>

<!-- RWS Dashboard Ends -->

<!-- RWS Footer Starts -->

	<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 