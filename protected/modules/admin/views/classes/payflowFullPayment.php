<script type="text/javascript">
    $(window).load(function() {
        $("#processing").fadeOut("slow");
    });
</script>
<!-- Preloader -->
<div id="processing" style="display:none;"></div>
<div class="inner_page" id="formInner">
    <div class="fix">
        <div class="one_subscription">
            <h2>Twinkle Star&trade; DANCE LLC</h2>
            <div class="rightPanel">
                <div style="margin-left: 5px; margin-top: 5px;font-size: 16px;">Order Summary</div>
                <div style="border-bottom:2px solid; margin-left: 5px; margin-right: 5px;"></div>
                <div style="margin-left: 5px; margin-top: 5px;font-size: 16px;">Total (USD): <?php echo Common::priceFormat($snCheckoutPrice); ?></div>
            </div>
            <div class="leftPanel">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'online-payment-from',
                    'enableAjaxValidation' => false,
                ));
                //echo $form->errorSummary($PayFlowPaymentForm);
                foreach (Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
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
                    echo '<label class="error required" for="PayFlowPaymentForm_expiry_date" style="width:100px;">Expiry Date<span class="required">*</span></label>';
                    echo $form->textField($PayFlowPaymentForm, 'expiration_month', array('autocomplete' => 'off', 'style' => 'width:50px;margin-right:10px;', 'placeholder' => 'MM'));
                    echo $form->textField($PayFlowPaymentForm, 'expiration_year', array('autocomplete' => 'off', 'style' => 'width:50px;', 'placeholder' => 'YY'));
                    echo $form->error($PayFlowPaymentForm, 'expiration_month');
                    echo $form->error($PayFlowPaymentForm, 'expiration_year');
                    ?>
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
                    <?php echo $form->textField($PayFlowPaymentForm, 'email', array('readonly' => true, 'autocomplete' => 'off')); ?>
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
                <div class="row buttrow">
                    <?php echo GxHtml::submitButton(Yii::t('app', 'Pay Now'), array('name' => 'PayNow', 'id' => 'PayNow')); ?> 
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
        $("#processing").fadeIn("slow");
        return true;
    });
</script>