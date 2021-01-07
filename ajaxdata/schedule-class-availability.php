<?php include('../includes/config.php');
// query the database table for company name that match 'term'

$dateselected 	= $_POST['dateselected'];
$sp_id 			= $_POST["sp_id"];
$old_date		= $_POST["old_date"];

$json = array();

if($old_date!=$dateselected)
{

	$timestamp = strtotime($dateselected);
	$day = date('D', $timestamp);
		
	if($day=="Mon") { $daysearch = 'm';	 }
	if($day=="Tue") { $daysearch = 't';	 }
	if($day=="Wed") { $daysearch = 'w';	 }
	if($day=="Thu") { $daysearch = 'th'; }
	if($day=="Fri") { $daysearch = 'f';	 }
	if($day=="Sat") { $daysearch = 's';	 }
	if($day=="Sun") { $daysearch = 'su'; }
	
	$query = "SELECT * FROM `ss_service_provider_availability` WHERE `user_id`='$sp_id' and `day`='$daysearch' ORDER BY start_time ASC";
	//echo "<br/>";
	$rs = $db->query($query);
    $foundnum = $rs->num_rows;
	if($foundnum>0)
	{
		$rowlist = $rs->rows;
		$j=1; 
		$stringhtml ='<div class="gtsselecthead"><div class="row"><div class="col-sm-7">Availability</div><div class="col-sm-5  gttextright">#</div></div></div>';
		foreach($rowlist as $key => $row) 
		{		
			
			if(togetslotidalreadyscheduled($dateselected,$row["start_time"],$row["end_time"])==0)
			{
				$stringhtml .= '<div class="gtfieldvalue">
								<div class="row">
									<div class="col-sm-7">From '.date("h A", strtotime($dateselected.' '.$row["start_time"])).' To '.date("h A", strtotime($dateselected.' '.$row["end_time"])).'</div>
									<div class="col-sm-5 gttextright"><input type="radio" name="time_slot" id="time_slot" value="'.$row["service_provider_availablity_id"].'"/></div>
								</div>
								</div>';						
			}
			else
			{
				$stringhtml .= '<div class="gtfieldvalue">
								<div class="row">
									<div class="col-sm-7">From '.date("h A", strtotime($dateselected.' '.$row["start_time"])).' To '.date("h A", strtotime($dateselected.' '.$row["end_time"])).'</div>
									<div class="col-sm-5 gttextright">Unavailable</div>
								</div>
								</div>';
			}
		}	
		
	}
	else
	{
		$stringhtml = '<div id="rws-formfeedback">Sorry, There is no class available on <strong>'.$dateselected.'</strong>.</div>';
	}
	
}
else
{
	$stringhtml = '<div id="rws-formfeedback">Sorry, you have selected the same date as it was before. Try to choose date again.</div>';
}


$json['html']=$stringhtml;
echo json_encode($json);