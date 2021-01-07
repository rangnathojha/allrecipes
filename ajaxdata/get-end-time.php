<?php include('../includes/config.php');
$dateselected 				= $_POST['dateselected'];
$timestamp = strtotime($dateselected) + 60*60;
echo $end_time = 'End Time: '.date('h A', $timestamp);
?>