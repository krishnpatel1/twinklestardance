<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . $model->label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $model->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $model->name . "<span>&nbsp;</span>")
);

$this->renderPartial('_form', array(
    'model' => $model,
    'amResult' => $amResult,
    'amSelected' => $amSelected,
    'omModelTrans' => $omModelTrans,
    'omClassVideos' => $omClassVideos,
    'omDocuments' => $omDocuments
));
?>