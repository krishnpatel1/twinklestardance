<?php
$this->breadcrumbs=array(
	'User Rules',
);

$this->menu=array(
	array('label'=>'Create UserRules', 'url'=>array('create')),
	array('label'=>'Manage UserRules', 'url'=>array('admin')),
);
?>

<h1>User Rules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
