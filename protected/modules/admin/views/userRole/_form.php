<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-role-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model, 'parent_id', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'parent_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'tree_level'); ?>
		<?php echo $form->textField($model, 'tree_level'); ?>
		<?php echo $form->error($model,'tree_level'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
		<?php echo $form->error($model,'sort_order'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'role_type'); ?>
		<?php echo $form->textField($model, 'role_type', array('maxlength' => 6)); ?>
		<?php echo $form->error($model,'role_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'role_name'); ?>
		<?php echo $form->textField($model, 'role_name', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'role_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'role_desc'); ?>
		<?php echo $form->textArea($model, 'role_desc'); ?>
		<?php echo $form->error($model,'role_desc'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'is_publish'); ?>
		<?php echo $form->checkBox($model, 'is_publish'); ?>
		<?php echo $form->error($model,'is_publish'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('userRules')); ?></label>
		<?php echo $form->checkBoxList($model, 'userRules', GxHtml::encodeEx(GxHtml::listDataEx(UserRules::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->