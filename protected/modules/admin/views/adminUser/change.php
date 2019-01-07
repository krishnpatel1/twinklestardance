<?php
$this->breadcrumbs=array(
	'User'=>array('admin'),
	'Change Password',
);

/*if(Yii::app()->admin->id==$model->id) {
	$this->menu=array(
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
	array('label'=>'Change Password', 'url'=>array('change', 'id'=>$model->id)),
	);

}else {

	$this->menu=array(
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
	array('label'=>'Change Password', 'url'=>array('change', 'id'=>$model->id)),
	);
}*/
?>

<h1>Change Password</h1>

<?php echo $this->renderPartial('_change', array('model'=>$model)); ?>