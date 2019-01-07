<?php
	$this->breadcrumbs=array(
		'User'=>array('admin'),
		$model->username,
	);
	if(Yii::app()->admin->id==$model->id) {
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
	}
?>

<h1>View User <?php //echo $model->id; ?></h1>
<?php /*?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_type',
		'firstname',
		'lastname',
		'email',
		'username',
		//'password',
		//'created_at',
		//'updated_at',
		//'logdate',
		//'lognum',
		array(
			'name' => 'is_active',
			'type' => 'raw',
			'value' => ($model->is_active == "1" ? "Active": "InActive")
			
			),
		'extra',
	),
)); ?>
*/?>
<div class="default_width accident_details">
    <div style="width:80%;float: left;">
		<div class="row">
			<label class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">User Type</label>
			<label class="label_value_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->user_type;?></label>
		</div>
    </div>
    <div style="width:30%;float: left;">
		<div class="row">
			<label  class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">First Name</label>
			<label  class="label_value_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->firstname;?></label>
		</div>
    </div>
    <div style="width:35%;float: left;">
		<div class="row">
			<label  class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">Last Name</label>
			<label  class="label_value_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->lastname;?></label>
		</div>
    </div>
    <div style="width:35%;float: left;">
		<div class="row">
			<label class="label_title_db_n" style="font-family: Verdana,Arial,sans-serif; color: #222222;">Email</label>
			<label class="label_value_db_e" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->email;?></label>
		</div>
    </div>
    <div style="width:70%;float: left;">
		<div class="row">
			<label  class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">User Name</label>
			<label  class="label_value_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->username;?></label>
		</div>
    </div>
     <div style="width:70%;float: left;">
		<div class="row">
			<label  class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">Is Active</label>
			<label  class="label_value_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->is_active == "1" ? "Yes": "No"?></label>
		</div>
    </div>
     <div style="width:70%;float: left;">
		<div class="row">
			<label  class="label_title_db" style="font-family: Verdana,Arial,sans-serif; color: #222222;">Extra</label>
			<label  class="label_value_db_n" style="font-family: Verdana,Arial,sans-serif; color: #222222;">&nbsp;<?php echo $model->extra;?></label>
		</div>
    </div>
</div>