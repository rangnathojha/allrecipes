<?php 
$query_login="SELECT * FROM `ss_users` WHERE `user_id`='".$_SESSION['GTUserID']."' ";	
$result = $db->query($query_login);
$row = $result->row;

if($_SESSION['GTUserType']=="C")	{ ?>
<div class="col-sm-3" id="rws-leftcolumn">    		
    <div class="rws-module">
        <h3>Welcome <?php echo $_SESSION['GTUserFirstName'];?></h3>
        <div class="mcontent">
            <div class="row">
                <div class="col-lg-5 rwsprofileimg   col-xs-4">
                    <?php if(!empty($row["photograph"])) { ?>
                    <img src="<?php echo $row["photograph"]; ?>" alt="" title="" width="80" height="80" />
                    <?php } else { ?>
                    <div class="gtprofileicon"><?php echo substr($_SESSION['GTUserFirstName'],0,1); ?></div>
                    <?php } ?>
                </div>
                <div class="col-lg-7 rwsrating   col-xs-8" style="padding-left:0px;">
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><br/>
                <a href="edit-profile.php">Edit Profile</a><br/>
                <a href="<?php echo $baseurl; ?>service-sub-list.php?service_id=1">Browse Package</a><br/>
                <a href="<?php echo $baseurl; ?>order-history-consumer.php">Order History</a><br/>
                <a href="change-password.php">Change Password</a> <br />
				<?php 
				if($_SESSION['GTUserType']=="B") 
				{ 
					if($_SESSION["gtpagedb"]=="C") { echo '<a href="dashboard-service-provider.php">Frentor Dashboard</a>'; } 
					else { echo '<a href="dashboard-consumer.php">Consumer Dashboard</a>'; } 
				} 
				else
				{
					if($_SESSION["gtpagedb"]=="C") { 
						echo '<a href="become-a-frentor.php">Become Frentor</a>'; 
					}
					else
					{
						echo '<a href="become-a-consumer.php">Become Consumer</a>'; 
					}
				}
				?>
                
                </div>
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
</div>
<?php } else { 

if($pageuser=="Consumer")
{
	?>
    <div class="col-sm-3" id="rws-leftcolumn">    		
    <div class="rws-module">
        <h3>Welcome <?php echo $_SESSION['GTUserFirstName'];?></h3>
        <div class="mcontent">
            <div class="row">
                <div class="col-lg-5 rwsprofileimg   col-xs-4">
                    <?php if(!empty($row["photograph"])) { ?>
                    <img src="<?php echo $row["photograph"]; ?>" alt="" title="" width="80" height="80" />
                    <?php } else { ?>
                    <div class="gtprofileicon"><?php echo substr($_SESSION['GTUserFirstName'],0,1); ?></div>
                    <?php } ?>
                </div>
                <div class="col-lg-7 rwsrating   col-xs-8" style="padding-left:0px;">
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><br/>
                <a href="edit-profile.php">Edit Profile</a><br/>
                <a href="<?php echo $baseurl; ?>service-sub-list.php?service_id=1">Browse Package</a><br/>
                <a href="<?php echo $baseurl; ?>order-history-consumer.php">Order History</a><br/>
                <a href="change-password.php">Change Password</a> <br />
				<?php 
				if($_SESSION['GTUserType']=="B") 
				{ 
					if($_SESSION["gtpagedb"]=="C") { echo '<a href="dashboard-service-provider.php">Frentor Dashboard</a>'; } 
					else { echo '<a href="dashboard-consumer.php">Consumer Dashboard</a>'; } 
				} 
				else
				{
					if($_SESSION["gtpagedb"]=="C") { 
						echo '<a href="become-a-frentor.php">Become Frentor</a>'; 
					}
					else
					{
						echo '<a href="become-a-consumer.php">Become Consumer</a>'; 
					}
				}
				?>
                
                </div>
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
</div>
    <?php
}
else
{

?>



<div class="col-sm-3" id="rws-leftcolumn">
    	<div class="rws-module">
           	<h3>Welcome <?php echo $_SESSION['GTUserFirstName'];?></h3>
            <div class="mcontent">
            	<div class="row">
                	<div class="col-sm-5 rwsprofileimg  col-xs-4">
                    	<?php if(!empty($row["photograph"])) { ?>
                    	<img src="<?php echo $row["photograph"]; ?>" alt="" title="" width="80" height="80" />
                        <?php } else { ?>
                        <div class="gtprofileicon"><?php echo substr($_SESSION['GTUserFirstName'],0,1); ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-7 rwsrating  col-xs-6" style="padding-left:0px;">
                   	<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i> 
                    <br/>
                    <a href="edit-profile-sp.php">Edit Profile</a><br/>
                    <a href="change-password.php">Change Password</a> <br/>
                    
					<?php 
					
					if($_SESSION['GTUserType']!="C") 
					{
						echo '<a href="sp-services-list.php">My Services</a><br/>'; 
						echo '<a href="sp-services-hour-list.php">My Service Hours</a><br/>'; 
						echo '<a href="order-history-service-provider.php">Order History</a><br/>'; 
					}
					
					
				if($_SESSION['GTUserType']=="B") 
				{ 
					if($_SESSION["gtpagedb"]=="C") { echo '<a href="service-sub-list.php?service_id=1">Browse Package</a><br/><a href="dashboard-service-provider.php">Frentor Dashboard</a>'; } 
					else { echo '<a href="dashboard-consumer.php">Consumer Dashboard</a>'; } 
				} 
				else
				{
					if($_SESSION["gtpagedb"]=="C") { 
						echo '<a href="user-change-type.php">Become Frentor</a>'; 
					}
					else
					{
						echo '<a href="user-change-type.php">Become Consumer</a>'; 
					}
				}
				?>
                    </div>
                    
                </div>
            </div>
        </div>        
		<?php if($pageuser!="Consumer") { ?>
        <div class="rws-module">
        	<h3>Your Days Availability</h3>
            <div class="mcontent">            	
				<?php
				 $query="SELECT * FROM ss_service_provider_availability WHERE service_provider_availablity_id > 0 AND user_id='".$_SESSION['GTUserID']."' LIMIT 0, 5 ";
				$rs = $db->query($query);
				$foundnum = $rs->num_rows;				
				if($foundnum>0) { 
				$rowlist = $rs->rows;
				foreach($rowlist as $key => $row) { ?>				
                <div class="userinfo">
                	<?php echo $array_daysnew[$row["day"]]; ?> <span><?php echo $array_timeslot[$row["start_time"]]; ?> to <?php echo $array_timeslot[$row["end_time"]]; ?></span>
                </div>
				<?php } } else { echo 'There is no schedule added yet!. <a href="sp-services-hour-list.php">Click here to add</a>';} ?>
            </div>
        </div>
        
        <?php if($foundnum>0) { ?>
        
        <div class="rws-module">
        	<h3>Bank Account Details</h3>
            <div class="mcontent">            	
				<?php
				 $query="SELECT * FROM ss_service_provider_bank_account_details WHERE service_provider_bank_account_details_id > 0 AND service_provider_id='".$_SESSION['GTUserID']."'";
				$rs = $db->query($query);
				$foundnum = $rs->num_rows;				
				if($foundnum>0) { 
				$rowac = $rs->row;
				?>				
                <div class="userinfo">
                	<?php echo $rowac["accountname"]; ?>
                </div>
                <div class="userinfo">
                	<?php echo $rowac["accountnubmer"]; ?>
                </div>
                <div class="userinfo">
                	<?php echo $rowac["ifsccode"]; ?>
                </div>
                <div class="userinfo">
                	<?php echo $rowac["bankname"]; ?>
                </div>
                <div class="userinfo">
                	<?php echo $rowac["bankaddress"]; ?>
                </div>
                <div class="userinfo">
                	<?php if($rowac["status"]==1) { echo "Approved"; }  ?>
                    <?php if($rowac["status"]==2) { echo "Disapproved"; }  ?>
                    <?php if($rowac["status"]==0) { echo "Pending"; }  ?>
                    
                </div>
				<?php } else { echo '<a href="sp-back-account.php">Click here to add Bank Account Details</a>';} ?>
            </div>
        </div>
        
        <?php } ?>
        <?php } ?>
        
    </div>
<?php } } ?>