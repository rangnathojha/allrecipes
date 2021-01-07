<?php include("includes/config.php"); checkuserlogin(); 
if(isset($_SESSION['GTUserID']))
{
	unset($_SESSION["services_package_id"]);
}
$query="SELECT t1.*, t2.name, t3.package_name FROM ss_services_package as t1 INNER JOIN ss_services as t2 ON t1.service_id=t2.service_id INNER JOIN ss_packages as t3 ON t1.package_id=t3.package_id WHERE t1.services_package_id='".$_GET["services_package_id"]."' AND t1.status='1' GROUP BY t1.services_package_id";

$rs = $db->query($query);
$foundnum = $rs->num_rows;
if($foundnum>0)
{
	$rowc = $rs->row;
	$services_package_id = $rowc["services_package_id"];
	
	$_SESSION["Cart"][$services_package_id]['services_package_id']		=$rowc["services_package_id"];
	$_SESSION["Cart"][$services_package_id]['service_id']				=$rowc["service_id"];
	$_SESSION["Cart"][$services_package_id]['package_id']				=$rowc["package_id"];
	$_SESSION["Cart"][$services_package_id]['package_price']			=$rowc["package_price"];
	$_SESSION["Cart"][$services_package_id]['duration']					=$rowc["duration"];
	$_SESSION["Cart"][$services_package_id]['total_hours']				=$rowc["total_hours"];
	$_SESSION["Cart"][$services_package_id]['hourly_cost']				=$rowc["hourly_cost"];
	$_SESSION["Cart"][$services_package_id]['discounted_hourly_cost']	=$rowc["discounted_hourly_cost"];
	$_SESSION["Cart"][$services_package_id]['description']				=$rowc["description"];
	$_SESSION["Cart"][$services_package_id]['service_name']				=$rowc["name"];
	$_SESSION["Cart"][$services_package_id]['package_name']				=$rowc["package_name"];
	$_SESSION["Cart"][$services_package_id]['quantity']					=1;
	
	echo "<script>document.location.href='".$baseurl."review-order.php'</script>";
	
}
else
{
	echo "<script>document.location.href='".$baseurl."'</script>";
}

?>