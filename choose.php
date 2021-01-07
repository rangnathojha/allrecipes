<?php include("includes/config.php"); ?>
<!-- RWS Header Starts -->
<?php include("application/gtheader.php"); 

if(isset($_POST["gtsavebutton"]))
{
	if ($_POST['parent_id'][0]==0) 	{	$errors[]="Service Name field can't be blank!";		}
	if (empty($_POST['price'][0]) ) 	{	$errors[]="Price field can't be blank!";		}
	
	if (empty($_POST['days'][0])) 	{	$errors[]="Day field can't be blank!";		}
	if (empty($_POST['start_time'][0]) ) 	{	$errors[]="Start Time field can't be blank!";		}
	if (empty($_POST['end_time'][0]) ) 	{	$errors[]="End Time field can't be blank!";		}
	
	if(empty($errors)) 
	{
		
	$services = $_POST["parent_id"];
	$price = $_POST["price"];
	
	$days = $_POST["days"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];
	
	$j=0;
	foreach($services as $key=>$val)
	{
		// INSERT CODE
		$update_query = "INSERT INTO `ss_services` SET user_id='".$_SESSION['GTUserID']."', service_id = '$val', price = '".$price[$j]."', status = '1', add_date = '$gtcurrenttime'";
		$update_result = $db->query($update_query);
		
		$j++;
	}
	
	$j=0;
	foreach($days as $key1=>$val1)
	{
		// INSERT CODE
		$update_query = "INSERT INTO `ss_services_time` SET user_id='".$_SESSION['GTUserID']."', day = '$val1', start_time = '".$start_time[$j]."', end_time = '".$end_time[$j]."', status = '1', add_date = '$gtcurrenttime'";
		$update_result = $db->query($update_query);
		
		$j++;
	}
	
	$_SESSION["GTMsgManage"]='<div id="rws-formsuccess">Your services has been added successfully!</div>';
	
	/*echo "<script>document.location.href='".$baseurl."add-village-survey-step-2.php?sid=".$sid."'</script>";	*/
	
	}
	else
	{
		if(!empty($errors)) {
		$gt_msgerror = '<div id="rws-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
		foreach ($errors as $msg) { //prints each error
		$gt_msgerror .= "<li>$msg</li>";
		} // end of foreach
		$gt_msgerror .= '</ul></div>'; }
	}
}

?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">
<div class="rws-module">
<h1>Choose Services</h1>
<form name="gtservices" id="gtservices" method="post" action="" enctype="multipart/form-data">
<?php echo $gt_msgerror; if(isset($_SESSION["GTMsgManage"])) { echo $_SESSION["GTMsgManage"]; unlink($_SESSION["GTMsgManage"]); } ?>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Choose Services</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Set Days Hours</a></li>    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    	<div class="clonedInput" id="nameinput1">
    	<div class="row rws-fields gtaddrows">
        	<div class="col-sm-5">
            	<div class="ui-widget">
            	<div class="label">Service Name</div>
                	<input type="text" name="services[]" id="services" value="" placeholder="*Service Name" class="ui-autocomplete-input gtservices" autocomplete="off" aria-autocomplete="list" aria-haspopup="true" required>                    
					<input type="hidden" name="parent_id[]" value="0" class="actualvalue">
                </div>
                
            </div>  
            <div class="col-sm-5">
            	<div class="label">Price</div>
            	<input type="text" name="price[]" id="price" value="" placeholder="*Price" required class="gtpricesection" >
            </div> 
            <div class="col-sm-2">
            	<div class="label">Remove Item;</div>
            	<input type="button" value="Remove" class="rwsdeletetraining1 btn btn-danger" class="btn btn-danger" style="padding:5px 10px; width:100%;" />
            </div>          
        </div>
        </div>        
        
        <div class="row rws-fields">
        	<div class="col-xs-6"><a href="#profile" class="rwsbutton gtclickitem" aria-controls="profile" role="tab" data-toggle="tab">Continue</a></div>
            <div class="col-xs-6" style="text-align:right;"><input type="button" id="btnAdd" value="Add New Row" class="btn btn-success" /></div>        
        </div>
        
        
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    
    	<div class="clonedInput2" id="nameinput_new1">
        
            <div class="row rws-fields duplicaterow" style="margin-top:20px;">
                <div class="col-sm-6">
                    <?php echo todisplay($array_days, 'days[]', "Days", $selected="", $onchange=""); ?>
                </div>
                <div class="col-sm-2">
                    <?php echo todisplay($array_timeslot, 'start_time[]', "Days", $selected="", $onchange=""); ?>
                </div>
                <div class="col-sm-2">
                    <?php echo todisplay($array_timeslot, 'end_time[]', "Days", $selected="", $onchange=""); ?>
                </div>
                <div class="col-sm-2">
                    <input type="button" value="Remove" class="rwsdeletetraining2 btn btn-danger" class="btn btn-danger" style="padding:5px 10px; width:100%;" />
                </div>
            </div>
        
        </div>
        
        
        
        <div class="row rws-fields">
        	<div class="col-xs-6"><input type="submit" name="gtsavebutton" id="gtsavebutton" value="Save"></div>
            <div class="col-xs-6" style="text-align:right;"><input type="button" id="btnAdd2" value="Add New Row" class="btn btn-success" /></div>        
        </div>
            
  </div>
   </div>  
    
	</form>
   </div> 
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 