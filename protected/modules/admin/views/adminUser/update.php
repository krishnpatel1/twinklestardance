<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Settings') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Settings') . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => false,
                    ));
            ?>

            <div class="basic_nav_center">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'username'); ?>:</h6>
                    <?php echo $model->username; ?>
                </div>
                <div class="clear">&nbsp;</div>
                <div class="info2">
                    <h2>Change Password</h2>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'password'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'password', array('size' => 20, 'value' => '')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'rpassword'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'rpassword', array('size' => 20, 'value' => '')); ?>
                    <?php echo $form->error($model, 'rpassword'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'email'); ?>:</h6>
                    <?php echo $form->textField($model, 'email', array('size' => 50)); ?>&nbsp;&nbsp;Multiple email should be comma seperated.
                    <?php echo $form->error($model, 'email'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'contact_email'); ?>:</h6>
                    <?php echo $form->textField($model, 'contact_email', array('size' => 50)); ?>
                    <?php echo $form->error($model, 'contact_email'); ?>
                </div>
                <div class="info2">
                    <?php
                    echo GxHtml::submitButton(Yii::t('app', 'Save')) . '&nbsp;';
                    echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                    ?>                   
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
        </div>
    </div>
</div>