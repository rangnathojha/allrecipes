<?php include("includes/config.php"); checkuserlogin(); 
$orn = str_replace('SSOD-','',base64_decode($_GET["orn"]));

$query = "SELECT * FROM `ss_consumer_order` WHERE `order_id`='$orn' AND `user_id`='".$_SESSION['GTUserID']."' AND `order_status`='0'";
$result = $db->query($query);
$foundnum = $result->num_rows;

$row = $result->row;
if($foundnum>0) {
	
	$MERCHANT_KEY 			= "nAnVnhB3";
	$SALT 					= "w8mPqeIDtq";
	$PAYU_BASE_URL 			= "https://sandboxsecure.payu.in";		// For Sandbox Mode
	//$PAYU_BASE_URL 		= "https://secure.payu.in";			// For Production Mode
	
	$txnid =  substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	$amount = $row["totalamount"];
	$productinfo = $row["service_name"].' - '.$row["package_name"];
	$firstname = $_SESSION['GTUserFirstName'];
	$email = $_SESSION['GTUserEmail'];
	
	$phone = $_SESSION['GTUserMobile'];
	$udf1 = $_GET["orn"];
	
	$hash = strtolower(hash('sha512', $MERCHANT_KEY."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|".$udf1."||||||||||".$SALT));
	
	//$hash = $MERCHANT_KEY."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|".$_SESSION['GTUserMobile']."|".$baseurl."success.php?orn=".$_GET["orn"]."|".$baseurl."failure.php?orn=".$_GET["orn"]."|".$udf1."|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	// Hash Sequence
	$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	
	$action = $PAYU_BASE_URL . '/_payment';


?><html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onLoad="submitPayuForm()">
  <div align="center">
  	<h1>Please don't click back or refresh button....</h1>
  </div>

<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm" enctype="multipart/form-data">

<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" /><br/>
<input type="hidden" name="hash" value="<?php echo $hash ?>"/><br/>
<input type="hidden" name="txnid" value="<?php echo $txnid ?>" /> <br/>

<!-- Mendatory Fields --> 
<input name="amount" value="<?php echo $amount; ?>"  type="hidden" /><br/>
<input name="firstname" id="firstname" value="<?php echo $firstname; ?>"  type="hidden" /><br/>
<input name="email" id="email" value="<?php echo $email; ?>"  type="hidden" /><br/>
<input name="phone" value="<?php echo $phone; ?>"  type="hidden" /><br/>
<input name="productinfo" value="<?php echo $productinfo; ?>"  type="hidden" /><br/>


<input name="surl" value="<?php echo $baseurl; ?>success.php" size="64" type="hidden" /><br/>
<input name="furl" value="<?php echo $baseurl; ?>failure.php?orn=<?php echo $_GET["orn"]; ?>" size="64"  type="hidden"/><br/>
<input type="hidden" name="service_provider" value="payu_paisa" size="64" /><br/>

<!-- Optional Fields -->
<input name="lastname" id="lastname" value="<?php echo $_SESSION['GTUserLastName']; ?>" type="hidden" /><br/>
<input name="curl" value=""  type="hidden"/><br/>
<input name="address1" value=""  type="hidden"/><br/>
<input name="address2" value=""  type="hidden"/><br/>
<input name="city" value=""  type="hidden"/><br/>
<input name="state" value=""  type="hidden"/><br/>
<input name="country" value=""  type="hidden"/><br/>
<input name="zipcode" value=""  type="hidden"/><br/>
<input name="udf1" value="<?php echo (empty($udf1)) ? '' : $udf1; ?>"  type="hidden"/><br/>
<input name="udf2" value="<?php echo (empty($udf2)) ? '' : $udf1; ?>" type="hidden" /><br/>
<input name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>"  type="hidden"/><br/>
<input name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>"  type="hidden"/><br/>
<input name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>"  type="hidden"/><br/>
<input name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>"  type="hidden"/>   
<!--<input type="submit" name="submit" value="submit"       />-->
  
</form>    
</body>
</html>
<?php } else {  echo "<script>document.location.href='http://www.shapingsteps.com/'</script>"; } ?>