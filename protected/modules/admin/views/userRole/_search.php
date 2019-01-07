<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'parent_id'); ?>
		<?php echo $form->textField($model, 'parent_id', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tree_level'); ?>
		<?php echo $form->textField($model, 'tree_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'role_type'); ?>
		<?php echo $form->textField($model, 'role_type', array('maxlength' => 6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'role_name'); ?>
		<?php echo $form->textField($model, 'role_name', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'role_desc'); ?>
		<?php echo $form->textArea($model, 'role_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'is_publish'); ?>
		<?php echo $form->dropDownList($model, 'is_publish', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
