<?php $ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block'; ?>
<div class="<?php echo $ssClass; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image($data->image_url); ?>
        </div>
        <div class="text"><?php echo (strlen($data->title) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($data->title, 0, Yii::app()->params['max_length_char_to_dispaly']) . '...' : $data->title; ?></div>
    </a>
    <font class="edit_show" title="<?php echo $data->title; ?>">
    <?php
    echo CHtml::link('Edit', CController::createUrl("videos/update", array("id" => $data->id)));
    //added below two lines to view video in admin    
    //$url = Yii::app()->createUrl('admin/videos/watchVideo', array('iframe_code' => base64_encode($data->iframe_code)));    
    //echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), $url, array('class' => "ajax play"));


    //echo '<br>'.CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/unchecked.png", '', array('width' => '16px', 'height' => '16px')), CController::createUrl("videos/delete", array("id" => $data->id)), array("onclick" => "return confirm('Are you sure you want to delete?');"));
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : ''; ?>
