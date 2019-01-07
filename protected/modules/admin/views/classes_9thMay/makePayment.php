<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Classes::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    "<font>&nbsp;</font>" . $oModelClass->name . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => CController::createUrl('classes/listClassVideos', array("id" => $oModelClass->id))),
    Yii::t('app', 'Make Payment') => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Make Payment') . "<span>&nbsp;</span>")
);
$form = $this->beginWidget('GxActiveForm', array(
    'id' => 'payment-video-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="middle">    
    <div class="fix videos"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="yellow"><th>Sr. No.</th><th>Video Name</th><th>Price</th></tr>
            <?php
            $i = 1;
            $totAmount = 0;            
            foreach ($purchaseDetails as $video) {
                $totAmount += $video['price'];
                echo '<tr><td style="width:20%;">' . $i++ . '</td><td style="width:60%;">' . $video['title'] . '</td><td>' . Common::priceFormat($video['price']) . '</td></tr>';
            }
            echo '<tr><td style="width:20%;">&nbsp;</td><td style="width:60%;text-align:right;font-weight:bold;">Total Amount:</td><td><strong>' . Common::priceFormat($totAmount) . '</strong></td></tr>';
            //echo '<tr><td style="width:20%;">Payment through</td><td style="width:60%;text-align:right;"><input type="radio" name="payment" id="paypal" value="paypal" />Paypal</td><td><input type="radio" name="payment" id="creditcard" value="creditcard" checked="checked" />Credit Card</td></tr>';
            echo '</tr>';
            ?>
        </table>
    </div>

    <?php
    echo GxHtml::hiddenField("totamount", $totAmount);
    echo GxHtml::hiddenField("id", $oModelClass->id);
    echo GxHtml::hiddenField("videoids", $smSelectedVideos);
    ?>
    <div class="topmargin"></div>
    <div class="fix videos"> 
        <div class="termscondtion fr">
            <?php echo CHtml::CheckBox('is_agree').Yii::t('app','Agree to Terms'); ?>
        </div>
        <div class="clear"></div>
        <div class="butt_nav fr">
            <?php
            echo GxHtml::button(Yii::t('app', 'Back'), array('onclick' => 'javascript:history.go(-1);')) . '&nbsp;';
            echo GxHtml::submitButton(Yii::t('app', 'Confirm Order'), array('name' => 'Paypal', 'id' => 'PayPal'));
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
    
    <!-- REMOVE BELOW CONTENT AFTER FINISHED TESTING -->
    <?php /*
    
    <div class="fix videos divpaypal" id="divPaypal" style="display:none;">        
        <?php
        echo GxHtml::submitButton('PayPal', array('class' => 'paypalbtnclass', 'name' => 'Paypal'));
        ?>
    </div>
    <div class="fix videos" id="divCreditCard" style="display:none;">        
        <div class="basic_nav checkout_form">
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'card_type'); ?>
                <div class="mar_t5 card_type">
                	<?php echo $form->dropDownList($oCreditCardForm, 'card_type', Yii::app()->params['amPaymentType'],array('class'=>'styled')); ?>
                </div>
                <?php echo $form->error($oCreditCardForm, 'card_type'); ?>
            </div> 
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'card_number'); ?>
                <?php echo $form->textField($oCreditCardForm, 'card_number', array('autocomplete' => 'off', 'maxlength' => '16','value'=>'4728984236978688')); ?>
                <?php echo $form->error($oCreditCardForm, 'card_number'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'expiration_month'); ?>
                <div class="fl month mar_t5">
                	<?php echo $form->dropDownList($oCreditCardForm, 'expiration_month', Yii::app()->params['amExpirationMonth'],array('class'=>'styled','options'=>array(2=>array('selected'=>'selected')))); ?>
                </div>
                <div class="fl year mar_t5">
                	 <?php echo $form->dropDownList($oCreditCardForm, 'expiration_year', Yii::app()->params['amExpirationYear'],array('class'=>'styled','options'=>array(2018=>array('selected'=>'selected')))); ?>
                </div>
            </div>           
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'cvv'); ?>
                <?php echo $form->textField($oCreditCardForm, 'cvv', array('autocomplete' => 'off', 'maxlength' => '4','class'=>'cvv','value'=>'688')); ?>
                <?php echo $form->error($oCreditCardForm, 'cvv'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'firstname'); ?>
                <?php echo $form->textField($oCreditCardForm, 'firstname', array('autocomplete' => 'off','value'=>'Test'.date("d(H:i)"))); ?>
                <?php echo $form->error($oCreditCardForm, 'firstname'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'lastname'); ?>
                <?php echo $form->textField($oCreditCardForm, 'lastname', array('autocomplete' => 'off','value'=>'Test')); ?>
                <?php echo $form->error($oCreditCardForm, 'lastname'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'address1'); ?>
                <?php echo $form->textField($oCreditCardForm, 'address1', array('autocomplete' => 'off','value'=>'Address1')); ?>
                <?php echo $form->error($oCreditCardForm, 'address1'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'address2'); ?>
                <?php echo $form->textField($oCreditCardForm, 'address2', array('autocomplete' => 'off','value'=>'Address2')); ?>
                <?php echo $form->error($oCreditCardForm, 'address2'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'zipcode'); ?>
                <?php echo $form->textField($oCreditCardForm, 'zipcode', array('autocomplete' => 'off', 'maxlength' => '9','class'=>'zipcode','value'=>'262626')); ?>
                <?php echo $form->error($oCreditCardForm, 'zipcode'); ?>
            </div>      
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'country'); ?>
                <?php
                echo $form->dropDownList($oCreditCardForm, 'country', $listCountry, array(
					'class'=>'styled','options'=>array(223=>array('selected'=>'selected')),
                    'prompt' => '--Select Country--',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('getListState'),
                        'update' => '#' . CHtml::activeId($oCreditCardForm, 'state'),
                        'data' => array('countryid' => 'js:this.value'),
                        )));
                ?>
                <?php echo $form->error($oCreditCardForm, 'country'); ?>
            </div>
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'state'); ?>
                <div class="fl card_type">
                	<?php echo $form->dropDownList($oCreditCardForm, 'state', array('' => '--Select State'),array('class'=>'styled')); ?>
                </div>
                <?php echo $form->error($oCreditCardForm, 'state'); ?>
            </div>  
            <div class="box">
                <?php echo $form->labelEx($oCreditCardForm, 'city'); ?>
                <?php echo $form->textField($oCreditCardForm, 'city', array('autocomplete' => 'off','class'=>'city','value'=>'NewYork')); ?>
                <?php echo $form->error($oCreditCardForm, 'city'); ?>
            </div>            


            <div class="clear">&nbsp;</div>
            <div class="info2">
                <?php
                echo GxHtml::submitButton(Yii::t('app', 'Go'), array('name' => 'Creditcard')) . '&nbsp;';
                echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                ?>                   
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="clear"></div>
    </div> <?php */?>
</div>
<script type="text/javascript">   	

    $(document).ready(function() {
        $('#paypal').click(function(){
            $('#divCreditCard').hide();
            $('#divPaypal').show();
        });
        $('#creditcard').click(function(){
            $('#divCreditCard').show();
            $('#divPaypal').hide();
        });
        if($('#paypal').is(':checked')) { $('#paypal').click(); }
        if($('#creditcard').is(':checked')) { $('#creditcard').click(); }
        
    });
    $("#PayPal").click(function(){  
        if ($('#is_agree').is(':checked')) {
            return true
        }
        return false;
    });
    
    $("#is_agree").click(function(){
        window.open('<?php echo CController::createUrl('/index/cms',array('id'=>'term_of_use')) ?>', '_blank');
    });
</script>
