<div class="left-sidebar" id="left_link">
	<ul>
	<?php
	$criteria = new CDbCriteria();
	$criteria->order = 'pos';
	$criteria->select = 't.id, t.title, t.custom_url_key';
	$criteria->addCondition('status=1');
	$footer = Pages::model()->findAll($criteria);
	$i=0;
	?>
	<?php foreach ($footer as $row) :?>
		<li><?php //echo Chtml::link(Yii::t('inx', $row->title), Yii::app()->baseUrl.'/'.$row->custom_url_key.'.html')?>
		<?php echo CHtml::link(Yii::t('inx', $row->title), CController::createUrl('index/cms/', array('id'=>$row->custom_url_key)))?>
		<?php if($i<count($footer)-1):?> <?php $i++;?> <?php endif;?></li>
		<?php endforeach;?>
	</ul>
</div>
