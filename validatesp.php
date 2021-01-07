<?php include("includes/config.php"); ?>

<!-- RWS Header Starts -->

<?php include("application/gtheader.php"); ?>

<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->

<div class="container rws-contentgap">

    <?php 

	$gt_msgerror= "";

	$_GET["vid"] = str_replace('rEN','=',$_GET["vid"]);

	$vid = base64_decode($_GET["vid"]);

	$validateid = str_replace('SS-','', $vid);

	$query_val = "SELECT * FROM `ss_service_provider` WHERE `id` =".$validateid;

	$result = $db->query($query_val);

	$total_val = $result->num_rows;

	

	

	if($total_val > 0)

	{

		$row = $result->row;

		if($row["validate"] ==1)

		{

			$error_message = '<div id="rws-formsuccess">Your account has already been validated. Please log in!</div>';	

		}

		else

		{	

			$qvalup = "UPDATE `ss_service_provider` SET `validate` = '1' WHERE `id` =".$validateid;

			$result_valup = $db->query($qvalup);

			$error_message = '<div id="rws-formsuccess"><p>Hello User,<br /><br />			

			Your '.$sitename.' account has been successfully validated.

			<br />

			<br />

			<strong>'.$sitename.' Admin</strong>			

			</div>';	

		}

		$showform = 1;

		

	}

	else

	{

		$error_message = '<div id="gt-formfeedback">Your email varification code is wrong. Please use the correct link that is in email.</div>';		

		$showform = 0;

	}

	?>

    

    <div class="row">

        <div class="col-md-6 col-md-offset-3 rws-userformdesign">

            <h1 style="margin-top:0; font-size:24px; text-align:center; margin-bottom:15px;">Account Validation</h1>

            <?php echo $error_message; ?>

        </div>

    </div>

</div>

<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->

<?php include("application/gtfooter.php"); ?>

<!-- RWS Footer Starts --> 