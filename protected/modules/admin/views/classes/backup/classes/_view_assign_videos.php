<?php 
//$ssClass = (($data->num == 2) || (($data->num + 1) % 3 == 0 && $data->num != 3)) ? 'block last' : 'block'; 
$ssClass = ((($index+1) == 2) || (($index + 2) % 3 == 0 && ($index+1) != 3)) ? 'block last' : 'block';
?>
<div class="<?php echo $ssClass; ?>">
    <a href="javascript:void(0);">
        <div class="img">
            <?php echo UtilityHtml::getVideoImage($data->image_url); ?>
            <input type="checkbox" id="videoid<?php echo $data->num;?>" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '0') ? 'checked="checked"' : ''; ?> value="0"/>
        </div>
        <div class="text">
            <?php echo $data->title; ?>
        </div>
    </a>
    <font class="edit_show">
        <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/icon/play_i.png'), 'javascript:void(0);', array('class' => "ajax", 'onclick' => 'js:openColorBox("' . $data->iframe_code . '");'));?>
    </font>
</div>
<?php echo ($ssClass == "block last") ? '<div class="clear"></div>' : '';?>