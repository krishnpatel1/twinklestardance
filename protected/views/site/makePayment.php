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
            $bArrMonthlyYearly = $bArrMonthly = $bArrYearly = $bIsRecordsFoundMonthly = $bIsRecordsFoundYearly = false;             
            foreach ($cartItems as $item) {
                if ($item['cart_duration'] == 1) {
                    $bArrMonthly = true;
                }
                if ($item['cart_duration'] == 2) {
                    $bArrYearly = true;
                }
            }
            if ($bArrMonthly && $bArrYearly) {
                $bArrMonthlyYearly = true;
            }

            foreach ($cartItems as $item) {

                // FOR ONLY MONTHLY //
                if (!$bArrMonthlyYearly && $bArrMonthly) {
                    $bIsRecordsFoundMonthly = true;
                    echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
                    $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
                    $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
                    $totAmount += $price;

                    $snSubFullPrice = ($item['cart_duration'] == 1) ? ($price * 24) : $price;
                    $snAllSubFullTotal += $snSubFullPrice;

                    $smPrice = ($item['cart_duration'] == 1) ? Common::priceFormat($price) . ' (monthly) <br />' . Common::priceFormat($snSubFullPrice) . ' (full payment)' : Common::priceFormat($price);
                    echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . $smPrice . '</td></tr>';
                }
                // FOR ONLY YEARLY //
                if (!$bArrMonthlyYearly && $bArrYearly) {
                    $bIsRecordsFoundYearly = true;
                    echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
                    $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
                    $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
                    $totAmount += $price;
                    echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . Common::priceFormat($price) . '</td></tr>';
                }

                if ($bArrMonthlyYearly) {
                    if ($item['cart_duration'] == 1) {
                        $bIsRecordsFoundMonthly = true;
                        echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
                        $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
                        $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
                        $totAmount += $price;

                        $snSubFullPrice = ($item['cart_duration'] == 1) ? ($price * 24) : $price;
                        $snAllSubFullTotal += $snSubFullPrice;

                        //$smPrice = ($item['cart_duration'] == 1) ? Common::priceFormat($price) . ' (monthly) <br />' . Common::priceFormat($snSubFullPrice) . ' (full payment)' : Common::priceFormat($price);
                        echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . Common::priceFormat($price) . ' (recurring)</td></tr>';
                    }

                    if ($item['cart_duration'] == 2) {
                        $bIsRecordsFoundYearly = true;
                        echo GxHtml::hiddenField("cartIds[]", $item['cart_id']);
                        $price = ($item['cart_duration'] == 1) ? $item['price'] : $item['price_one_time'];
                        $ssTerm = ($item['cart_duration'] == 1) ? "Monthly" : "Yearly";
                        $totAmount += $price;
                        echo '<tr><td style="width:10%;text-align:center;vertical-align:middle;">' . $i++ . '</td><td style="width:65%;vertical-align:middle;">' . $item['name'] . '</td><td>' . $ssTerm . '</td><td>' . Common::priceFormat($price) . '</td></tr>';
                    }
                }
            }

            // FOR ONLY YEARLY PAYMENT //
            if ($bIsRecordsFoundYearly && !$bIsRecordsFoundMonthly):
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Total</td><td>' . Common::priceFormat($totAmount) . '</td></tr>';
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Method</td><td class="ddlSmall">' . $form->dropDownList($oMakePaymentForm, 'payment_method', Yii::app()->params['displayPaymentMethods'], array('class' => 'ddlSelect')) . '</td></tr>';
                echo '</tr>';

                echo GxHtml::hiddenField("totamount", $totAmount);
                echo GxHtml::hiddenField("payment_views", "2");
                
            endif;
            // FOR ONLY MONTHLY PAYMENT //
            if (!$bIsRecordsFoundYearly && $bIsRecordsFoundMonthly):
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
                echo GxHtml::hiddenField("payment_views", "1");
            endif;
            // FOR BOTH (YEARLY / MONTHLY PAYMENT //
            if ($bIsRecordsFoundYearly && $bIsRecordsFoundMonthly):
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Total</td><td>' . Common::priceFormat($totAmount) . '</td></tr>';
                $ddlPaymentOptionFull = '<div id="full_div" style="display:none;">' . $form->dropDownList($oMakePaymentForm, 'payment_method', Yii::app()->params['displayPaymentMethods'], array('class' => 'ddlSelect')) . '</div>';
                $ddlPaymentOptionDefault = '<div id="recurring_div">' . $form->dropDownList($oMakePaymentForm, 'payment_method', array('1' => "Credit / Debit Card"), array('disabled' => 'disabled', 'class' => 'ddlSelect')) . '</div>';
                echo '<tr><td style="width:10%;">&nbsp;</td><td style="width:65%;text-align:right;" colspan="2">Payment Method</td><td class="ddlSmall">' . $ddlPaymentOptionDefault . $ddlPaymentOptionFull . '</td></tr>';
                echo '</tr>';

                echo GxHtml::hiddenField("totamount", $totAmount);
                echo GxHtml::hiddenField("payment_views", "1");                
                echo $form->hiddenField($oMakePaymentForm,'payment_option',array('value'=>'1'));
            endif;
            ?>
        </table>
        <?php if ($bIsRecordsFoundMonthly || $bIsRecordsFoundYearly): ?>
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

        <?php
        /* $this->renderPartial($ssView, array(
          'cartItems' => $cartItems,
          'oMakePaymentForm' => $oMakePaymentForm,
          'form' => $form
          )); */
        ?>
    </div>
    <?php $this->endWidget(); ?>    
</div>
<div class="clear"></div>

<script type="text/javascript">

    $(document).ready(function() {
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
    $("#PayPal").click(function() {
        if ($('#is_agree').is(':checked')) {
            return true;
        } else {
            alert("Please check agree to terms");
            return false;
        }

    });

    $("#is_agree").click(function() {
        window.open('<?php echo CController::createUrl('index/cms', array('id' => 'term_of_use')) ?>', '_blank');
    });
    $('[type="radio"]').click(function() {
        if (this.value == <?php echo Yii::app()->params['comparePaymentOption']['recurring']; ?>) {
            $('#recurring_div').show();
            $('#recurring_price_div').show();

            $('#full_div').hide();
            $('#full_price_div').hide();
        } else {
            $('#full_div').show();
            $('#full_price_div').show();

            $('#recurring_div').hide();
            $('#recurring_price_div').hide();
        }
    });
</script>
