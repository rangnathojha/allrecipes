<?php
// if the 'term' variable is not sent with the request, exit
if ($_GET['filter_name'] != "" )
{
// connect to the database server and select the appropriate database for use
include('../includes/config.php');
// query the database table for company name that match 'term'
$filter_name = $_GET['filter_name'];
$sql = "SELECT service_id, name FROM `ss_services` WHERE `name` LIKE '$filter_name%' ORDER BY name ASC LIMIT 0,10";
$rs = $db->query($sql);	
// loop through each companyname returned and format the response for jQuery

$data = array();
if ($rs->num_rows)
{
	$rowlist = $rs->rows;
	foreach($rowlist as $key => $row)
	{
		$name = todisplaypath($row['service_id']);
		$data[] = array(
			'name' => $row['name'],
			'service_id' => $row['service_id']
		);
    }
	
}



echo json_encode($data);
}