<?php
$this->breadcrumbs = array(        
    Yii::t('app', 'Update PayPal / Facebook Settings') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Manage PayPal / Facebook Settings') . "<span>&nbsp;</span>")
);
/*
  $this->menu = array(
  array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
  array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
  array('label' => Yii::t('app', 'View') . ' ' . $model->label(), 'url' => array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
  array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
  ); */

$this->renderPartial('_form', array(
    'model' => $model));
?>