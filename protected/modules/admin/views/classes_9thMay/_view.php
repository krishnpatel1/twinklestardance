<?php 
$ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block';
$ssInstDancerClass = ((($data->num) % 3 == 0)) ? 'block last' : 'block';
$ssClass = (AdminModule::isDancer() || AdminModule::isInstructor()) ? $ssInstDancerClass : $ssClass;
?>
<div class="<?php echo $ssClass; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getClassImageDisplay(Yii::app()->admin->id, GxHtml::encode($data->image_url))); ?>
        </div>
        <div class="text"><?php echo GxHtml::encode($data->name); ?></div>
    </a>
    <font class="edit_show">
    <?php
    if (AdminModule::isStudioAdmin()) :
        echo CHtml::link('Edit', CController::createUrl("classes/update", array("id" => $data->id)));
    //echo '<br>'.CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/unchecked.png", '', array('width' => '16px', 'height' => '16px')), CController::createUrl("videos/delete", array("id" => $data->id)), array("onclick" => "return confirm('Are you sure you want to delete?');"));
    else:
        echo CHtml::link('Videos', CController::createUrl("classes/listClassVideos", array("id" => $data->id)));
    endif;
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : '';?>