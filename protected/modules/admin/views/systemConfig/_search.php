<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>
<div class="width_48 fl">
	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'system_section_id'); ?>
		<?php echo $form->dropDownList($model, 'system_section_id', GxHtml::listDataEx(SystemSection::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'system_group_id'); ?>
		<?php echo $form->dropDownList($model, 'system_group_id', GxHtml::listDataEx(SystemGroup::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>
</div>

<div class="width_48 fr">
	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
	</div>
<?php /*
	<div class="row">
		<?php echo $form->label($model, 'value'); ?>
		<?php echo $form->textArea($model, 'value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'input_type'); ?>
		<?php echo $form->textArea($model, 'input_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'input_options'); ?>
		<?php echo $form->textArea($model, 'input_options'); ?>
	</div>
*/?>
	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'InActive'), '1' => Yii::t('app', 'Active')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'position'); ?>
		<?php echo $form->textField($model, 'position'); ?>
	</div>
</div>
	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
