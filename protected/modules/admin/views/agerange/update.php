<?php
/* @var $this AgeRangeController */
/* @var $model AgeRange */

$this->breadcrumbs = array(
    "<font>&nbsp;</font>Age Ranges<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Update') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Update')."<span>&nbsp;</span>")
);
?>
<h1>Update Age range <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>