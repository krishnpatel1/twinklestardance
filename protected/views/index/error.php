<div id="col2-layout" class="content_div">
	<div class="content">
	<?php $this->renderPartial('left_cms')?>
		<div class="right-sidebar">
			<div class="gray_box_content">
			<?php if(isset($message)) echo CHtml::encode($message); else echo Yii::t('inx', 'Page not found!')?>
			</div>
		</div>
	</div>
</div>