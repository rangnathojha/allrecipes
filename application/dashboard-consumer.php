<div class="row">
	<?php include("application/left-sidebar.php"); ?>
    
    <div class="col-sm-9" id="rws-rightcolumn">
    <h1 style="margin-top:0; margin-bottom:20px;">Consumer Dashboard</h1>
    <?php if(isset($_SESSION["GtThanksMsg"])) { echo $_SESSION["GtThanksMsg"]; unset($_SESSION["GtThanksMsg"]); } ?>
    
    	<div class="rws-module">
        	<h3>Today Classes</h3>
            <div class="mcontent">
            
            	<div class="mcontent gtscheduletimesection">
                    <?php 
					$today_date = date('Y-m-d');
					$query = "SELECT * FROM `ss_services_provider_hour_tracking` WHERE `consumer_id`='".$_SESSION['GTUserID']."' and `dateofclass`='$today_date' ORDER BY dateofclass, starttime ASC";
	
					$rs = $db->query($query);
					$foundnum = $rs->num_rows;
					
					if($foundnum==0)
					{
						echo '<div id="rws-forminfo">There is no mentoring today.</div>';
					}
					
					$rowlist = $rs->rows;
					
					
					
						if($foundnum>0)
						{
							$stringhtml .='<div class="gtsselecthead"><div class="row"><div class="col-sm-3">Date</div><div class="col-sm-5">Time</div><div class="col-sm-4">Status</div></div></div>';
							foreach($rowlist as $key => $value) 
							{
								if($value["status"]==1) { $textstatus = 'Pending'; }
								if($value["status"]==2) { $textstatus = 'Class Done'; }
								if($value["status"]==3) { $textstatus = 'Completed'; }
								
								$stringhtml .= '<div class="gtfieldvalue"><div class="row"><div class="col-sm-3">'.$value["dateofclass"].'</div><div class="col-sm-5">'.date("h A", strtotime($value["dateofclass"].' '.$value["starttime"])).' To '.date("h A", strtotime($value["dateofclass"].' '.$value["endtime"])).'</div><div class="col-sm-4">'.$textstatus.'</div></div></div>';
							}
							
							echo $stringhtml;
							
						}
					
					?>
                    </div>
                                
                
            </div>
        </div>
        <!-- Mentoring Ends -->
        <?php
        $query="SELECT t1.* FROM ss_consumer_order as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id WHERE t1.user_id=".$_SESSION['GTUserID']." GROUP BY t1.order_id ORDER BY t1.dateoforder LIMIT 0,5";
		$rs = $db->query($query);
		$foundnum = $rs->num_rows;
        ?>
        <div class="rws-module">
        	<h3>Your Orders</h3>
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
                        	<tr <?php echo $gtclasstr;?>>
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
                                  		<?php if(tocheckorderschedule($row["order_id"])==0) { 
										if(!empty($row["service_provider_name"])) {
										?>
                                        	<li><a href="<?php echo $baseurl.'schedule-classes.php?order_id='.$row["order_id"]; ?>">Schedule Classes</a></li>
                                        <?php
										}
										 } else { 
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
                    <?php } else { echo '<div id="rws-formfeedback">There is no order history.</div>'; }?>
                    
                </div>
                <p style="text-align:right; margin-top:10px;"><a href="order-history-consumer.php">View All &raquo;</a></p>
            </div>
        </div>
        <!-- ORDER Code Ends -->
        
        
    </div>
</div>