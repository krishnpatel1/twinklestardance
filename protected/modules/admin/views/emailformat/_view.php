<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
	<?php echo GxHtml::encode($data->title); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('subject')); ?>:
	<?php echo GxHtml::encode($data->subject); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('body')); ?>:
	<?php echo GxHtml::encode($data->body); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('file_name')); ?>:
	<?php echo GxHtml::encode($data->file_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_updated')); ?>:
	<?php echo GxHtml::encode($data->last_updated); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />

</div>