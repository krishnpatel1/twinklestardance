<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs = array(
    "<font>&nbsp;</font>Categories<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Update') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Update')."<span>&nbsp;</span>")
);
?>
<h1>Update Category <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>