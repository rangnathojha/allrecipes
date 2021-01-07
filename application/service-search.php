<?php
// if the 'term' variable is not sent with the request, exit
if ($_POST['rwstxtsearch']!="")
{
	
	// connect to the database server and select the appropriate database for use

	include('../includes/config.php');

	// query the database table for company name that match 'term'

	$searchin = $_GET['searchin'];
	$filter_name = $_POST['rwstxtsearch'];
	
	if($searchin==4)
	{
		$service_id=197; 
		$services_category = getlistofsubservicesall($service_id)."'$service_id'";
	}
	else if($searchin==5)
	{
		$service_id=190; 
		$services_category = getlistofsubservicesall($service_id)."'$service_id'";
	}
	else
	{
		$service_id=1; 
		$services_category = getlistofsubservicesall($service_id)."'$service_id'";
	}

	$sql = "SELECT t1.service_id, t1.name FROM ss_services as t1 INNER JOIN ss_services_package as t2 ON t1.service_id=t2.service_id WHERE t1.service_id > 0 AND t1.name LIKE '$filter_name%' AND t1.service_id IN ($services_category) GROUP BY t1.service_id ORDER BY t1.name ASC LIMIT 0,10 ";

	$rs = $db->query($sql);	
// loop through each companyname returned and format the response for jQuery

	if ($rs->num_rows)
	{
		$rowlist = $rs->rows;
		foreach($rowlist as $key => $row)
		{
			$data[] = array(
				'title' => $row['name'],
				'id' => $row['service_id'],
				'url' => $baseurl.'service-details.php?service_id='.$row['service_id']
			);
		}
	}

	echo json_encode($data);
}
else
{
	echo "false";	
}