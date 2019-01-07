<?php
$this->breadcrumbs=array(
	'User Rules'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserRules', 'url'=>array('index')),
	array('label'=>'Create UserRules', 'url'=>array('create')),
	array('label'=>'View UserRules', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserRules', 'url'=>array('admin')),
);
?>

<h1>Update UserRules <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>