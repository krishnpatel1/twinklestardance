<?php
/* @var $this GenreController */
/* @var $model Genre */
error_reporting(E_ALL); 
ini_set("display_errors", 1); 

$this->breadcrumbs = array(
    "<font>&nbsp;</font>Genre<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Create') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Create')."<span>&nbsp;</span>")
);

?>

<h1>Create Genre</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>