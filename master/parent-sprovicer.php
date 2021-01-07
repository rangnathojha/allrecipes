<?php include('../includes/config.php'); 
// if the 'term' variable is not sent with the request, exit
if($_GET['filter_name']!="" )
{

$query="SELECT t1.firstname, t1.lastname, t1.email, t1.user_id FROM `ss_users` as t1 INNER JOIN ss_service_provider_availability as t2 ON t1.user_id=t2.user_id WHERE t1.user_id>0 AND (t1.user_type LIKE '%SP%' OR t1.user_type LIKE '%B%') AND t1.firstname LIKE '".$_GET['filter_name']."%' AND t1.status=1 GROUP BY t1.user_id ORDER BY t1.firstname ASC LIMIT 0, 15";
$rs = $db->query($query);

$foundnum = $rs->num_rows;	
$data = array();
$rowlist = $rs->rows;
if ($foundnum>0)
{
	foreach($rowlist as $key => $row) { 
	  $data[] = array(
            'name' => $row['firstname'].' '.$row['lastname'],
            'category_id' => $row['user_id']
        );
    }
}
	// jQuery wants JSON data
		echo json_encode($data);
	/*flush();*/
}