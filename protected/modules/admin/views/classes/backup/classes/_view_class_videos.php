<?php $ssClass = ((($data->num) % 3 == 0)) ? 'block last' : 'block'; ?>

<div id="divselectvideo<?php echo $data->video_id; ?>" class="<?php echo $ssClass; ?>">
    <a id="<?php echo $data->video_id; ?>" class="videolink" href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getVideoImage($data->image_url)); ?>           
            <?php if (!isset($data->user_video_id) && AdminModule::isDancer()): ?>
                <div class="purchase"><font>Purchase</font></div>
                <input type="checkbox" id="videoid<?php echo $data->video_id; ?>" name="videoids[]" value="<?php echo $data->video_id; ?>"/>
            <?php endif; ?>
        </div>
        <div class="text">
            <?php echo $data->title; ?>
        </div>        
    </a>
    <font class="<?php echo (isset($data->user_video_id) || AdminModule::isInstructor() ) ? 'edit_show' : ''; ?>">
    <?php
    if ((isset($data->user_video_id) && $data->user_video_id > 0) || AdminModule::isInstructor()):
        //echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), 'javascript:void(0);', array('class' => "ajax play", 'onclick' => 'js:openColorBox("' . $data->iframe_code . '");'));    
        $url = Yii::app()->createUrl('admin/classes/watchVideo', array('iframe_code' => base64_encode($data->iframe_code), 'description' => base64_encode($data->description)));
        echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), $url, array('class' => "ajax play", 'onclick' => '_gaq.push([\'_trackEvent\', \'Videos\', \'Play\', \'' . $data->title . '\']);'));
    endif;
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : ''; ?>

