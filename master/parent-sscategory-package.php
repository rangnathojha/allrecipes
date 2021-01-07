<?php include('../includes/config.php'); 
// if the 'term' variable is not sent with the request, exit
if($_GET['filter_name']!="" )
{	
	$query="SELECT service_id, name FROM ss_services WHERE name LIKE '".$_GET['filter_name']."%' AND status=1 ORDER BY name ASC LIMIT 0, 15";
	$rs = $db->query($query);
	
	$foundnum = $rs->num_rows;	
	$data = array();
	$rowlist = $rs->rows;
	if ($foundnum>0)
	{
		foreach($rowlist as $key => $row) { 
		  $data[] = array(
				'name' => todisplaypath($row['service_id']),
				'category_id' => $row['service_id']
			);
		}
	}
	// jQuery wants JSON data
	echo json_encode($data);
	/*flush();*/
}