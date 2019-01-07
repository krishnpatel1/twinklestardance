<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pwd-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model, Yii::t('app','Please fix the following input errors:')); ?>
	<div class="row">
	<?php ?>
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'password'); ?>
			
	</div>
	
	<div class="row">
	<?php ?>
			<?php echo $form->labelEx($model,'password_repeat'); ?>
			<?php echo $form->passwordField($model,'password_repeat',array('size'=>40,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'password_repeat'); ?>
			
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app','Change Password')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->