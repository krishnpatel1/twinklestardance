<?php $ssClass = ((($index + 1) == 2) || (($index + 2) % 3 == 0 && ($index + 1) != 3)) ? 'block last' : 'block'; ?>
<div class="<?php echo $ssClass; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php
            $ssBaseUrl = isset($data->type) ? UtilityHtml::getImageDisplay(GxHtml::encode($data->image_url)) : $data->image_url;
            echo CHtml::image($ssBaseUrl);
            ?>
        </div>
        <div class="text">
            <?php
            $ssBaseName = isset($data->type) ? $data->name : $data->title;
            $ssType = isset($data->type) ? $data->type : '';
            echo (strlen($ssBaseName) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($ssBaseName, 0, Yii::app()->params['max_length_char_to_dispaly']) . '...' : $ssBaseName;
            ?>
        </div>
    </a>
    <font class="edit_show" title="<?php echo $ssBaseName; ?>">
    <?php
    if (isset($data->type)) {
        echo CHtml::link('View', CController::createUrl("videos/viewDetails", array("id" => $data->id, "type" => $data->type, 'package_id' => Yii::app()->getRequest()->getParam('id'))));
    } else {
        $url = Yii::app()->createUrl('admin/videos/watchVideo', array('iframe_code' => base64_encode($data->iframe_code), 'description' => base64_encode($data->description)));
        echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), $url, array('class' => "ajax play", 'onclick' => '_gaq.push([\'_trackEvent\', \'Videos\', \'Play\', \'' . addslashes($data->title) . '\']); js:publisOnFb("' . Yii::app()->createAbsoluteUrl('/site/watchVideoPublisFb', array('id' => '93')) . '");'));
    }
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : ''; ?>