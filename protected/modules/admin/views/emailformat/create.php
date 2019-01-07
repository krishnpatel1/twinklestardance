<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>".$model->label(2)."<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Create') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Create')."<span>&nbsp;</span>")
);
?>

<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php
$this->renderPartial('_form', array(
    'model' => $model,
    'buttons' => 'create'));
?>