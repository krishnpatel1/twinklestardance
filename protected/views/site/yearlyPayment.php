        
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr class="yellow"><th>Sr. No.</th><th>Package/Subscription Name</th><th>Term</th><th>Price</th></tr>
    <?php
    $i = 1;
    $totAmount = 0;
    $bIsRecordsFound = false;
    foreach ($cartItems as $item) {
        if ($item['cart_duration'] == 2) {
            $bIsRecordsFound = true;
            echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
            $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
            $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
            $totAmount += $price;
            echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . Common::priceFormat($price) . '</td></tr>';
        }
    }
    if ($bIsRecordsFound):
        echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Total</td><td>' . Common::priceFormat($totAmount) . '</td></tr>';
        echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Method</td><td class="ddlSmall">' . $form->dropDownList($oMakePaymentForm, 'payment_method', Yii::app()->params['displayPaymentMethods'], array('class' => 'ddlSelect')) . '</td></tr>';
        echo '</tr>';

        echo GxHtml::hiddenField("totamount", $totAmount);

    else:
        echo '<tr><td>No records found</td></tr>';
    endif;
    ?>    
</table>
<?php if ($bIsRecordsFound): ?>
    <div class="termscondtion fr">
        <?php echo CHtml::CheckBox('is_agree') . Yii::t('app', 'Agree to Terms'); ?>
    </div>
    <div class="clear"></div>
    <div class="butt_nav fr">
        <?php
        echo GxHtml::button(Yii::t('app', 'Continue Shopping'), array('onclick' => 'window.location = "' . CController::createUrl('site/subscriptions') . '"')) . '&nbsp;';
        echo GxHtml::submitButton(Yii::t('app', 'Confirm Order'), array('name' => 'Paypal', 'id' => 'PayPal'));
        ?> 
    </div>
<?php endif; ?>

