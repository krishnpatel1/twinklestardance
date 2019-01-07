<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . $model->label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    Yii::t('app', 'Create') => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Create') . "<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model,
    'buttons' => 'create'));
?>