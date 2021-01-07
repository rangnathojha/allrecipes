<?php include('../includes/config.php');
/*print("<pre>");
print_r($_POST);
print("</pre>");*/
if(!empty($_POST["title"]))
{
	
	$_SESSION['myForm'] = $_POST;

	$title 							= addslashes($_POST["title"]);
	$description		 			= addslashes($_POST["description"]);	
	$author 						= addslashes($_POST["author"]);	
	$duration 						= addslashes($_POST["duration"]);
	$prep 							= addslashes($_POST["prep"]);	
	$cook 							= addslashes($_POST["cook"]);
	$total 							= $prep+$cook;	
	$servings 						= addslashes($_POST["servings"]);
	$yield 							= addslashes($_POST["yield"]);
	$nutrition_info 				= addslashes($_POST["nutrition_info"]);
	$ingredients 					= addslashes($_POST["ingredients"]);
	$directions 					= addslashes($_POST["directions"]);
	$cook_notes 					= addslashes($_POST["cook_notes"]);
	$status 						= addslashes($_POST["status"]);	
	$product_category				= $_POST["product_category"];	
	$post_id 						= $_POST["post_id"];
	$service_id 					= $_POST["parent_id"];	
	
	// Form Validation Code

	$errors = array(); //Initialize error array 

	if(empty($errors)) {		
		// UPLOAD FILE CODE STARTS 
		
		if(trim($post_id) =="")
		{
		
			
			$rand2 = mt_rand(100000,999999);
			$uploadfolder = '../images/recipeimg';
			
			for($k=1;$k<=5;$k++)
			{
				$img_name_rand[$k] = $array_rand[$rand_keys[0]]."_".$rand2."_".$array_rand[$rand_keys[1]]."_".$rand1."_".$k.".jpg";
				
				if(!empty($_FILES['image_'.$k]['name']))
				{
					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];
					$arrayimage[$k] = $_FILES['image_'.$k]['name'];
					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];
					if (is_uploaded_file($fileThumbnail))
					{
						move_uploaded_file ($fileThumbnail, $add_thumbnail);
					}
					
					$imageuploadname[$k] = $k."_".$rand2."_".$arrayimage[$k];			
			
				}
				else
				{
					$imageuploadname[$k]="";
				}
			}
		
		}
		else
		{		
			
			$rand2 = mt_rand(100000,999999);
			$uploadfolder = '../images/recipeimg';
			
			for($k=1;$k<=5;$k++)
			{
				
				if(!empty($_FILES['image_'.$k]['name']))
				{
					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];
					$arrayimage[$k] = $_FILES['image_'.$k]['name'];
					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];
					if (is_uploaded_file($fileThumbnail))
					{
						move_uploaded_file ($fileThumbnail, $add_thumbnail);
					}
					
					$imageuploadname[$k] = $k."_".$rand2."_".$arrayimage[$k];			
			
				}
				else
				{
					$imageuploadname[$k]=$_POST['oldimage_'.$k];
				}
			}		
		}
		
		// UPLOAD FILE CODE ENDS
		
		$image_1 = $imageuploadname[1];
		$image_2 = $imageuploadname[2];
		$image_3 = $imageuploadname[3];
		$image_4 = $imageuploadname[4];

		if(trim($post_id)!="")
		{
			$update_query = "UPDATE `ss_services_package` SET `service_id` = '$service_id', `title` = '$title', `description` = '$description', `image_1`='$image_1', `image_2`='$image_2', `image_3`='$image_3', `image_4`='$image_4', `author`='$author', `prep`='$prep', `cook`='$cook', `total`='$total', `servings`='$servings', `yield`='$yield', `nutrition_info`='$nutrition_info', `ingredients`='$ingredients', `directions`='$directions', `cook_notes`='$cook_notes', `status`='$status' WHERE `services_package_id`= '$post_id'";

			$update_result = $db->query($update_query);		
			
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Recipe has been updated successfully.!</div>';
			echo "<script>document.location.href='package-add.php?fid=".$post_id."'</script>";	
		}
		else
		{
			foreach($product_category as $key=>$service_id)
			{
				$update_query = "INSERT INTO `ss_services_package` SET `service_id` = '$service_id', `title` = '$title', `description` = '$description', `image_1`='$image_1', `image_2`='$image_2', `image_3`='$image_3', `image_4`='$image_4', `author`='$author', `prep`='$prep', `cook`='$cook', `total`='$total', `servings`='$servings', `yield`='$yield', `nutrition_info`='$nutrition_info', `ingredients`='$ingredients', `directions`='$directions', `cook_notes`='$cook_notes', `status`='$status', `date_added`='$gtcurrenttime'";
				$update_result = $db->query($update_query);
			}
			
			$_SESSION["gtThanksMSG"]='<div id="gt-formsuccess">Recipe has been added successfully.!</div>';
			
			echo "<script>document.location.href='package-add.php'</script>";

		}
		unset($_SESSION['myForm']);
	}
}
?>