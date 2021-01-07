<?php include('../includes/config.php'); checkadminlogin();   checkadminroles('reports');

	function exportMysqlToCsv($queryrws, $filename)
	{
		global $db;
		$csv_terminated = "\n";
		$csv_separator = ",";
		$csv_enclosed = '"';
		$csv_escaped = "\\";   
	 
		// Gets the data from the database
		
		//$con2 = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
		$result = $db->query($queryrws);
		$count = $result->num_rows;
		$rsforname = $db->getRecordSet($queryrws);
		$fields_cnt = mysqli_num_fields($rsforname);		
		
		$schema_insert = '';
	 	$fieldname = array();
		for ($i = 0; $i < $fields_cnt; $i++)
		{
			$fetchfield = mysqli_fetch_field_direct($rsforname, $i);
			$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
				stripslashes($fetchfield->name)) . $csv_enclosed;				
			$schema_insert .= $l;
			$schema_insert .= $csv_separator;
			$fieldname[$i]=$fetchfield->name;
		} // end for
	 
		$out = trim(substr($schema_insert, 0, -1));
		$out .= $csv_terminated;
	 
		// Format the data
		$rsrecord = $result->rows;
		foreach ($rsrecord as $key=>$row)
		{
			$schema_insert = '';
			
			/*print("<pre>");
			print_r($row);
			print("</pre>");*/
			
			for ($j = 0; $j < $fields_cnt; $j++)
			{
			//	echo $fieldname[$j];
				if ($row[$fieldname[$j]] == '0' || $row[$fieldname[$j]] != '')
				{
					
					
	 
					if ($csv_enclosed == '')
					{
						$schema_insert .= $row[$fieldname[$j]];
					} else
					{
						$schema_insert .= $csv_enclosed . 
						str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$fieldname[$j]]) . $csv_enclosed;
					}
				} else
				{
					$schema_insert .= '';
				}
	 
				if ($j < $fields_cnt - 1)
				{
					$schema_insert .= $csv_separator;
				}
			} // end for
	 
			$out .= $schema_insert;
			$out .= $csv_terminated;
		} // end while
		
		/*echo $out;		
	 	die();*/
	 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));
		// Output to browser with appropriate mime type, you choose ;)
		header("Content-type: text/x-csv");
		//header("Content-type: text/csv");
		//header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=$filename");
		echo $out;
		exit;
	 
	}
	
	$nquery = "";
	
	$start_date = $_POST["start_date"].' 00:00:00';
	$end_date = $_POST["end_date"].' 00:00:00';
	$parent_id = $_POST["parent_id"];
	
	if($_POST["start_date"]!="") { $nquery .= " AND t1.dateoforder>='$start_date' "; }	
	if($_POST["start_date"] && $_POST["end_date"]!="") { $nquery .= " AND t1.dateoforder BETWEEN '$start_date' AND '$end_date' "; }
	if($_POST["parent_id"]!="") { $nquery .= " AND t1.services_id='$parent_id' "; }	
		
	$query="SELECT t1.order_id, t1.order_reference_number, t2.firstname, t2.lastname, t1.service_name, t1.package_name, t1.service_provider_name, t1.totalamount, t1.startdate, t1.enddate, t1.totalhours, ( CASE WHEN t1.order_status=0 THEN 'Pending' WHEN t1.order_status=1 THEN 'Successfull' WHEN t1.order_status=2 THEN 'Completed' ELSE 'Failed' END) as order_status, ( CASE WHEN t1.order_acceped=0 THEN 'Pending' WHEN t1.order_acceped=1 THEN 'Accepted' WHEN t1.order_acceped=2 THEN 'Completed' ELSE 'Failed' END) as order_accept_status FROM `ss_consumer_order` as t1 INNER JOIN ss_users as t2 ON t2.user_id=t1.user_id  WHERE t1.order_id > 0 ".$nquery."  group by t1.order_id ORDER BY dateoforder ASC";
	
	//echo $query;
	
	$filename = 'SS_Order_Data_'.mt_rand(10000,99999)."-".date("d-m-y").'.csv';		
	exportMysqlToCsv($query, $filename);	
	

?>