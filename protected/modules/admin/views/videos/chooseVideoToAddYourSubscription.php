<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
<?php
$ssBreadCrumbParams = (Yii::app()->getRequest()->getParam('package_id')) ? array("id" => $snSubscriptionId, "type" => $ssType, "package_id" => Yii::app()->getRequest()->getParam('package_id')) : array("id" => $snSubscriptionId, "type" => $ssType);
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => CController::createUrl("videos/viewDetails", $ssBreadCrumbParams)),
    Yii::t('app', 'Choose videos') => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Choose videos') . "<span>&nbsp;</span>")
);

$ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snSubscriptionId, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snSubscriptionId, 'type' => $ssType);

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('/user/videos/chooseVideosTable/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"])),        
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        $this->beginWidget('GxActiveForm', array(
            'id' => 'chooes-video-form',
            'enableAjaxValidation' => false
        ));
        echo CHtml::hiddenField("total_available_video", $snTotalAvailableVideo);
        echo GxHtml::submitButton(Yii::t('app', 'Done Adding'), array('id' => 'video-choose','class'=>'submitbtnclass'));
        $ssNewSubscriptionLink = CHtml::link(Yii::t('app','Click here'),  CController::createUrl('/site/subscriptions'),array('target'=>'_blank'));
        echo '<p id="unable_update" class="topmargin" style="color:red;display:none;">'.Yii::t('app', "Unable to add videos, you have no more updates remaing. Please visit $ssNewSubscriptionLink to view our subscriptions").'</p>';
        echo '<p class="topmargin">'.Yii::t('app', 'Choose videos to add your subscription. Selections remaining: <strong>') . $snTotalAvailableVideo.'</strong></p>';        
        echo '<div class="clear"></div>';
        if ($omAdditionalVideos):
            $snI = 0;        
            foreach ($omAdditionalVideos as $omDataSet):
                $ssClass = (($snI == 2) || (($snI + 1) % 3 == 0 && $snI != 3)) ? 'block last' : 'block';
                $ssNewVideoClass = ($omDataSet->additional_status) ? "new_video" : "";
                ?>
                <div id="divselectvideo<?php echo $omDataSet->id; ?>" class="<?php echo $ssClass .' '.$ssNewVideoClass;?>">
                    <a id="<?php echo $omDataSet->id; ?>" class="videolink" href="javascript:void(0);" title="<?php echo $omDataSet->title;?>">
                        <div class="img">
                            <?php echo CHtml::image(UtilityHtml::getVideoImage($omDataSet->image_url)); ?>
                            <input type="checkbox" id="videoid<?php echo $omDataSet->id; ?>" name="videoids[]" value="<?php echo $omDataSet->id; ?>"/>
                        </div>
                        <div class="text">
                            <?php echo (strlen($omDataSet->title) > Yii::app()->params['max_length_char_to_dispaly']) ? substr($omDataSet->title,0,Yii::app()->params['max_length_char_to_dispaly']).'...' : $omDataSet->title;?>
                        </div>
                        <?php echo ($omDataSet->additional_status) ? "<span class='newvideo'></span>" : ""; ?>
                    </a>
                </div>
                <?php
                $snI++;
                echo ($ssClass == "block last") ? '<div class="clear"></div>' : '';
            endforeach;
        endif;
        $this->endWidget();
        ?>
        <div class="clear"></div>
    </div>
</div>
<script>    
    $("#video-choose").click(function(){
        if ($('input:checkbox:checked').length > 0) {
            return true;
        }else{
            history.go(-1);
            return false;
        }
    });
    $(".videolink").click(function() {
        var snCheckBoxLength = $('input:checkbox:checked').length + 1;
        var snTotalAvailableVideo = <?php echo $snTotalAvailableVideo; ?>;
        if(snCheckBoxLength > snTotalAvailableVideo && !$("#divselectvideo"+this.id).hasClass("add_block")){
            //alert("You can't allow to add videos to your subscription more than your limit.");
            $("#unable_update").show();
            return false;
        }else{
            $("#unable_update").hide();
        }
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