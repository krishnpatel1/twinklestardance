<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_id')); ?>:</b>
	<?php echo CHtml::encode($data->module_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_desc')); ?>:</b>
	<?php echo CHtml::encode($data->role_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('privileges_controller')); ?>:</b>
	<?php echo CHtml::encode($data->privileges_controller); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('privileges_actions')); ?>:</b>
	<?php echo CHtml::encode($data->privileges_actions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permission')); ?>:</b>
	<?php echo CHtml::encode($data->permission); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('permission_type')); ?>:</b>
	<?php echo CHtml::encode($data->permission_type); ?>
	<br />

	*/ ?>

</div>