<div class="topmargin"></div>
<?php

$form = $this->beginWidget('GxActiveForm', array(
    'id' => 'payment-video-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class="middle">    
    <div class="fix videos"> 
        <?php
        /* echo $form->dropDownList($oMakePaymentForm, 'payment_views', array('1' => 'Monthly Subscriptions', '2' => 'Yearly Subscriptions'), array(
          'class' => 'ddlSelect',
          'onchange' => '$("#payment-video-form").submit();'
          )); */
        ?>
        <div class="topmargin"></div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="yellow"><th>Sr. No.</th><th>Package/Subscription Name</th><th>Term</th><th>Price</th></tr>
            <?php
            $i = 1;
            $totAmount = $snAllSubFullTotal = 0;
            $subscription_duration = 0;

            foreach ($cartItems as $item) 
            {
                $subscription_duration = $item['cart_duration'];
                
            
                echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
                $price = ($item['cart_duration'] == 1 || $item['cart_duration'] == 3) ? $item['price'] : $item['price_one_time'];
                $ssTerm = ($item['cart_duration'] == 1 || $item['cart_duration'] == 3) ? "Monthly" : "Yearly";
                $totAmount += $price;

                $snSubFullPrice = ($item['cart_duration'] == 1) ? ($price * 24) : $price;
                $snAllSubFullTotal += $snSubFullPrice;

                $smPrice = ($item['cart_duration'] == 1 || $item['cart_duration'] == 3) ? Common::priceFormat($price) . ' (monthly) <br />' . Common::priceFormat($item['price_one_time']) . ' (upfront payment)' : Common::priceFormat($price);

                echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . $smPrice . '</td></tr>';
                
            }

            if($subscription_duration == 1)
            {
                $option_params = Yii::app()->params['displayPaymentOption'];
            }
            else if($subscription_duration == 2)
            {
                $option_params = Yii::app()->params['displayUpfrontPaymentOption'];
            }
            else if($subscription_duration == 3)
            {
                $option_params = Yii::app()->params['displayPaymentOption'];
            }

            if($subscription_duration == 1 || $subscription_duration == 3)
            {
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Option</td><td>' . $form->radioButtonList($oMakePaymentForm, 'payment_option', $option_params, array('separator' => "", 'labelOptions' => array('style' => 'display:inline; width:5%; !important;'), 'class' => 'radioOptions')) . '</td></tr>';
           
                $lblRecurringPriceDiv = '<div id="recurring_price_div">' . Common::priceFormat($totAmount) . ' (recurring)' . '</div>';

                $lblFullPriceDiv = '<div id="full_price_div" style="display:none">' . Common::priceFormat($item['price_one_time']) . ' (upfront)' . '</div>';
            }
            else
            {
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Option</td><td>' . $form->radioButtonList($oMakePaymentForm,'payment_option', $option_params, array('separator' => "", 'labelOptions' => array('style' => 'display:inline; width:5%; !important;'), 'class' => 'radioOptions')) . '</td></tr>';
           
                $lblRecurringPriceDiv = '<div id="recurring_price_div">' . Common::priceFormat($totAmount) .'</div>';

                $lblFullPriceDiv = '<div id="full_price_div" style="display:none">' . Common::priceFormat($item['price_one_time']) . ' (upfront)' . '</div>';
            }
            

            echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Total</td><td>' . $lblRecurringPriceDiv . $lblFullPriceDiv . '</td></tr>';
            $ddlPaymentOptionFull = '<div id="full_div" style="display:none;">' . $form->dropDownList($oMakePaymentForm, 'payment_method', Yii::app()->params['displayPaymentMethods'], array('class' => 'ddlSelect')) . '</div>';
            $ddlPaymentOptionDefault = '<div id="recurring_div">' . $form->dropDownList($oMakePaymentForm, 'payment_method', array('1' => "Credit Card / Bank Account"), array('disabled' => 'disabled', 'class' => 'ddlSelect')) . '</div>';
            echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Method</td><td class="ddlSmall">' . $ddlPaymentOptionDefault . $ddlPaymentOptionFull . '</td></tr>';
            echo '</tr>';

            echo GxHtml::hiddenField("totamount", $totAmount);
            echo GxHtml::hiddenField("totamountFull", $snAllSubFullTotal);
            echo GxHtml::hiddenField("payment_views", "1");
    

            ?>
        </table>
        <?php if (!empty($cartItems)): ?>
            <div class="termscondtion fr">

            </div>
            <div class="clear"></div>
            <div class="butt_nav fr">
                <?php
                echo GxHtml::submitButton(Yii::t('app', 'Confirm Order'), array('name' => 'Paypal', 'id' => 'PayPal'));
                ?> 
            </div>
        <?php endif; ?>
    </div>
    <?php $this->endWidget(); ?>    
</div>
<div class="clear"></div>

<script type="text/javascript">

    $(document).ready(function() 
    {
        var subs_duration = '<?php echo $item['cart_duration'] ?>';

        if(subs_duration == 2)
        {
              $('input:radio[class=radioOptions]').prop("checked", true).trigger("click");
        }
      
        $('#paypal').click(function() {
            $('#divCreditCard').hide();
            $('#divPaypal').show();
        });
        $('#creditcard').click(function() {
            $('#divCreditCard').show();
            $('#divPaypal').hide();
        });
        if ($('#paypal').is(':checked')) {
            $('#paypal').click();
        }
        if ($('#creditcard').is(':checked')) {
            $('#creditcard').click();
        }

    });

    $('[type="radio"]').click(function() 
    {
        if (this.value == <?php echo Yii::app()->params['comparePaymentOption']['recurring']; ?>) 
        {
            $("table td:contains('Yearly')").html('Monthly');

            $('#recurring_div').show();
            $('#recurring_price_div').show();

            $('#full_div').hide();
            $('#full_price_div').hide();
        }
        else 
        {
            $("table td:contains('Monthly')").html('Yearly');

            $('#full_div').show();
            $('#full_price_div').show();

            $('#recurring_div').hide();
            $('#recurring_price_div').hide();
        }
    });
</script>
