<?php include("includes/config.php"); checkuserlogin(); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
/*print_r($_SESSION["Cart"]);*/

if(isset($_SESSION["Cart"]))
{
	
$total_quantity ="";
$total_price ="";
foreach($_SESSION["Cart"] as $key=>$val) {
		$total_quantity +=$val["quantity"];
		$total_price +=$val["package_price"];		
}
/*print("<pre>");
print_r($_SESSION["Cart"]);
print("</pre>");*/
if(isset($_POST["gtproceedtopayment"]))
{
	$payment_method = $_POST["payment_method"];	
	
	foreach($_SESSION["Cart"] as $key=>$val) {
		
		
		$services_id 				= $val["service_id"];
		$packages_id 				= $val["package_id"];
		$services_package_id 		= $val["services_package_id"];		
		$totalhours 				= $val["total_hours"];
		$service_name 				= $val["service_name"];
		$package_name 				= $val["package_name"];
		$discountcost 				= "";
		$discounted_hour 			= "";
		$duration 					= $val["duration"];
		$package_price 				= $val["package_price"];
		$hourly_cost 				= $val["hourly_cost"];
		$discounted_hourly_cost 	= $val["discounted_hourly_cost"];
		
		$startdate 					= date('Y-m-d');
		$enddate 					= date('Y-m-d', strtotime("+$duration day"));
		
		if(isset($val["service_provider_id"]))
		{
			$buy_from = 'SP';
		}
		else
		{
			$buy_from = 'CA';
		}
		
		$order_status = 0;
		
		
		$query_insert = "INSERT INTO `ss_consumer_order` SET user_id = '".$_SESSION['GTUserID']."', totalamount = '$total_price', services_id = '$services_id', packages_id = '$packages_id', service_provider_id = '', startdate = '$startdate', enddate = '$enddate', dateoforder = '$gtcurrenttime', totalhours = '$totalhours', totalusedhour = '$totalusedhour', service_name = '$service_name', package_name = '$package_name', discountcost = '$discountcost', service_provider_name = '$service_provider_name', order_status = '$order_status', discounted_hour = '$discounted_hour', duration = '$duration', package_price = '$package_price', hourly_cost = '$hourly_cost', discounted_hourly_cost = '$discounted_hourly_cost', services_package_id='$services_package_id', buy_from='$buy_from'";
				
		$update_result = $db->query($query_insert);
		
		$insertedid= $db->getLastId();
		
		$order_reference_number = 'SSOD'.date('Ymd').$insertedid;
		
		$orn = base64_encode('SSOD-'.$insertedid);
		
		$query_update = "UPDATE `ss_consumer_order` SET order_reference_number = '$order_reference_number' WHERE order_id=".$insertedid;
		
		$update_result = $db->query($query_update);
		
		unset($_SESSION["Cart"]);
		
		echo "<script>document.location.href='".$baseurl."payupayment.php?orn=".$orn."'</script>";
		die();
	}
	
	
}

?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
	<div class="col-sm-4 col-sm-offset-4 rws-userformdesign">
    
    <h1 class="gt-formtitle">Payment Method</h1>
    <form name="rwspaymentgateway" id="rwspaymentgateway" method="post" action="" enctype="multipart/form-data">
    <div class="rws-fields">
    <input type="radio" id="payment_method_1" name="payment_method" value="PayU" checked="checked" required="required" />&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/payumoney.gif" alt="PayU Money"
     /></div>
    
    <div class="rws-fields">
    Amount to be Paid: <strong><?php echo $total_price; ?></strong>
    
    </div>
    <div class="rws-fields">
    	<button type="submit" name="gtproceedtopayment" id="gtproceedtopayment" class="btn btn-primary" >Pay Now</button>
    </div>
    
    </form>
    
    </div>
       
</div>
<!-- RWS Dashboard Starts -->        
<?php } else {  echo "<script>document.location.href='http://www.shapingsteps.com/'</script>"; } ?>
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 