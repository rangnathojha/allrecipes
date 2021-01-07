<?php include('header.php'); $gtpage = 'category-order-list'; $rwseditor=1; $gtdateopt="on"; checkadminroles('order');
$_SESSION['myForm']=array();

if(isset($_GET["fid"]))
{
	$select_query = "SELECT t1.*, t2.firstname, t2.lastname, t2.email FROM ss_consumer_order as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id WHERE t1.order_id=".$_GET["fid"]." AND t1.buy_from='CA'";
	
	$select_result = $db->query($select_query);
	$row = $select_result->row;

	$_SESSION['myForm']['order_id'] 				= stripslashes($row['order_id']);
	$_SESSION['myForm']['order_reference_number'] 	= stripslashes($row['order_reference_number']);
	$_SESSION['myForm']['user_id'] 					= stripslashes($row['user_id']);
	$_SESSION['myForm']['totalamount'] 				= stripslashes($row['totalamount']);
	$_SESSION['myForm']['services_id'] 				= stripslashes($row['services_id']);
	$_SESSION['myForm']['packages_id'] 				= stripslashes($row['packages_id']);
	$_SESSION['myForm']['service_provider_id'] 		= stripslashes($row['service_provider_id']);
	$_SESSION['myForm']['startdate'] 				= stripslashes($row['startdate']);
	$_SESSION['myForm']['enddate'] 					= stripslashes($row['enddate']);
	$_SESSION['myForm']['totalhours'] 				= stripslashes($row['totalhours']);
	
	$_SESSION['myForm']['totalusedhour'] 			= todisplaypath($row['totalusedhour']);
	
	$_SESSION['myForm']['service_name'] 			= stripslashes($row['service_name']);
	$_SESSION['myForm']['package_name'] 			= stripslashes($row['package_name']);
	$_SESSION['myForm']['discountcost'] 			= stripslashes($row['discountcost']);
	$_SESSION['myForm']['service_provider_name'] 	= stripslashes($row['service_provider_name']);
	$_SESSION['myForm']['order_status'] 			= stripslashes($row['order_status']);
	$_SESSION['myForm']['discounted_hour'] 			= stripslashes($row['discounted_hour']);
	$_SESSION['myForm']['duration'] 				= stripslashes($row['duration']);
	$_SESSION['myForm']['package_price'] 			= stripslashes($row['package_price']);
	
	$_SESSION['myForm']['hourly_cost'] 				= stripslashes($row['hourly_cost']);
	$_SESSION['myForm']['discounted_hourly_cost'] 	= stripslashes($row['discounted_hourly_cost']);
	$_SESSION['myForm']['services_package_id'] 		= stripslashes($row['services_package_id']);
	$_SESSION['myForm']['buy_from'] 				= stripslashes($row['buy_from']);

	$product_categories = $_SESSION['myForm']['service_provider_name'];


	$reg_title = 'Edit Category Order';
	$reg_subtitle = 'Category Order Edit Page';
	$reg_breadcrumb = 'Edit Category Order';
	$reg_button = 'Update';
}
else
{	
	$reg_title = 'Add New Package Service';
	$reg_subtitle = 'Package Service Add Page';
	$reg_breadcrumb = 'Add New Package Service';
	$reg_button = 'Save';
	if($_SESSION['myForm']['status']=="")
	{
		$_SESSION['myForm']['status'] = '1';
	}
}

?>



        <div class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Left side column. contains the logo and sidebar -->

            <?php include('sidebar.php'); ?>



            <!-- Right side column. Contains the navbar and content of the page -->

            <aside class="right-side">

                <!-- Content Header (Page header) -->

                <section class="content-header">
                    <h1>
                        <?php echo $reg_title; ?>
                        <small><?php echo $reg_subtitle; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo $baseurl; ?>master/category-order-list.php"><i class="fa fa-leaf"></i> Category Order List </a></li>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>
                    </ol>
                </section>



                <!-- Main content -->
                <section class="content">
                <form role="form" name="rwsglobalform"  id="rwsglobalform" action="category-order-assign-form.php" method="post" enctype="multipart/form-data">

                	<div class="row">

                        <div class="col-md-12">

                        <?php if(!empty($errors)) {

                            echo '<div id="gt-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
                                foreach ($errors as $msg) { //prints each error
                                echo "<li>$msg</li>";
                                } // end of foreach
                                echo '</ul></div>'; }                                

                                if($msg_result !="") { echo $msg_result; }
								if($_SESSION["gtThanksMSG"] !="") { echo $_SESSION["gtThanksMSG"]; unset($_SESSION["gtThanksMSG"]); }
                        ?>

                        </div>

                    </div>

					<div class="row">
                    	<div class="col-md-12">
                        	<div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Category Order Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<?php if($_GET['fid']!="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $row['order_id']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">
                                    
                                    	<div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Order Reference Number</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['order_reference_number']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Customer Name</label></div>
                                            <div class="col-md-10">
                                                <?php echo $row['firstname'].' '.$row['lastname']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Amount Paid(in Rs.)</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['totalamount']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Service Name</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['service_name']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Package</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['package_name']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Total Hours</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['totalhours']; ?> Hours
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Duration</label></div>
                                            <div class="col-md-10">
                                                <?php echo $_SESSION['myForm']['duration']; ?> Days
                                            </div>
                                        </div>
                                                                                
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Frentor Name<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                                <?php if(empty($row["service_provider_id"]))
												{
													echo '<span style="color:#525e66; font-weight:bold;">Not Assigned</a>';														
												}
												else
												{
													echo '<span style="color:#556652; font-weight:bold;">'.$row["service_provider_name"].'</span>';										
												}											
												?>
                                            </div>
                                        </div>
                                       
                                    </div><!-- /.box-body -->                                    
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-footer" style="text-align:center">
                                          <button class="btn btn-primary" type="submit" name="rws-submit"> <?php echo $reg_button; ?> </button>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='category-order-list.php'"> Back </button>
                                     </div>
                                </div>
                            </div>
                        </div>
                        </form> 
              </section><!-- /.content -->
              <footer>
              		<?php include('footer-copyright.php'); ?>
              </footer>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->        
<?php include('footer.php'); ?>