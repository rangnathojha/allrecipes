<?php include('../includes/config.php');
// query the database table for company name that match 'term'

$slot_id 				= $_POST['slot_id'];
$date_selected 			= $_POST['date_selected'];
$start_time_selected 	= $_POST['start_time_selected'];
$end_time_selected 		= $_POST['end_time_selected'];
$quantity		 		= $_POST['quantity'];
$order_id 				= $_POST['order_id'];
$sp_id 					= $_POST['sp_id'];
$sp_name 				= $_POST['sp_name'];
$totalhours				= $_POST['totalhours'];

$json = array();

if(isset($_SESSION['ScheduleClass']))
{
	$totalcount = count($_SESSION['ScheduleClass']);
}
else
{
	$totalcount = 0;
}

if($totalcount<$totalhours)
{

	if(isset($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]) && !empty($_SESSION['ScheduleClass'][$date_selected."_".$slot_id])) 
	{
		if($quantity==0)
		{
			$message_user = '<div id="rws-formfeedback">Mentoring for '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' From '.date("h A", strtotime($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["start_time"])).' To '.date("h A", strtotime($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["end_time"])).' has been removed successfully.</div>';
				
			unset($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]);
				
		}
	}
	else
	{
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["slot_id"]		= $slot_id;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"]			= $date_selected;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["start_time"]	= $start_time_selected;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["end_time"]		= $end_time_selected;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["order_id"]		= $order_id;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["sp_id"]		= $sp_id;
		$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["sp_name"]		= $sp_name;
		
		$message_user = '<div id="rws-formsuccess">Mentoring for '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' From '.date("h A", strtotime($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["start_time"])).' To '.date("h A", strtotime($_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["date"].' '.$_SESSION['ScheduleClass'][$date_selected."_".$slot_id]["end_time"])).' has been added successfully.</div>';
	}

}
else
{
	$message_user = '<div id="rws-formfeedback">Sorry, you have selected allowed total hours according to your order. Close the window and submit the Class schedule form present in right side.</div>';
}



$stringhtml = '';

$totalcount2 = count($_SESSION['ScheduleClass']);

if($totalcount2>0)
{
	$stringhtml .='<div class="gtsselecthead"><div class="row"><div class="col-sm-5">Date</div><div class="col-sm-7">Time Selected</div></div></div>';
	foreach($_SESSION['ScheduleClass'] as $key => $value) 
	{
		$stringhtml .= '<div class="gtfieldvalue"><div class="row"><div class="col-sm-5">'.$value["date"].'</div><div class="col-sm-7">'.date("h A", strtotime($value["date"].' '.$value["start_time"])).' To '.date("h A", strtotime($value["date"].' '.$value["end_time"])).'</div></div></div>';
	}
	
	if($totalhours==count($_SESSION['ScheduleClass']))
	{
		$stringhtml .= '<div class="gtfieldvalue"><input type="submit" name="gtsubmitform" id="gtsubmitform" value="Submit"/></div>';
	}
	
}
else
{
	$stringhtml .= '<p>There is no date and time selected for the class. Please click on the available dates marked in orange color and choose the time.</p>';
}

$json['html']=$stringhtml;
$json['info']=$message_user;
echo json_encode($json);