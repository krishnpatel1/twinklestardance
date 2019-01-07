<?php

$this->breadcrumbs = array(
    $model->label(2) => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $model->label(2) . "<span>&nbsp;</span>"),
);
$this->menu = array(
    array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'pages-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        array(
            'name' => 'title',
            'value' => 'CHtml::link($data->title, Yii::app()->createUrl("index/cms",array("id"=>$data->custom_url_key)) , array("target"=>"_blank","title"=>"Click to view this page"))',
            'type' => 'raw',
        ),
        array(
            'name' => 'created_user_id',
            'header' => Yii::t('inx', 'Created By'),
            'value' => 'GxHtml::valueEx($data->createdUser)',
            'filter' => GxHtml::listDataEx(Users::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'status',
            'type' => 'html',
            'filter' => UtilityHtml::getStatusArray(),
            'value' => 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array( "src" => UtilityHtml::getStatusImage(GxHtml::valueEx($data, \'status\')))))',
        ),
        array(
            'template' => '{update}{delete}',
            'class' => 'CButtonColumn',
            'header' => Yii::t('inx', 'Actions'),
        )
    )
));
?>