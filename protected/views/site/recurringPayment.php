<script type="text/javascript">
    $(window).load(function() {
        $("#processing").fadeOut("slow");
    });
</script>
<!-- Preloader -->
<div id="processing"></div>
<div class="inner_page" id="formInner">
    <div class="fix">
        <div class="one_subscription">            
            <h2>Twinkle Star&trade; DANCE LLC</h2>
            <?php
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
            <div class="rightPanel">
                <div style="margin-left: 5px; margin-top: 5px;font-size: 16px;">Order Summary</div>
                <div style="border-bottom:2px solid; margin-left: 5px; margin-right: 5px;"></div>
                <?php
                if ($omOrder):
                    $bIsYearlyPaymentIncluded = false;
                    $snTotRecurringAmt = $snTotYearlyAmt = 0;
                    foreach ($omOrder->orderDetails as $omOrderDetails):
                        if ($omOrderDetails->duration == 1) {
                            $snTotRecurringAmt += $omOrderDetails->amount;
                        } else {
                            $snTotYearlyAmt += $omOrderDetails->amount;
                            $bIsYearlyPaymentIncluded = true;
                        }
                    endforeach;
                endif;
                ?>
                <table cellspadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>Total Recurring Amount (USD)</td>
                        <td width="30%">: <?php echo Common::priceFormat($snTotRecurringAmt); ?></td>
                    </tr>                
                    <?php if ($bIsYearlyPaymentIncluded): ?>
                        <tr>
                            <td>Total Full Pay Amount (USD)</td>
                            <td width="30%">: <?php echo Common::priceFormat($snTotYearlyAmt); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="leftPanel">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'online-payment-form',
                    'enableAjaxValidation' => false,
                ));
                //echo $form->errorSummary($PayFlowPaymentForm);
                if (!$bIsYearlyPaymentIncluded):
                    ?>
                    <div class="row rowTable">  
                        <?php echo $form->labelEx($PayFlowPaymentForm, 'payment_method'); ?>
                        <?php echo $form->radioButtonList($PayFlowPaymentForm, 'payment_method', array('C' => 'Credit Card', 'A' => 'Bank Account'), array('separator' => '', 'labelOptions' => array('style' => 'display:inline; width:18% !important;'), 'onclick' => 'showHideDiv(this.value);', 'style' => 'display:inline; width:3% !important;')); ?>
                        <?php echo $form->error($PayFlowPaymentForm, 'payment_method'); ?>
                    </div>
                    <?php
                else:
                    echo $form->hiddenField($PayFlowPaymentForm, 'payment_method', array('value' => 'C'));
                endif;
                ?>
                <div id="credit_card_div" <?php echo ($PayFlowPaymentForm->payment_method == 'C') ? '' : 'style="display:none;"' ?>>
                    <div class="row rowTable">  
                        <?php echo $form->labelEx($PayFlowPaymentForm, 'card_number'); ?>
                        <?php echo $form->textField($PayFlowPaymentForm, 'card_number', array('autocomplete' => 'off')); ?>
                        <div class="card_types">
                            <?php echo CHtml::image(Yii::app()->baseUrl . '/images/card_types.png'); ?>
                        </div>
                        <?php echo $form->error($PayFlowPaymentForm, 'card_number'); ?>
                    </div>            
                    <div class="row rowTable">  
                        <?php
                        echo '<label class="error required" for="PayFlowPaymentForm_expiry_date">Expiry Date<span class="required">*</span></label>';
                        echo $form->textField($PayFlowPaymentForm, 'expiration_month', array('autocomplete' => 'off', 'style' => 'width:50px;margin-right:10px;', 'placeholder' => 'MM'));
                        echo $form->textField($PayFlowPaymentForm, 'expiration_year', array('autocomplete' => 'off', 'style' => 'width:50px;', 'placeholder' => 'YY'));
                        echo $form->error($PayFlowPaymentForm, 'expiration_month');
                        echo $form->error($PayFlowPaymentForm, 'expiration_year');
                        ?>
                    </div>
                </div>
                <div id="bank_account_div" <?php echo ($PayFlowPaymentForm->payment_method == 'A') ? '' : 'style="display:none;"' ?>>
                    <div class="row rowTable">  
                        <?php echo $form->labelEx($PayFlowPaymentForm, 'account_number'); ?>
                        <?php echo $form->textField($PayFlowPaymentForm, 'account_number', array('autocomplete' => 'off')); ?>
                        <?php echo $form->error($PayFlowPaymentForm, 'account_number'); ?>
                    </div>
                    <div class="row rowTable">  
                        <?php echo $form->labelEx($PayFlowPaymentForm, 'routing_number'); ?>
                        <?php echo $form->textField($PayFlowPaymentForm, 'routing_number', array('autocomplete' => 'off')); ?>
                        <?php echo $form->error($PayFlowPaymentForm, 'routing_number'); ?>
                    </div>
                    <div class="row rowTable">  
                        <?php echo $form->labelEx($PayFlowPaymentForm, 'account_type'); ?>
                        <?php echo $form->radioButtonList($PayFlowPaymentForm, 'account_type', array('S' => 'Saving', 'C' => 'Checking'), array('separator' => '', 'labelOptions' => array('style' => 'display:inline; width:18% !important;'), 'style' => 'display:inline; width:3% !important;')); ?>
                        <?php echo $form->error($PayFlowPaymentForm, 'account_type'); ?>
                    </div>
                </div>
                <div class="row rowTable">
                    <h1>Billing Information</h1>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'first_name'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'first_name', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'first_name'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'last_name'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'last_name', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'last_name'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'email'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'email', array('disabled' => 'disabled', 'readonly' => true, 'autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'email'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'address_1'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'address_1', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'address_1'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'phone_number'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'phone_number', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'phone_number'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'country_code'); ?>
                    <?php echo $form->dropDownList($PayFlowPaymentForm, 'country_code', array('US' => 'United States of America'), array('disabled' => 'disabled', 'autocomplete' => 'off', 'class' => 'ddlSelect')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'country_code'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'state_code'); ?>
                    <?php echo $form->dropDownList($PayFlowPaymentForm, 'state_code', $amStates, array('prompt' => 'Select', 'autocomplete' => 'off', 'class' => 'ddlSelect')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'state_code'); ?>
                </div>
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'city'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'city', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'city'); ?>
                </div>            
                <div class="row rowTable">  
                    <?php echo $form->labelEx($PayFlowPaymentForm, 'zip'); ?>
                    <?php echo $form->textField($PayFlowPaymentForm, 'zip', array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($PayFlowPaymentForm, 'zip'); ?>
                </div>
                <div class="clear"></div>
                <div class="recurring_text">
                    <h1 class="recurrin_heading_text">Automatic Recurring Payment Terms</h1><div class="clear"></div>
                    <div class="recurring_text_content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.

                    </div>
                </div>
                <div class="clear"></div>
                <div class="recurring_agree_box">
                    <?php echo CHtml::CheckBox('is_agree') . ' ' . Yii::t('app', 'I AGREE to the Automatic Recurring Payment Terms Aboves'); ?>
                </div>
                <div class="clear"></div>
                <div class="row buttrow">
                    <?php echo GxHtml::submitButton(Yii::t('app', 'Pay Now'), array('name' => 'PayNow', 'id' => 'PayNow', 'class' => 'pay_now')); ?> 
                </div>
                <?php $this->endWidget(); ?>
            </div>

        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    $("#formInner input:text")[0].focus();
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
    $("#PayNow").click(function() {
        if ($('#is_agree').is(':checked')) {
            $("#processing").fadeIn("slow");
            return true;
        } else {
            alert("Please check agree to terms");
            return false;
        }

    });
    function showHideDiv(snValue) {
        if (snValue == 'C') {
            $('#credit_card_div').show();
            $('#bank_account_div').hide();

        } else {
            $('#bank_account_div').show();
            $('#credit_card_div').hide();
        }
    }
    ;
</script>