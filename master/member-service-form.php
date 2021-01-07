<?php include('../includes/config.php');   checkadminroles('members');
/*print("<pre>");
print_r($_POST);
print("</pre>");*/
if(!empty($_POST["price"]))
{
	
	$_SESSION['myForm'] = $_POST;

	$price		 				= addslashes($_POST["price"]);	
	$user_id					= addslashes($_POST["user_id"]);		
	$post_id 					= $_POST["post_id"];
	$service_id 				= $_POST["parent_id"];	
	
	$product_category 				= $_POST["product_category"];	
	
	// Form Validation Code

	$errors = array(); //Initialize error array 
/*
	if (empty($_POST['title']) ) 					{	$errors[]="Package Subtitle field can't be blank!";			}
	if (empty($_POST['package_name']) ) 			{	$errors[]="Package Name field can't be blank!";				}
	if (empty($_POST['package_price']) ) 			{	$errors[]="Package Price field can't be blank!";			}
	if (empty($_POST['duration']) ) 				{	$errors[]="Duration field can't be blank!";					}
	if (empty($_POST['total_hours']) ) 				{	$errors[]="Total Hours field can't be blank!";				}
	if (empty($_POST['hourly_cost']) ) 				{	$errors[]="Hourly Cost field can't be blank!";				}
	if (empty($_POST['discounted_hourly_cost']) ) 	{	$errors[]="Discounted Hourly Cost field can't be blank!";	}*/

	if(empty($errors)) {		
		// UPLOAD FILE CODE STARTS 

		if(trim($post_id)!="")
		{
			$update_query = "UPDATE `ss_service_provider_services` SET user_id='".$user_id."', service_id = '".$service_id."', price = '".$price."', status = '1', add_date = '$gtcurrenttime' WHERE `service_provider_service_id`= '$post_id'";

			$update_result = $db->query($update_query);		
			
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Services has been updated successfully.!</div>';
			echo "<script>document.location.href='member-edit.php?fid=".$user_id."&back=sp'</script>";	
		}
		else
		{
			
			$update_query = "INSERT INTO `ss_service_provider_services` SET user_id='".$user_id."', service_id = '".$product_category[0]."', price = '".$price."', status = '1', add_date = '$gtcurrenttime'";
			$update_result = $db->query($update_query);
			
			
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Services has been added successfully.!</div>';
			
			echo "<script>document.location.href='member-edit.php?fid=".$user_id."&back=sp'</script>";	

		}
		unset($_SESSION['myForm']);
	}
}
?>