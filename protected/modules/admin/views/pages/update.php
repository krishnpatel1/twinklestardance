<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>".$model->label(2)."<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    $model->title => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".$model->title."<span>&nbsp;</span>")
);
$this->menu = array(
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
$this->renderPartial('_form', array(
    'model' => $model));
?>