<?php
$this->breadcrumbs=array(
	'User',
);

$this->menu=array(
	array('label'=>'Create Web User', 'url'=>array('create')),
	array('label'=>'Manage Web Users', 'url'=>array('admin')),
);
?>
<div class="main-content"> 
<h1>Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
