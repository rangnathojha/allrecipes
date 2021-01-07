<?php include("includes/config.php"); checkuserlogin(); ?>
<!-- RWS Header Starts -->
<?php $loginbg = 1;  include("application/gtheader.php"); ?>
<?php $gt_msgerror= "";
/*print_r($_SESSION["Cart"]);*/
$total_quantity ="";
$total_price ="";

?>
<!-- RWS Header Starts -->        

<!-- RWS Dashboard Starts -->
<div class="container rws-contentgap">	
	<h1>Review Order</h1>
    <div class="rws-fieldtitle">
        <div class="row rws-fields">
            <div class="col-sm-6 col-xs-4">
                Package
            </div>
             <div class="col-sm-2  col-xs-3">
                Price
            </div>
            <div class="col-sm-2 col-xs-2">
                <div class="hidden-xs">Quantity</div>
                <div class="hidden-sm hidden-md hidden-lg">QTY</div>
            </div>
            <div class="col-sm-2 col-xs-3">
                Sub Total
            </div>
        </div>
    </div>
    <?php foreach($_SESSION["Cart"] as $key=>$val) {
		$total_quantity +=$val["quantity"];
		$total_price +=$val["package_price"];
		
		 ?>
         <div class="rws-fieldcontent">
            <div class="row rws-fields">
                <div class="col-sm-6 col-xs-4">
                    <?php echo $val["service_name"]; ?>, <em><?php echo $val["package_name"]; ?></em>
                </div>
                <div class="col-sm-2 col-xs-3">
                    <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $val["package_price"]; ?>
                </div>
                <div class="col-sm-2 col-xs-2">
                    <?php echo $val["quantity"]; ?>
                </div>
                <div class="col-sm-2 col-xs-3">
                    <i class="fa fa-inr" aria-hidden="true"></i> <?php echo ($val["quantity"]*$val["package_price"]); ?>
                </div>
            </div>
    	</div>
    <?php } ?>
    <div class="rws-fieldcontent rwsbglight">
            <div class="row rws-fields">
                <div class="col-sm-6 hidden-xs">
                    &nbsp;
                </div>
                <div class="col-sm-2 col-xs-4">
                    Enter Promo Code
                </div>
                <div class="col-sm-2 col-xs-5">
                    <input type="text" name="rwspromocode" id="rwspromocode" value="Promo Code" />
                </div>
                <div class="col-sm-2 col-xs-3">
                    <button type="button" name="gtapplypromocode" id="gtapplypromocode" class="btn btn-primary">Apply</button>
                </div>
            </div>
    	</div>
        
    <div class="rws-fieldtitle">
    <div class="row rws-fields">
    	<div class="col-sm-6 col-xs-4">
        	&nbsp;
        </div>
         <div class="col-sm-2 col-xs-3">
        	Total
        </div>
        <div class="col-sm-2 col-xs-2">
        	<?php echo $total_quantity; ?>
        </div>
        <div class="col-sm-2 col-xs-3">
        	<i class="fa fa-inr" aria-hidden="true"></i> <?php echo $total_price; ?>
        </div>
    </div>
    </div>
    
    <div class="row rws-fields">
    	<div class="col-sm-12" style="text-align:right; padding-top:15px;">
        	<button type="button" name="gtproceedtocheckout" id="gtproceedtocheckout" class="btn btn-primary" onClick="document.location.href='<?php echo $baseurl; ?>paymentgateway.php'">Proceed to Payment</button>
        </div>
    </div>
    
</div>
<!-- RWS Dashboard Starts -->        

<!-- RWS Footer Starts -->
<?php include("application/gtfooter.php"); ?>
<!-- RWS Footer Starts --> 