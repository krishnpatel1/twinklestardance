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
                    <h2><?php echo $model->username; ?></h2>
                </div>
                <div class="clear">&nbsp;</div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'first_name'); ?>:</h6>
                    <?php echo $form->textField($model, 'first_name',array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'last_name'); ?>:</h6>
                    <?php echo $form->textField($model, 'last_name',array('autocomplete' => 'off')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
                <div class="info2">
                    <h1>Change Password</h1>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'password'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'password', array('autocomplete' => 'off','size' => 20, 'value' => '')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'rpassword'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'rpassword', array('autocomplete' => 'off','size' => 20, 'value' => '')); ?>
                    <?php echo $form->error($model, 'rpassword'); ?>
                </div>
                <?php if (AdminModule::isAdmin()): ?>
                    <div class="info2">
                        <h6><?php echo $form->labelEx($model, 'other_email'); ?>:</h6>
                        <?php echo $form->textField($model, 'other_email', array('size' => 50)); ?><br /> <span style="color:yellowgreen;">Note: Multiple email should be comma seperated.</span>
                        <?php echo $form->error($model, 'other_email'); ?>
                    </div>
                    <div class="info2">
                        <h6><?php echo $form->labelEx($model, 'contact_email'); ?>:</h6>
                        <?php echo $form->textField($model, 'contact_email', array('size' => 50, 'autocomplete' => 'off')); ?>
                        <?php echo $form->error($model, 'contact_email'); ?>
                    </div>
                <?php else: ?>
                    <div class="info2">
                        <h6><?php echo $form->labelEx($model, 'email'); ?>:</h6>
                        <?php echo $form->textField($model, 'email', array('size' => 50, 'autocomplete' => 'off')); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                    <div class="info2">
                        <h6><?php echo $form->labelEx($model, 'address_1'); ?>:</h6>
                        <?php echo $form->textArea($model, 'address_1', array('rows' => 5, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'address_1'); ?>
                    </div>
                <?php endif; ?>
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