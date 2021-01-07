<?php include('../includes/config.php');
/*print("<pre>");
print_r($_POST);
print("</pre>");*/
if(!empty($_POST["service_provider"]))
{
	
	$_SESSION['myForm'] = $_POST;

	$service_provider_id 				= addslashes($_POST["service_provider_id"]);
	$post_id			 				= addslashes($_POST["post_id"]);
	$service_provider	 				= addslashes($_POST["service_provider"]);
	$duration							= $_POST["duration"];	
	// Form Validation Code

	$errors = array(); //Initialize error array 

	if(empty($errors)) {		
		// UPLOAD FILE CODE STARTS 

		if(trim($post_id)!="")
		{
			$startdate = date('Y-m-d');
			$enddate 					= date('Y-m-d', strtotime("+$duration day"));
			
			$update_query = "UPDATE `ss_consumer_order` SET `service_provider_id` = '$service_provider_id', `service_provider_name` = '$service_provider', `startdate` = '$startdate', `enddate` = '$enddate' WHERE `order_id`= '$post_id'";
			$update_result = $db->query($update_query);		
			
			// Send Email to Consument and Frentor BOTH
			
			$select_query = "SELECT t1.*, t2.firstname, t2.lastname, t2.email, t3.firstname as sp_firstname, t3.lastname as sp_lastname, t3.email as sp_email FROM ss_consumer_order as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id INNER JOIN ss_users as t3 ON t1.service_provider_id=t3.user_id WHERE t1.order_id=".$post_id." AND t1.buy_from='CA'";
	
			$select_result = $db->query($select_query);
			$row = $select_result->row;
			
			$order_reference_number = $row["order_reference_number"];
			$startdate 				= $row["startdate"];
			$enddate 				= $row["enddate"];
			$totalhours 			= $row["totalhours"];
			$service_name 			= $row["service_name"];
			$package_name 			= $row["package_name"];
			$service_provider_name 	= $row["service_provider_name"];
			$duration 				= $row["duration"];
			$package_price 			= $row["package_price"];
			
			
			$firstname 				= $row["firstname"];
			$lastname 				= $row["lastname"];
			$email 					= $row["email"];
			
			/* Email to Consumer Code Starts */
			$subject = "$sitename - Frentor added for $order_reference_number";

			$body =  $emailheader.'
				  <tr>				
					<td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">				
					  <tr>				
						<td height="22" colspan="2" align="left" valign="middle">Hello '.$firstname.',<br><br>						
						Frentor has been added for your order reference number '.$order_reference_number.'<br />
						<br />
						Here is the complete details for your order.<br />
						<br />
						<strong>Service Name:</strong> '.$service_name.'<br/>
						<strong>Package Name:</strong> '.$package_name.'<br/>
						<strong>Start Date:</strong> '.$startdate.'<br/>
						<strong>End Date:</strong> '.$enddate.'<br/>
						<strong>Total Hours:</strong> '.$totalhours.'<br/>
						<strong>Duration:</strong> '.$duration.'<br/><br/>
						<strong>Frentor:</strong> '.$service_provider_name.'	
				<br />
				<br />
				<strong>Shaping Steps Admin</strong>
				<br />
				<br />
				</td>				
						</tr>   
					   <tr>
						<td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>
						</tr>'.$emailfooter;
				
			sendmail($email,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
			// echo "<br/><br/><br/><br/>";
			/* Email to Consumer Code Ends */
			
			$sp_firstname = $row["sp_firstname"];
			$sp_lastname = $row["sp_lastname"];
			$sp_email = $row["sp_email"];
			
			/* Email to Consumer Code Starts */
			$subject = "$sitename - Frentor added for $order_reference_number";

			$body =  $emailheader.'
				  <tr>				
					<td align="left" valign="middle"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF; padding:0 20px;">				
					  <tr>				
						<td height="22" colspan="2" align="left" valign="middle">Hello '.$sp_firstname.',<br><br>						
						Shaping Steps Admin added you for order reference number '.$order_reference_number.'<br />
						<br />
						Here is the complete details of order.<br />
						<br />
						<strong>Service Name:</strong> '.$service_name.'<br/>
						<strong>Package Name:</strong> '.$package_name.'<br/>
						<strong>Start Date:</strong> '.$startdate.'<br/>
						<strong>End Date:</strong> '.$enddate.'<br/>
						<strong>Total Hours:</strong> '.$totalhours.'<br/>
						<strong>Duration:</strong> '.$duration.'<br/><br/>
						<strong>Consumer Name:</strong> '.$firstname.'	'.$lastname.'	
				<br />
				<br />
				<strong>Shaping Steps Admin</strong>
				<br />
				<br />
				</td>				
						</tr>   
					   <tr>
						<td height="1" colspan="2" align="left" valign="middle" bgcolor="#e5e5e5"></td>
						</tr>'.$emailfooter;
				
			sendmail($sp_email,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
			
			/* Email to Consumer Code Ends */
	
			
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Frentor has been assigned successfully.!</div>';
			echo "<script>document.location.href='category-order-assign.php?fid=".$post_id."'</script>";	
		}
		else
		{
			echo "<script>document.location.href='category-order-assign.php'</script>";

		}
		unset($_SESSION['myForm']);
	}
}
?>