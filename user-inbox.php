<?php include("includes/config.php"); checkuserlogin(); ?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php"); 
$gt_msgerror= "";
?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">	

    <div class="row">  
    	<?php if(!empty($_SESSION['GTUserMobile']))
		{  
			include("application/left-sidebar.php");
		}
		?>
        

    	<div class="<?php if(!empty($_SESSION['GTUserMobile'])) { ?>col-sm-9<?php } else { ?>col-sm-offset-2 col-sm-8<?php } ?> rws-userformdesign">
        	<h1 style="margin-top:0; font-size:24px; text-align:center; margin-bottom:15px;">Inbox</h1>			                    
			
            
            <?php					
					$query_gc = "SELECT t1.id, t1.user_id, t1.from_user_id, t1.message, t1.created_date, t2.firstname, t2.lastname, t2.email FROM  `ss_users_inbox` as t1 INNER JOIN `ss_users` as t2 ON t2.id=t1.from_user_id WHERE t1.user_id = '".$_SESSION['GTUserID']."' OR t1.from_user_id = '".$_SESSION['GTUserID']."'  ORDER BY t1.created_date DESC"; 
					
					$result_gc = $db->query($query_gc);	
					$totalrows_gc = $result_gc->num_rows;
					$rowlist_gc = $result_gc->rows;
					$j=1; 
					if($totalrows_gc>0)
					{
						
						echo '<div class="gt-profiledetailsinfo">';
						
						foreach($rowlist_gc as $key => $rowgc) 
						{
							
							$name = $rowgc["firstname"].' '.$rowgc["lastname"];
							
							if($rowgc["from_user_id"]==$_SESSION['GTUserID'])
							{
								echo '<div class="form-group"><p><strong>You sent a message to '.togetfieldvalue('firstname', 'users', 'id='.$rowgc["user_id"]).' '.togetfieldvalue('lastname', 'users', 'id='.$rowgc["user_id"]).'!</strong> <span style="float:right;">'.toshowdatewithtime($rowgc["created_date"]).'</span></p><p>'.stripslashes($rowgc["message"]).'</p></div>';
							}
							else
							{
							echo '<div class="form-group"><p><strong>'.$name.' has sent a message for you!</strong> <span style="float:right;">'.toshowdatewithtime($rowgc["created_date"]).'</span></p><p>'.stripslashes($rowgc["message"]).'</p> <p class="gt-frienduserstatus"><a class="gtlightbox" href="user-send-pm.php?lightbox[width]=240&amp;lightbox[height]=200&amp;lightbox[modal]=true&amp;touserid='.$rowgc["from_user_id"].'"><i class="fa fa-envelope-o"></i> Send Message</a></p></div>';
							}
							
					
					 $j++;
						}
					echo '</div>';
					
					}
					else
					{
						echo '<div id="rws-forminfo">There is no message in your inbox. Please check later!</div>';
					}
	
					?> 
            
        </div>

    

    </div>        

</div>

<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 