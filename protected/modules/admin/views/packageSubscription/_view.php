<?php $ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block'; ?>
<div class="<?php echo $ssClass; ?>">
    <?php
    $ssLinkName = '<div class="img">' . CHtml::image(UtilityHtml::getImageDisplay(GxHtml::encode($data->image_url)), '', array('width' => '198', 'height' => '149')) . '</div>';
    $ssName = (strlen($data->name) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($data->name,0,Yii::app()->params['max_length_char_to_dispaly']).'...' : $data->name;
    $ssLinkName .= '<div class="text">' . $ssName . '</div>';

    echo CHtml::link($ssLinkName, 'javascript:void(0);');
    ?>
    <font class="edit_show" title="<?php echo $data->name;?>">
    <?php
    echo CHtml::link('Edit', CController::createUrl("packageSubscription/update", array("id" => $data->id, "type" => $data->type)), array('title' => 'Edit ' . $data->type));
    //echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/unchecked.png", '', array('width' => '16px', 'height' => '16px')), CController::createUrl("packageSubscription/delete", array("id" => $data->id, "type" => $data->type)), array("onclick" => "return confirm('Are you sure you want to delete?');"));
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : '';?>