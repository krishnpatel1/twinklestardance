<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>".$model->label(2)."<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    $model->subject => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".$model->subject."<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model));
?>