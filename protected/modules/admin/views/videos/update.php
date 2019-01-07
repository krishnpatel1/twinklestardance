<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $model->title => array('class' => 'active two display', 'label' => "<font>&nbsp;</font>" . $model->title . "<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model,
    'amResult' => $amResult,
    'amSelected' => $amSelected,
    'omModelTrans' => $omModelTrans
));
?>