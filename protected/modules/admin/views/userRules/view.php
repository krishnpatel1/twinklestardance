<?php
$this->breadcrumbs=array(
	'User Rules'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserRules', 'url'=>array('index')),
	array('label'=>'Create UserRules', 'url'=>array('create')),
	array('label'=>'Update UserRules', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserRules', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserRules', 'url'=>array('admin')),
);
?>

<h1>View UserRules #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'role_id',
		'module_id',
		'role_desc',
		'privileges_controller',
		'privileges_actions',
		'permission',
		'permission_type',
	),
)); ?>
