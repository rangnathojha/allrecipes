<?php include("includes/config.php"); checkuserlogin(); 

$pageuser = "Consumer";

$order_id = $_GET["order_id"];

$query="SELECT t1.* FROM ss_consumer_order as t1 INNER JOIN ss_users as t2 ON t1.user_id=t2.user_id WHERE t1.user_id=".$_SESSION['GTUserID']." AND t1.order_id='$order_id' GROUP BY t1.order_id";
$rs = $db->query($query);
$foundnum = $rs->num_rows;
$rowod = $rs->row;

if(tocheckorderschedule($order_id)>0) {
	$_SESSION['GtThanksMsg'] = '<div id="rws-formfeedback">Your Class Schedule for Order Reference No. '.$rowod['order_reference_number'].' has been already submitted.</div>';	

	echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	exit;
}

if($foundnum==0)
{
	$_SESSION['GtThanksMsg'] = '<div id="rws-formfeedback">Sorry we are unable to recognize order. If the problem persist, Kindly Contact Website Admin.</div>';	

	echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	exit;
}

if($rowod["service_provider_id"]==0)
{
	$_SESSION['GtThanksMsg'] = '<div id="rws-formfeedback">Sorry Admin didn\'t assign frentor yet, Kindly Contact Website Admin.</div>';	

	echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	exit;
}


if(isset($_POST["gtsubmitform"]))
{
	$invoice_no = $_POST["invoice_no"];
	$sp_email 	= $_POST["sp_email"];
	$classdetails = '';
	
	foreach($_SESSION['ScheduleClass'] as $key => $value) 
	{
		$sp_user_id 	= $value["sp_id"];
		$sp_name 		= $value["sp_name"];
		$order_id 		= $value["order_id"];
		$consumer_id 	= $_SESSION['GTUserID'];
		$dateofclass 	= $value["date"];
		$starttime 		= $value["start_time"];
		$endtime 		= $value["end_time"];
		
		$query_insert = "INSERT INTO `ss_services_provider_hour_tracking` SET sp_user_id = '$sp_user_id', order_id = '$order_id', consumer_id = '$consumer_id', hours = '1', dateofclass = '$dateofclass', starttime = '$starttime', endtime = '$endtime', approvedbyadmin = '0', rating = '0', status = '1', add_date = '$gtcurrenttime', end_date = '', checked = '0'";
			
		$update_result = $db->query($query_insert);
		
		
		$classdetails .= '<div style="padding-bottom:5px; width:100%; clear:both; overflow:hidden;">'.$value["date"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From&nbsp;&nbsp;<em>'.date("h A", strtotime($value["date"].' '.$value["start_time"])).'</em>&nbsp;&nbsp;To&nbsp;&nbsp;<em>'.date("h A", strtotime($value["date"].' '.$value["end_time"])).'</em></div>';
		
				
	}
	
	/* SEND EMAIL CODE Consumer */
	
		$subject = "Hello ".$_SESSION['GTUserFirstName'].", Class Schedule for [$invoice_no]";
			$body = $emailheader.'
	  <tr>
		<td style="padding:10px;margin:0;line-height:1.6;color:#66757f;font-size:14px;text-align:left">
		Dear '.$_SESSION['GTUserFirstName'].',<br/><br/>
		
		Thank you for scheduling the class. Here is the complete details.<br/><br/>
		
		'.$classdetails.'
		
		<br/><br/>
		
		
		</td>
	  </tr>	  
	  '.$emailfooter;
	  sendmail($_SESSION['GTUserEmail'],$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
	  
	
	/* SEND EMAIL CODE Service Provider */
	
	$subject = "Hello ".$sp_name.", Class Schedule for [$invoice_no]";
			$body = $emailheader.'
	  <tr>
		<td style="padding:10px;margin:0;line-height:1.6;color:#66757f;font-size:14px;text-align:left">
		Dear '.$sp_name.',<br/><br/>		
		'.$_SESSION['GTUserFirstName'].' has scheduled the class. Here is the complete details.<br/><br/>		
		'.$classdetails.'		
		<br/>
		</td>
	  </tr>	  
	  '.$emailfooter;
	  sendmail($sp_email,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
	  
	  /* SEND EMAIL CODE Service Provider */
	
	unset($_SESSION['ScheduleClass']);
	
	$_SESSION['GtThanksMsg'] = '<div id="rws-formsuccess">Great! Your Class Schedule for Order Reference No. '.$invoice_no.' has been submitted now.</div>';	

	echo "<script>document.location.href='".$baseurl."dashboard-consumer.php'</script>";
	exit;
			
}



?>

<!-- RWS Header Starts -->
<?php include("application/gtheader.php"); ?>
<!-- RWS Header Starts -->  
<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">
    <div class="row">
    	<?php include("application/left-sidebar.php"); ?>
        
        <div class="col-sm-9" id="rws-rightcolumn">
        
        <div class="row">
            <div class="col-sm-7">            
            	<div class="rws-module">
                <h3 style="margin-bottom:0;">Schedule Classes</h3>
    
                <div class="mcontent">
                	<div id="my-calendar"></div></div>
                </div>            
            </div>
            
            <div class="col-sm-5">
            	<form name="gtfinalschedule" id="gtfinalschedule" action="" method="post">
                <input type="hidden" name="invoice_no" value="<?php echo $rowod['order_reference_number']; ?>"/>
                <input type="hidden" name="sp_email" value="<?php echo togetfieldvalue('email', 'ss_users', " `user_id`='".$rowod['service_provider_id']."' "); ?>"/>
            	<div class="rws-module">
                    <h3>Class Schedule</h3>
                    <div class="mcontent gtscheduletimesection">
                    <?php 
					/*print("<pre>");
						print_r($_SESSION['ScheduleClass']);
					print("</pre>");*/
					
					if(isset($_SESSION['ScheduleClass']) && !empty($_SESSION['ScheduleClass']))
					{
						$stringhtml = '';
						$totalhours		= $rowod['totalhours'];
						$totalcount 	= count($_SESSION['ScheduleClass']);

						if($totalcount>0)
						{
							$stringhtml .='<div class="gtsselecthead"><div class="row"><div class="col-sm-5">Date</div><div class="col-sm-7">Time Selected</div></div></div>';
							foreach($_SESSION['ScheduleClass'] as $key => $value) 
							{
								$stringhtml .= '<div class="gtfieldvalue"><div class="row"><div class="col-sm-5">'.$value["date"].'</div><div class="col-sm-7">'.date("h A", strtotime($value["date"].' '.$value["start_time"])).' To '.date("h A", strtotime($value["date"].' '.$value["end_time"])).'</div></div></div>';
							}
							
							if($totalhours==$totalcount)
							{
								$stringhtml .= '<div class="gtfieldvalue"><input type="submit" name="gtsubmitform" id="gtsubmitform" value="Submit"/></div>';
							}
							
							echo $stringhtml;
							
						}
					}
					else
					{
                    	echo '<p>There is no date and time selected for the class. Please click on the available dates marked in orange color and choose the time.</p>';
					}
					?>
                    </div>
                </div> 
                </form>                           
            </div>                        
         </div>
        
        
        	            
            </div>
        
        </div>
    </div>
</div>
<!-- RWS Dashboard Starts -->
<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 