<div class="inner_page">
    <div class="fix">
        <h2>Forgot your password?</h2>
        <div class="flash_message">
            <?php
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
        </div>
    </div>
    <div class="fix">
        <div class="contact_page">
            <div class="contact_right">                
                <p class="note">Please enter the e-mail address you used to register. We will e-mail your account details shortly.</p>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'forgot-pwd-form',
                    'enableClientValidation' => false
                ));?>
                <div class="row">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>                               
                <div class="row"> <?php echo CHtml::submitButton('Submit'); ?></div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>