<?php 
// connect to the database server and select the appropriate database for use
include('../includes/config.php');
// query the database table for company name that match 'term'

function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}

$order_id 	= $_GET['order_id'];
$sp_id 		= $_GET['sp_id'];
$sp_name 	= $_GET['sp_name'];
$startdate 	= $_GET['startdate'];
$enddate 	= $_GET['enddate'];
$totalhours	= $_GET['totalhours'];

$daterange = date_range($startdate, $enddate);

$dates = array();
$i=1;
foreach($daterange as $key=>$val)
{
	$timestamp = strtotime($val);
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
		$textinbody ='<div class="gtsselecthead"><div class="row"><div class="col-sm-7">Availability</div><div class="col-sm-5  gttextright">#</div></div></div>';
		foreach($rowlist as $key => $row) 
		{		
			
			if(togetslotidalreadyscheduled($val,$row["start_time"],$row["end_time"])==0)
			{
				$textinbody .= '<div class="gtfieldvalue">
								<div class="row">
									<div class="col-sm-7">From '.date("h A", strtotime($val.' '.$row["start_time"])).' To '.date("h A", strtotime($val.' '.$row["end_time"])).'</div>
									<div class="col-sm-5 gttextright">Available
									</div>
								</div>
								</div>';						
			}
			else
			{
				$textinbody .= '<div class="gtfieldvalue">
								<div class="row">
									<div class="col-sm-7">From '.date("h A", strtotime($val.' '.$row["start_time"])).' To '.date("h A", strtotime($val.' '.$row["end_time"])).'</div>
									<div class="col-sm-5 gttextright">Unavailable</div>
								</div>
								</div>';
			}
		}
		
		$dates[$i] = array(
            'date' => $val,
            'badge' => 'true',
            'title' => $sp_name.' Availability on '.$val,
            'body' => '<div class="rws-messagetouser"></div>'.$textinbody,
            'footer' => 'You may choose above slots for the frentor.',
        );
	}
	
	$i++;
	
}

echo json_encode($dates);
/*

if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
	
	
	
	
    $year = intval($_REQUEST['year']);
    $month = intval($_REQUEST['month']);
    $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));

    $dates = array();
    for ($i = 0; $i <=(rand(4, 10)); $i++) {
        $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, $lastday), 2, '0', STR_PAD_LEFT);
		
		if($date<$enddate)
		{
        
		$dates[$i] = array(
            'date' => $date,
            'badge' => ($i & 1) ? true : false,
            'title' => 'Example for ' . $date.$sp_name,
            'body' => '<p class="lead">Information for this date</p><p>You can add <strong>html</strong> in this block</p>',
            'footer' => 'Extra information',
        );

        if (!empty($_REQUEST['grade'])) {
            $dates[$i]['badge'] = false;
            $dates[$i]['classname'] = 'grade-' . rand(1, 4);
        }

        if (!empty($_REQUEST['action'])) {
            $dates[$i]['title'] = 'Action for ' . $date;
            $dates[$i]['body'] = '<p>The footer of this modal window consists of two buttons. One button to close the modal window without further action.</p>';
            $dates[$i]['body'] .= '<p>The other button [Go ahead!] fires myFunction(). The content for the footer was obtained with the AJAX request.</p>';
            $dates[$i]['body'] .= '<p>The ID needed for the function can be retrieved with jQuery: <code>dateId = $(this).closest(\'.modal\').attr(\'dateId\');</code></p>';
            $dates[$i]['body'] .= '<p>The second argument is true in this case, so the function can handle closing the modal window: <code>myFunction(dateId, true);</code></p>';
            $dates[$i]['footer'] = '
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="dateId = $(this).closest(\'.modal\').attr(\'dateId\'); myDateFunction(dateId, true);">Go ahead!</button>
            ';
        }
		
		}
		
    }

    echo json_encode($dates);

} else {
    echo json_encode(array());
}
*/