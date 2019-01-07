<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('paypal_url')); ?>:
	<?php echo GxHtml::encode($data->paypal_url); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('paypal_partner')); ?>:
	<?php echo GxHtml::encode($data->paypal_partner); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('paypal_merchant_login')); ?>:
	<?php echo GxHtml::encode($data->paypal_merchant_login); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('paypal_password')); ?>:
	<?php echo GxHtml::encode($data->paypal_password); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('paypal_payment_mode')); ?>:
	<?php echo GxHtml::encode($data->paypal_payment_mode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('facebook_appid')); ?>:
	<?php echo GxHtml::encode($data->facebook_appid); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('facebook_secret')); ?>:
	<?php echo GxHtml::encode($data->facebook_secret); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_updated_at')); ?>:
	<?php echo GxHtml::encode($data->last_updated_at); ?>
	<br />
	*/ ?>

</div>