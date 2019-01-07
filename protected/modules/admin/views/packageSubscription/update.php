<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>".$ssType."<span>&nbsp;</span>" => array('class' => 'two', 'url' => Yii::app()->createUrl("admin/packageSubscription/index", array("type" => $ssType))),
    $model->name => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".$model->name."<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model,
    'amResult' => $amResult,
    'amSelected' => $amSelected,
    'buttons' => 'create',
    'ssType' => $ssType,
    'omModelTrans' => $omModelTrans,
    'omDocuments' => $omDocuments
));
?>