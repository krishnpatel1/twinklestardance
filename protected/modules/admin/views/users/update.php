<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Yii::t('app', 'Studios') . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $model->studio_name => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $model->studio_name . "<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model,
    'amStates' => $amStates
));
?>