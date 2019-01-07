<?php
$this->breadcrumbs=array(
	'User Rules'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserRules', 'url'=>array('index')),
	array('label'=>'Manage UserRules', 'url'=>array('admin')),
);
?>

<h1>Create UserRules</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>