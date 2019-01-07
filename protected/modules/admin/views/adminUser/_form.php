
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
	
	<?php
	 
	
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <ul class="filed_list">

    <li>
   	  	<?php echo $form->labelEx($model,'user_type'); ?>
	   <?php if(Yii::app()->admin->getId() == $model->id){
		   	echo $model->user_type; 
	    }else{
			echo $form->dropDownlist($model,'user_type',AdminUser::getDefinedUserType(),array('readonly'=>'true','disabled'=>false,)); 
	     }?>
	    <?php echo $form->error($model,'user_type'); ?>
	</li>
	<li>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php if($this->getAction()->id == 'create'): ?>
			<?php echo $form->textField($model,'username',array('size'=>40,'maxlength'=>30)); ?>
		<?php else: ?>
			<?php echo $model->username; ?>
		<?php endif;?>
		<?php echo $form->error($model,'username'); ?>
	</li>
	<?php if($this->getAction()->id == 'create'):?>
		<li>
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>150,'value'=>'')); ?>
			<?php echo $form->error($model,'password'); ?>
		</li>	
	<?php endif;?>
	<li>
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>32,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</li>
	<li>
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>32,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</li>
	<li>
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'email'); ?>
	</li>
<?php /*
	<div class="row">
		<?php //echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->hiddenField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->hiddenField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'logdate'); ?>
		<?php echo $form->hiddenField($model,'logdate'); ?>
		<?php //echo $form->textField($model,'logdate'); ?>
		<?php echo $form->error($model,'logdate'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'lognum'); ?>
		<?php echo $form->hiddenField($model,'lognum',array('value'=>1)); ?>
		<?php //echo $form->textField($model,'lognum'); ?>
		<?php echo $form->error($model,'lognum'); ?>
	</div>
*/?>



	<li>
	   <?php echo $form->labelEx($model,'is_active'); ?>
		 <?php if(Yii::app()->admin->getId() == $model->id): ?>
			<?php echo UtilityHtml::getStatusImageIcon($model->is_active); ?>
		<?php else: ?>
			<?php echo $form->dropDownlist($model,'is_active', array('1'=>'Active','0'=>'InActive')); ?>
		<?php endif;?>
		<?php echo $form->error($model,'is_active'); ?>
	</li>

<?php /*	
	<li >
    <?php if($this->getAction()->id == 'create'): ?>
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->dropDownList($model,'is_active', array('1'=>'Active','0'=>'InActive')); ?>
		<?php else: ?>
			<label for="User_username">Status </label>
			<?php echo $model->is_active; ?>
		<?php endif;?>
		<?php echo $form->error($model,'user_type'); ?>
	</li>
*/?>		
	
	

	<li class="full_width">
		<?php echo $form->labelEx($model,'extra'); ?>
		<?php echo $form->textArea($model,'extra',array('rows'=>6, 'cols'=>50,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'extra'); ?>
	</li>
<li>
<?php echo $form->labelEx($model,'&nbsp;'); ?>	
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
<?php $this->endWidget(); ?>
</li>
</ul>

</div><!-- form -->