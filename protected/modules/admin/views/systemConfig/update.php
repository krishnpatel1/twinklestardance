<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Yii::t('app', 'Manage Configurations') . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    $model->name => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $model->name . "<span>&nbsp;</span>")
);
$this->menu = array(
    array('label' => Yii::t('app', 'Manage Configurations'), 'url' => array('admin')),
);
$this->renderPartial('_form', array(
    'model' => $model));
?>