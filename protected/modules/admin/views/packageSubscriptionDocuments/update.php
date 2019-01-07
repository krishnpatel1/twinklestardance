<?php

$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Yii::t('app', 'Documents') . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Edit Document') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Edit Document') . "<span>&nbsp;</span>")
);
$this->renderPartial('_form', array(
    'model' => $model,
    'omModelTrans' => $omDocuments,
));
?>