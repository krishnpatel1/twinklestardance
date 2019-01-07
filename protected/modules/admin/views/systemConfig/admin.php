<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Manage Configurations') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Manage Configurations') . "<span>&nbsp;</span>"),
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'system-config-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'header' => Yii::t("messages", 'Id'),
            'value' => 'GxHtml::valueEx($data, \'id\')',
        ),
        array(
            'name' => 'system_section_id',
            'header' => Yii::t("messages", 'System Section'),
            'value' => 'GxHtml::valueEx($data, \'systemSection\')',
            'filter' => GxHtml::listDataEx(SystemSection::model()->findAllAttributes(null, true, 'status=1')),
        ),
        array(
            'name' => 'system_group_id',
            'header' => Yii::t("messages", 'System Group'),
            'value' => 'GxHtml::valueEx($data, \'systemGroup\')',
            'filter' => GxHtml::listDataEx(SystemGroup::model()->findAllAttributes(null, true, 'status=1')),
        ),
        array(
            'name' => 'name',
            'header' => Yii::t("messages", 'Name'),
            'value' => 'GxHtml::valueEx($data, \'name\')',
        ),
        array(
            'name' => 'value',
            'header' => Yii::t("messages", 'Value'),
            'value' => 'GxHtml::valueEx($data, \'value\')',
        ),
        array(
            'name' => 'status',
            'type' => 'html',
            'filter' => UtilityHtml::getStatusArray(),
            'value' => 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array( "src" => UtilityHtml::getStatusImage(GxHtml::valueEx($data, \'status\')))))',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
));
?>