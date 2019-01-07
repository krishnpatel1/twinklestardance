<?php
/* @var $this AgeRangeController */
/* @var $model AgeRange */

$this->breadcrumbs = array(
    "<font>&nbsp;</font>Age ranges<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Create') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Create')."<span>&nbsp;</span>")
);

?>

<h1>Create Age range</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>