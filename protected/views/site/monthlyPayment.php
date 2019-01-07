<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr class="yellow"><th>Sr. No.</th><th>Package/Subscription Name</th><th>Term</th><th>Price</th></tr>
    <?php
    $i = 1;
    $totAmount = $snAllSubFullTotal = 0;
    $bIsRecordsFound = false;
    foreach ($cartItems as $item) {
        if ($item['cart_duration'] == 1) {
            $bIsRecordsFound = true;
            echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
            $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
            $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
            $totAmount += $price;

            $snSubFullPrice = ($item['cart_duration'] == 1) ? ($price * 24) : $price;
            $snAllSubFullTotal += $snSubFullPrice;

            $smPrice = ($item['cart_duration'] == 1) ? Common::priceFormat($price) . ' (monthly) <br />' . Common::priceFormat($snSubFullPrice) . ' (full payment)' : Common::priceFormat($price);
            echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . $smPrice . '</td></tr>';
        }
    }
    if ($bIsRecordsFound):
        echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Option</td><td>' . $form->radioButtonList($oMakePaymentForm, 'payment_option', Yii::app()->params['displayPaymentOption'], array('separator' => "", 'labelOptions' => array('style' => 'display:inline; width:5%; !important;'), 'class' => 'radioOptions')) . '</td></tr>';
        $lblRecurringPriceDiv = '<div id="recurring_price_div">' . Common::priceFormat($totAmount) . ' (recurring)' . '</div>';
        $lblFullPriceDiv = '<div id="full_price_div" style="display:none">' . Common::priceFormat($snAllSubFullTotal) . ' (full payment)' . '</div>';
        echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Total</td><td>' . $lblRecurringPriceDiv . $lblFullPriceDiv . '</td></tr>';
        $ddlPaymentOptionFull = '<div id="full_div" style="display:none;">' . $form->dropDownList($oMakePaymentForm, 'payment_method', Yii::app()->params['displayPaymentMethods'], array('class' => 'ddlSelect')) . '</div>';
        $ddlPaymentOptionDefault = '<div id="recurring_div">' . $form->dropDownList($oMakePaymentForm, 'payment_method', array('1' => "Credit Card / Bank Account"), array('disabled' => 'disabled', 'class' => 'ddlSelect')) . '</div>';
        echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Method</td><td class="ddlSmall">' . $ddlPaymentOptionDefault . $ddlPaymentOptionFull . '</td></tr>';
        echo '</tr>';

        echo GxHtml::hiddenField("totamount", $totAmount);
        echo GxHtml::hiddenField("totamountFull", $snAllSubFullTotal);

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
