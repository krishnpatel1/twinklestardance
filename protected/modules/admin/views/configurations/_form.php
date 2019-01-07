<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <div class="basic_nav_center">
                <?php
                $form = $this->beginWidget('GxActiveForm', array(
                    'id' => 'configurations-form',
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php echo $form->errorSummary($model); ?>

                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'paypal_partner'); ?></h6>
                    <?php echo $form->textField($model, 'paypal_partner', array('maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'paypal_partner'); ?>
                </div><!-- row -->
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'paypal_merchant_login'); ?></h6>
                    <?php echo $form->textField($model, 'paypal_merchant_login', array('maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'paypal_merchant_login'); ?>
                </div><!-- row -->
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'paypal_password'); ?></h6>
                    <?php echo $form->textField($model, 'paypal_password', array('maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'paypal_password'); ?>
                </div><!-- row -->
                <div class="info2 ddlSmall2">
                    <h6><?php echo $form->labelEx($model, 'paypal_payment_mode'); ?></h6>
                    <?php echo $form->dropDownList($model, 'paypal_payment_mode', Yii::app()->params['paypalMode'], array('class' => 'styled')); ?>
                    <?php echo $form->error($model, 'paypal_payment_mode'); ?>
                </div><!-- row -->
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'facebook_appid'); ?></h6>
                    <?php echo $form->textField($model, 'facebook_appid', array('maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'facebook_appid'); ?>
                </div><!-- row -->
                <?php /*
                  <div class="info2">
                  <h6><?php echo $form->labelEx($model, 'facebook_secret'); ?></h6>
                  <?php echo $form->textField($model, 'facebook_secret', array('maxlength' => 255)); ?>
                  <?php echo $form->error($model, 'facebook_secret'); ?>
                  </div><!-- row --> */ ?>
                <div class="info2">
                    <label>&nbsp;</label>
                    <?php echo GxHtml::submitButton(Yii::t('app', 'Save'), array('class' => 'submitbtnclass')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>







