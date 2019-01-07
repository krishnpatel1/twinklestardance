<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="width_48 fl">
	<div class="row">
		<?php //echo $form->label($model,'id'); ?>
		<?php //echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'user_type'); ?>
		<?php //echo $form->textField($model,'user_type',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>32,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>32,'maxlength'=>30)); ?>
	</div>
    
    <div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>40,'maxlength'=>30)); ?>
	</div>
    <div class="row">
		<?php //echo $form->label($model,'logdate'); ?>
		<?php //echo $form->textField($model,'logdate'); ?>
	</div>

	
</div>
<div class="width_48 fr">
	<div class="row">
		<?php //echo $form->label($model,'lognum'); ?>
		<?php //echo $form->textField($model,'lognum'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'created_at'); ?>
		<?php //echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'updated_at'); ?>
		<?php //echo $form->textField($model,'updated_at'); ?>
	</div>

	

	<div class="row">
		<?php //echo $form->label($model,'status'); ?>
		<?php //echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'extra'); ?>
		<?php //echo $form->textArea($model,'extra',array('rows'=>6, 'cols'=>50,'maxlength'=>150)); ?>
	</div>
</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->