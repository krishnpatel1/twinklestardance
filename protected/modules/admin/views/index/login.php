<?php $this->pageTitle=Yii::app()->name . ' - Login';?>
<div class="login_box">
<h1><?php echo Yii::app()->name . ' Admin';?></h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
        'enableAjaxValidation' => false,
)); ?>
	
<p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
</p>

<div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
</div>

<div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
        <p class="hint">

        </p>
</div>

<div class="row rememberMe">
<div class="remember-me-div fl">
                        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
</div>
<div class="forgot-password-div fl"> 
<a href="<?php echo Yii::app()->createUrl('admin/site/forgot');?>"> Forgot Password? </a>
</div>

</div>



<div class="row buttons">
        <?php echo CHtml::submitButton('Login',array('class'=>'submitbtnclass')); ?>
</div>
	 

<?php $this->endWidget(); ?>
</div><!-- form -->

</div>