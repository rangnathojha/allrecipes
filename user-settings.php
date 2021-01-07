<?php include("includes/config.php"); checkuserlogin(); ?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php");  ?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">	

    <div class="row">  
    	<?php if(!empty($_SESSION['GTUserMobile']))
		{  
			include("application/left-sidebar.php");
		}
		
		if($_SESSION['GTUserType']=="C")	{
			$editprofilelink = "edit-profile.php";
		}
		else
		{
			$editprofilelink = "edit-profile-sp.php";
		}
		?>
        

    	<div class="<?php if(!empty($_SESSION['GTUserMobile'])) { ?>col-sm-9<?php } else { ?>col-sm-offset-2 col-sm-8<?php } ?> rws-userformdesign">
        	<h1 style="margin-top:0; font-size:24px; text-align:center; margin-bottom:15px;">Settings</h1>        				                    
			<div class="row">    
              <div class="col-sm-6">
                    <a href="change-password.php">
                        <div class="gtinnerlist" style="height:auto;">
                            Change Password
                        </div>
                    </a>
              </div>
              <div class="col-sm-6">
                    <a href="<?php echo $editprofilelink; ?>">
                        <div class="gtinnerlist" style="height:auto;">
                            Edit Profile
                        </div>
                    </a>
              </div>  
            </div>
        </div>

    

    </div>        

</div>

<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 