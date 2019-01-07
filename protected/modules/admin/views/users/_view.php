<?php $class = ( ($data->num) % 3 == 0 ) ? 'block last' : 'block'; ?>
<div class="<?php echo $class; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getImageStudio(GxHtml::encode($data->picture)), '', array('width' => '198px', 'height' => '149px')); ?>
        </div>
        <div class="text"><?php echo (strlen($data->studio_name) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($data->studio_name,0,Yii::app()->params['max_length_char_to_dispaly']).'...' : $data->studio_name ; ?></div>
    </a>
    <font class="edit_show" title="<?php echo $data->studio_name;?>">
    <?php
    echo CHtml::link('Edit', CController::createUrl("users/update", array("id" => $data->id)), array('title' => 'Edit Video'));
    //echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/unchecked.png", '', array('width' => '16px', 'height' => '16px')), CController::createUrl("users/delete", array("id" => $data->id)), array("onclick" => "return confirm('Are you sure you want to delete?');"));
    ?>
    </font>
</div>
<?php echo ($class == "block last") ? '<div class="clear"></div>' : ''; ?>