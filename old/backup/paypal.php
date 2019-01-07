<? include("includes/connection.php");
?>
<html>
  <head><title>Processing Payment...</title></head>
     <body onLoad="document.forms['paypal_form'].submit();">
     <center><h2>Please wait, your order is being processed and you
      will be redirected to the paypal website.</h2></center>
<form method="POST" action="https://payflowlink.paypal.com" name="paypal_form">
<input type="hidden" name="LOGIN" value="Twinklestardance">
<input type="hidden" name="PARTNER" value="PayPal">
<input type="hidden" name="DESCRIPTION" value="Order description here">
<input type="hidden" name="AMOUNT" value="<?=$_SESSION['pay_amount']?>">
<input type="hidden" name="TYPE" value="S">
<center><br/><br/>If you are not automatically redirected to
      paypal within 5 seconds...<br/><br/>
      <input type="submit" value="Click Here to Purchase"></center>
</form>
</body>
</html>