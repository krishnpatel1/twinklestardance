<?php $data['class'] = ((($index) == 2) || (($index + 1) % 3 == 0 && ($index) != 3)) ? 'block last' : 'block'; ?>

<div id="divselectvideo<?php echo $data['id'] ?>" class="<?php echo $data['class']; ?>">
    <a id="<?php echo $data['id'] ?>" class="videolink" href="javascript:void(0);">
        <div class="img">
            <?php echo CHtml::image(UtilityHtml::getVideoImage($data['image_url'])); ?>
            <input type="checkbox" id="videoid<?php echo $data['id']; ?>" name="videoids[]" value="<?php echo $data['id']; ?>"/>
        </div>
        <div class="text">
            <?php echo $data['title']; ?>
        </div>
    </a>
</div>                
<?php
// Phase-II: Added to set listing box design //
echo ($data['class'] == 'block last') ? '<div class="clear"></div>' : '';
 
?>