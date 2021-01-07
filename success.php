<?php include("includes/config.php"); checkuserlogin();

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$udf1=$_POST["udf1"];
$salt="w8mPqeIDtq";

/*print("<pre>");
print_r($_POST);
print("</pre>");*/
// Salt should be same Post Request 

if($status=="success") {
		  
	$orn = str_replace('SSOD-','',base64_decode($udf1));

	$query = "SELECT * FROM `ss_consumer_order` WHERE `order_id`='$orn' AND `user_id`='".$_SESSION['GTUserID']."' AND `order_status`='0'";
	$result = $db->query($query);
	$foundnum = $result->num_rows;
	
	$row = $result->row;
	if($foundnum>0) {
		
		
	$service_name 				= 	$row["service_name"];  
	$package_name 				= 	$row["package_name"];  
	$total_price 				= 	$row["totalamount"];  
	$totalhours 				= 	$row["totalhours"]; 
	
	$duration 					= 	$row["duration"];  
	$enddate 					= 	$row["enddate"];   
	$order_reference_number 	= 	$row["order_reference_number"];   
	
	/* UPDATE Status */
	
	$query_update = "UPDATE `ss_consumer_order` SET `order_status` = '1', `txid` = '$txnid' WHERE `order_id`='$orn' AND `user_id`='".$_SESSION['GTUserID']."' AND `order_status`='0'";
		
	$update_result = $db->query($query_update);

/* Send Email to Admin */
		
		$subject = "Order Notification - ".$_SESSION['GTUserFirstName']." has placed an order on $sitename Reference ID [$order_reference_number]";
		
		$body = $emailheader.'
	  <tr>
		<td style="padding:10px; margin:0; font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left">
		Dear Admin,<br/><br/>
		'.$_SESSION['GTUserFirstName'].' has placed an order with reference ID '.$order_reference_number.'.<br/><br/>		
		Here is the complete details
		<br/><br/>
		<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="25%">Service</td>
    <td>'.$service_name.'</td>
  </tr>
  <tr>
    <td>Package</td>
    <td>'.$package_name.'</td>
  </tr>
  <tr>
    <td>Paid Amount</td>
    <td>'.$total_price.'</td>
  </tr>
  <tr>
    <td>Total Hours</td>
    <td>'.$totalhours.'</td>
  </tr>
  <tr>
    <td>Duration</td>
    <td>'.$duration.'</td>
  </tr>
  <tr>
    <td>End Date</td>
    <td>'.$enddate.'</td>
  </tr>  
</table>
		</td>
	  </tr>
	  
	  </tr>
	  '.$emailfooter;
	
	
			
			sendmail($admin_toemail,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
		
		
		/* Send Email to User */
		
		$subject = "Order Confirmation - Your Order with $sitename [$order_reference_number] has been successfully placed!";
			$body = $emailheader.'
	  <tr>
		<td style="padding:10px;margin:0;font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left">
		Dear '.$_SESSION['GTUserFirstName'].', your order has been placed successfully. Your order reference number is "<em>'.$order_reference_number.'</em>".<br/><br/>		
		Here is the complete order details.
		<br/><br/>
		<table width="100%" border="0" cellspacing="5" cellpadding="5">
		  <tr>
			<td width="25%">Service</td>
			<td>'.$service_name.'</td>
		  </tr>
		  <tr>
			<td>Package</td>
			<td>'.$package_name.'</td>
		  </tr>
		  <tr>
			<td>Paid Amount</td>
			<td>'.$total_price.'</td>
		  </tr>
		  <tr>
			<td>Total Hours</td>
			<td>'.$totalhours.'</td>
		  </tr>
		  <tr>
			<td>Duration</td>
			<td>'.$duration.'</td>
		  </tr>
		  <tr>
			<td>End Date</td>
			<td>'.$enddate.'</td>
		  </tr>  
		</table>
		</td>
	  </tr>	  
	  '.$emailfooter;	
			
		sendmail($_SESSION['GTUserEmail'],$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
		
		$_SESSION['GTThanksMSG']='<div id="rws-formsuccess">Thank you for ordering '.$service_name.' '.$package_name.' Package. An email has been sent with your order summary. </div>';
		
	}
		
		 
       
		   } else {
			   
			 $_SESSION['GTThanksMSG']='<div id="rws-formfeedback">Sorry, we are unable to process your payment. Please try again.</div>';
			   }


?>

<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<!-- RWS Header Starts -->  
<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">
    <?php 
		if(isset($_SESSION['GTThanksMSG'])) { echo $_SESSION['GTThanksMSG']; unset($_SESSION['GTThanksMSG']); } else { 
		/*echo "<script>document.location.href='http://www.shapingsteps.com/'</script>"; */
        }
	?>
</div>
<!-- RWS Dashboard Starts -->
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 