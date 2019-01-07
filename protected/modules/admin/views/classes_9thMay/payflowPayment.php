<html>
    <head><title>Processing Payment...</title></head>
    <body onLoad="document.forms['paypal_form'].submit();">
    <center><h2>Please wait, your order is being processed and you will be redirected to the paypal website.</h2></center>
    <form method="POST" action="<?php echo Yii::app()->params['PAYPAL_URL']?>" name="paypal_form">
        <input type="hidden" name="LOGIN" value="<?php echo Yii::app()->params['LOGIN']?>">
        <input type="hidden" name="PARTNER" value="<?php echo Yii::app()->params['PARTNER']?>">
        <input type="hidden" name="DESCRIPTION" value="Order description here">
        <input type="hidden" name="CUSTID" value="<?php echo $ssRequestData ?>">
        <input type="hidden" name="AMOUNT" value="<?php echo $snTotalPrice ?>">
        <input type="hidden" name="TYPE" value="S">
        
        <center><br/><br/>If you are not automatically redirected topaypal within 5 seconds...<br/><br/>
        <input type="submit" value="Click Here to Purchase"></center>
    </form>
</body>
</html>