<head>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
</head>

<?php
/* @var $this ClassesController */
/* @var $model Classes */

$_SESSION['display_subscription'] = 0;

$this->breadcrumbs = array(
    Yii::t('app', 'Classes Report') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Classes Report') . "<span>&nbsp;</span>")
);
?>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <?php if(!isset($_GET['colorbox'])) : ?>
    <div class="row row-spaced">
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'placeholder' => "Search classes")); ?>
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>  
    <?php endif; ?>      

<?php $this->endWidget(); 

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-classes-form',
    'enableAjaxValidation' => false,
));

if (AdminModule::isStudioAdmin()) 
{?>
   <?php if(isset($_GET['colorbox'])) : ?>
    <h4>Note : One or more classes are set to expire soon. Please review your class expiration dates.</h4>
   <?php endif; ?>     
   <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'classes-grid',
        //'dataProvider' => $model->search(),
        'dataProvider' => $dataProvider,
        'columns' => array(         
            'name',
            'start_date',
            'end_date',
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}',
                'header' => Yii::t('inx', 'Actions')
            )
        )
    ));
}

$this->endWidget();
?>

 <script type="text/javascript">
    $(document).ready(function()
    {
        $('a').attr('target', '_blank');
    });
</script> 