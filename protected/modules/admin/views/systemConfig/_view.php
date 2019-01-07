<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('system_section_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->systemSection)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('system_group_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->systemGroup)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('value')); ?>:
	<?php echo GxHtml::encode($data->value); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('input_type')); ?>:
	<?php echo GxHtml::encode($data->input_type); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('input_options')); ?>:
	<?php echo GxHtml::encode($data->input_options); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('position')); ?>:
	<?php echo GxHtml::encode($data->position); ?>
	<br />
	*/ ?>

</div>