<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testimonial-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'institution'); ?>
		<?php echo $form->textField($model,'institution',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'institution'); ?>
	</div>        
    
    <div class="info2 fckwidth">
        <h6><?php echo $form->labelEx($model, 'text'); ?>:</h6>
        <?php
        /*$this->widget('application.extensions.fckeditor.FCKEditorWidget', array(
            "model" => $model,
            "attribute" => 'text',
             "toolbarSet"=>'Basic',
            "fckeditor" => Yii::app()->basePath . "/../fckeditor/fckeditor.php",
            "fckBasePath" => Yii::app()->baseUrl . "/fckeditor/"
        ));*/?>
        <pre>
        <?php
        echo $form->textArea($model,'text',array('rows' => 15, 'cols' => 105));
        ?>
        </pre>
        <?php echo $form->error($model, 'text'); ?>
    </div>               

    <div class="row" style="display:none">
		<?php echo $form->labelEx($model,'sysposition'); ?>
		<!--?php echo $form->textField($model,'sysposition',array('size'=>60,'maxlength'=>250)); -->
        <?php         
        $syspos = $model->sysposition;
        if($syspos==null){
            $criteria=new CDbCriteria;        
            $criteria->select='max(sysposition) AS sysposition';
            $row = $model->model()->find($criteria);
            $syspos = $row['sysposition']+1;
        }
        
        echo $form->textField($model,'sysposition',array('size'=>50,'maxlength'=>250,'value'=>$syspos)); ?>
  
		<?php echo $form->error($model,'sysposition'); ?>
	</div>


    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->