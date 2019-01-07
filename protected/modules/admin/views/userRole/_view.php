<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('parent_id')); ?>:
	<?php echo GxHtml::encode($data->parent_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('tree_level')); ?>:
	<?php echo GxHtml::encode($data->tree_level); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('sort_order')); ?>:
	<?php echo GxHtml::encode($data->sort_order); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('role_type')); ?>:
	<?php echo GxHtml::encode($data->role_type); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('role_name')); ?>:
	<?php echo GxHtml::encode($data->role_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('role_desc')); ?>:
	<?php echo GxHtml::encode($data->role_desc); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('is_publish')); ?>:
	<?php echo GxHtml::encode($data->is_publish); ?>
	<br />
	*/ ?>

</div>