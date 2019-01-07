<?php
//$ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block'; 
$ssClass = ((($index + 1) == 2) || (($index + 2) % 3 == 0 && ($index + 1) != 3)) ? 'block last' : 'block';
?>
<div class="<?php echo $ssClass; ?>">
    <?php if ($data->package_subscription_id > 0): ?>
        <div class="fb-share-image">
            <?php echo CHtml::image(Yii::app()->baseUrl . "/images/fb-share.png", '', array('onclick' => 'fb_share("' . $data->name . '","' . UtilityHtml::getAbsoluteImageUrl(GxHtml::encode($data->image_url)) . '","' . Yii::app()->createAbsoluteUrl('site/subscriptions', array('id' => $data->package_subscription_id, 'type' => $data->type)) . '");', 'style' => 'cursor:pointer;height:22px;')); ?>
        </div>
    <?php endif; ?>
    <a href="javascript:void(0);">        
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getImageDisplay(GxHtml::encode($data->image_url))); ?>
        </div>
        <div class="text">
            <?php echo (strlen($data->name) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($data->name, 0, Yii::app()->params['max_length_char_to_dispaly']) . '...' : $data->name; ?>
        </div>
    </a>
    <font class="edit_show" title="<?php echo $data->name . ' - ' . $data->type; ?>">
    <?php
    if ($data->package_subscription_id > 0) {
        $ssLinkParams = ($data->type == "Package") ? array("id" => $data->package_subscription_id, "type" => $data->type, "package_id" => $data->package_subscription_id) : array("id" => $data->package_subscription_id, "type" => $data->type);
        echo CHtml::link('View', CController::createUrl("videos/viewDetails", $ssLinkParams));
    } else {
        echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), 'javascript:void(0);', array('class' => "ajax play", 'onclick' => 'js:openColorBox("' . $data->video->iframe_code . '");'));
    }
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : ''; ?>