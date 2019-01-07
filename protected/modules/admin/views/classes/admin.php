<?php
/* @var $this ClassesController */
/* @var $model Classes */

$this->breadcrumbs = array(
    Yii::t('app', 'Classes') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Classes') . "<span>&nbsp;</span>")
);


if (AdminModule::isStudioAdmin()) {
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/classes/list')),        
        array('label' => Yii::t('app', 'Add Class'), 'url' => array('create')),        
    );
}
else{
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/classes/list')),        
    );
}

?>

<h1>Search classes</h1>
<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row row-spaced">
        <?php echo $form->label($model,'name',array('class'=>'inline')); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
    </div>        
    <div class="row row-spaced">
        <?php echo $form->labelEx($model, 'start_date'); ?>
        <b>From:</b>
        <?php
            $form->widget('zii.widgets.jui.CJuiDatePicker', array(
/*            'model' => $model,
            'attribute' => 'start_date',
            'value' => $model->start_date,*/
            'name'=>'from_start_date',
            //'value'=>Yii::app()->request->cookies['from_start_date']->value,
            'value'=>(isset($_GET['from_start_date'])) ? $_GET['from_start_date'] : "",
            //'value'=>'',
            'options' => array(
                'showButtonPanel' => true,
                'changeYear' => true,
                'dateFormat' => 'yy-mm-dd'
            ),
            'htmlOptions' => array(
                'class' => 'price'
            ),
        ));
        ?>
        <b>To:</b>
        <?php
            $form->widget('zii.widgets.jui.CJuiDatePicker', array(
/*            'model' => $model,
            'attribute' => 'start_date',
            'value' => $model->start_date,*/
            'name'=>'to_start_date',
            //'value'=>Yii::app()->request->cookies['to_start_date']->value,
            'value'=>(isset($_GET['to_start_date'])) ? $_GET['to_start_date'] : "",
            //'value'=>'',
            'options' => array(
                'showButtonPanel' => true,
                'changeYear' => true,
                'dateFormat' => 'yy-mm-dd'
            ),
            'htmlOptions' => array(
                'class' => 'price'
            ),
        ));
        ?>
    </div>
    
    <div class="row row-spaced">
        <?php echo $form->labelEx($model, 'end_date'); ?>
        <b>From:</b>
        <?php
            $form->widget('zii.widgets.jui.CJuiDatePicker', array(
/*            'model' => $model,
            'attribute' => 'end_date',
            'value' => $model->end_date,*/
            'name'=>'from_end_date',
            //'value'=>Yii::app()->request->cookies['from_end_date']->value,
            'value'=>(isset($_GET['from_end_date'])) ? $_GET['from_end_date'] : "",
            //'value'=>'',
            'options' => array(
                'showButtonPanel' => true,
                'changeYear' => true,
                'dateFormat' => 'yy-mm-dd'
            ),
            'htmlOptions' => array(
                'class' => 'price'
            ),
        ));
        ?>
        <b>To:</b>
        <?php
            $form->widget('zii.widgets.jui.CJuiDatePicker', array(
/*            'model' => $model,
            'attribute' => 'end_date',
            'value' => $model->end_date,*/
            'name'=>'to_end_date',
            //'value'=>Yii::app()->request->cookies['to_end_date']->value,
            'value'=>(isset($_GET['to_end_date'])) ? $_GET['to_end_date'] : "",
            //'value'=>'',
            'options' => array(
                'showButtonPanel' => true,
                'changeYear' => true,
                'dateFormat' => 'yy-mm-dd'
            ),
            'htmlOptions' => array(
                'class' => 'price'
            ),
        ));
        ?>
    </div>

    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); 

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-classes-form',
    'enableAjaxValidation' => false,
));
if (AdminModule::isStudioAdmin()) {
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'classes-grid',
    //'dataProvider' => $model->search(),
    'dataProvider' => $dataProvider,
    'columns' => array(    
        /*array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'deleteids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),*/		
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
else{
    $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'classes-grid',
    //'dataProvider' => $model->search(),
    'dataProvider' => $dataProvider,
    'columns' => array(    
        /*array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'deleteids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),*/		
		'name',
        'start_date',
        'end_date',
        array(
            'type'=>'raw',
            'value'=>'"<span style=\'text-align:center;display:block;width:100%;\'>".CHtml::link( CHtml::image(Yii::app()->request->baseUrl.\'/images/update.png\'), $this->grid->controller->createUrl("classes/listClassVideos", array("id" => $data->id)) , array(\'class\' => "ajax play", \'onclick\' => \'_gaq.push([\\\'_trackEvent\\\', \\\'Videos\\\', \\\'Play\\\', \\\'\' . $data->title . \'\\\']);\'))."</span>"'
        )
	
	
    )
));
}

/*if (AdminModule::isStudioAdmin()) 
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'genre-delete', 'class' => 'submitbtnclass'));*/
$this->endWidget();
?>

<script type="text/javascript">
    $("#classes-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
</script>