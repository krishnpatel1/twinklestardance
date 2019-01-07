<div class="inner_page">
    <div class="fix">
        <div class="newsletter_info">
            <h2>
                Twinkle Bear Books
                <div class="button2">
                    <?php echo CHtml::button('Sign Up', array('onclick' => 'js:openColorBox("' . CController::createUrl("index/joinNewsletter") . '",400,300);return false;', 'class' => 'ajax')); ?>
                </div>
                <div class="text-sub">
                    Join our Mailing List for FREE offers and tips on how to grow your studio with Twinkle Bear
                </div>
            </h2>
            <div class="flash_message">
                <?php
                foreach (Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="fix">
        <div class="contact_page">
            <div class="contact_left fl">
                <p>Twinkle Star Dance™<br />
                    4046 East Avenue<br />
                    Livermore, CA 94550</p>
                <p>Phone: <br />
                    <font>925.583.2830</font><br />
                    Email:<br />
                    <font><a href="mailto:info@TwinkleStarDance.com">info@TwinkleStarDance.com</a></font></p>
            </div>
            <div class="contact_right fr">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'signup-form',
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                // echo $form->errorSummary($model);
                ?>                
                <div class="row">
                    <?php echo $form->textField($model, 'contact_name', array('onfocus' => 'gotFocus(this);', 'onblur' => 'lostFocus(this);')); ?>
                    <?php echo $form->error($model, 'contact_name'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model, 'contact_email', array('onfocus' => 'gotFocus(this);', 'onblur' => 'lostFocus(this);')); ?>
                    <?php echo $form->error($model, 'contact_email'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model, 'contact_phone', array('onfocus' => 'gotFocus(this);', 'onblur' => 'lostFocus(this);')); ?>
                    <?php echo $form->error($model, 'contact_phone'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model, 'contact_subject', array('onfocus' => 'gotFocus(this);', 'onblur' => 'lostFocus(this);')); ?>
                    <?php echo $form->error($model, 'contact_subject'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textArea($model, 'contact_message', array('onfocus' => 'gotFocus(this);', 'onblur' => 'lostFocus(this);')); ?>
                    <?php echo $form->error($model, 'contact_message'); ?>
                </div>                    
                <div class="row"> <?php echo CHtml::submitButton('Submit'); ?></div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
