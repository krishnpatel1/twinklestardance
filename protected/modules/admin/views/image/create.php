<?php
/* @var $this CategoryController */
/* @var $model Category */
error_reporting(E_ALL); 
ini_set("display_errors", 1); 

$this->breadcrumbs = array(
    "<font>&nbsp;</font>Categories<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Create') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Create')."<span>&nbsp;</span>")
);

?>

<h1>Create Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>