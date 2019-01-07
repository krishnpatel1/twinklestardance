<?php
$ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block';
$ssDancerClass = ($data->num % 3 == 0) ? 'block last' : 'block';
$ssClass = ($data->user_type == Yii::app()->params['user_type']['dancer']) ? $ssDancerClass : $ssClass;
?>
<div class="<?php echo $ssClass; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getImageStudio(GxHtml::encode($data->picture)), '', array('width' => '198px', 'height' => '149px')); ?>
        </div>
        <div class="text"><?php echo GxHtml::encode(ucfirst($data->first_name . ' ' . $data->last_name)); ?></div>
    </a>
    <font class="edit_show">

    <?php
    if (AdminModule::isStudioAdmin()):
        echo CHtml::link('Edit', CController::createUrl("users/addEditInstructorsDancers", array("id" => $data->id, "user_type" => $data->user_type)), array('title' => 'Edit Video'));
    //echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/unchecked.png", '', array('width' => '16px', 'height' => '16px')), CController::createUrl("users/delete", array("id" => $data->id)), array("onclick" => "return confirm('Are you sure you want to delete?');"));
    endif;
    ?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : ''; ?>