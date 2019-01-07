<?php
/* @var $this AgeRangeController */
/* @var $model AgeRange */

$this->breadcrumbs = array(
    Yii::t('app', 'Age ranges') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Age ranges') . "<span>&nbsp;</span>")
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create Age range'), 'url' => array('create')),
);

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-agerange-form',
    'enableAjaxValidation' => false,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'agerange-grid',
    'dataProvider' => $model->search(),
    'columns' => array(    
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'deleteids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),
		'id',
		'range',
		array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('inx', 'Actions')
        )
	
    )
));

if (AdminModule::isAdmin())
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'agerange-delete', 'class' => 'submitbtnclass'));
$this->endWidget();
?>

<script type="text/javascript">
    $("#agerange-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
</script>