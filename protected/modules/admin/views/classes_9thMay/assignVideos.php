<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Add ') . Videos::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Add ') . Videos::label(2) . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        $this->beginWidget('GxActiveForm', array(
            'id' => 'assign-video-form',
            'enableAjaxValidation' => false
        ));
        echo GxHtml::submitButton(Yii::t('app', 'Done Adding'), array('id' => 'video-add', 'class' => 'submitbtnclass'));
        echo '<div class="clear"></div>';
        if (count($amVideos) > 0):
            $snI = 1;
            foreach ($amVideos as $snVideoId => $amResultSet):
                $ssClass = ($snI%3 == 0) ? 'block last' : 'block';
                $ssClass .= in_array($snVideoId, $amClassVideos) ? ' add_block' : '';
                ?>
                <div id="divselectvideo<?php echo $snVideoId ?>" class="<?php echo $ssClass; ?>">
                    <a id="<?php echo $snVideoId ?>" class="videolink" href="javascript:void(0);">
                        <div class="img">
                            <?php echo CHtml::image(UtilityHtml::getVideoImage($amResultSet['image_url'])); ?>
                            <input type="checkbox" id="videoid<?php echo $snVideoId; ?>" name="videoids[]" value="<?php echo $snVideoId; ?>" <?php echo in_array($snVideoId, $amClassVideos) ? 'checked="checked"' : ''; ?>/>
                        </div>
                        <div class="text">
                            <?php echo $amResultSet['title']; ?>
                        </div>
                    </a>
                </div>
                <?php
                $snI++;
            endforeach;
        endif;
        $this->endWidget();
        ?>
        <div class="clear"></div>
    </div>
</div>
<script>    
    $("#video-add").click(function(){
        if ($('input:checkbox:checked').length > 0) { 
            return true;
        }else{
            history.go(-1);
            return false;
        }
    });
    $(".videolink").click(function() {
        if (!$("#divselectvideo"+this.id).hasClass("add_block")) {
            $("#divselectvideo"+this.id).addClass("add_block");
            $("#videoid"+this.id).attr('checked','checked');
        }
        else{
            $("#divselectvideo"+this.id).removeClass("add_block");
            $("#videoid"+this.id).attr('checked', false);
        }
    });
</script>