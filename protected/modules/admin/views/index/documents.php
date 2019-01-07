<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Documents') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Documents') . "<span>&nbsp;</span>")
);
$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-documents-form',
    'enableAjaxValidation' => false,
));
?>
<div class = "flash_message">
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
</div> 
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'documents-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '++$row',
            'htmlOptions' => array('style' => 'text-align:center;d')
        ),
        array(
            'name' => 'document_title',
            'value' => '$data->document_title',
            'headerHtmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::link("Download",Yii::app()->createUrl("admin/index/downloadDoc",array("file"=>"$data->document_name","psid"=>"$data->package_sub_id")))',
            'htmlOptions' => array('style' => 'text-align:center;')
        )
    )
));

$this->endWidget();
