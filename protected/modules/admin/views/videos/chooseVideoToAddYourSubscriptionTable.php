<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
<?php
$ssBreadCrumbParams = (Yii::app()->getRequest()->getParam('package_id')) ? array("id" => $snSubscriptionId, "type" => $ssType, "package_id" => Yii::app()->getRequest()->getParam('package_id')) : array("id" => $snSubscriptionId, "type" => $ssType);
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => CController::createUrl("videos/viewDetails", $ssBreadCrumbParams)),
    Yii::t('app', 'Choose videos') => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Choose videos') . "<span>&nbsp;</span>")
);

$vid_arr=Yii::app()->getRequest()->getParam('Videos');
$ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snSubscriptionId, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snSubscriptionId, 'type' => $ssType);

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/videos/chooseVideos/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"])),        
);
?>
<div class="middle">
    <div class="fix videos">
        
        <h1>Search videos</h1>
<?php
        $model = new Videos('search');
        
        //$model = new Videos('search');
$form=$this->beginWidget('CActiveForm', array(
    'action'=>'/user/videos/chooseVideosTable/'.$ssLinkParams["id"].'/'.$ssLinkParams["type"],
    //'action'=>'/user/videos/chooseVideosTable/',
    'method'=>'get',
)); ?>

    <div class="row row-spaced">
        <?php echo $form->label($model,'title',array('class'=>'inline')); ?>
        <?php echo CHtml::textField('Videos[title]', $vid_arr['title'], array('id'=>'video_title', 'maxlength'=>255)); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'genre',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[genre]',$vid_arr['genre'], CHtml::listData(Genre::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'category',array('class'=>'inline')); ?>
        <?php echo CHtml::dropDownList('Videos[category]',$vid_arr['category'], CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>        
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'age_range',array('class'=>'inline')); ?>        
        <?php echo CHtml::dropDownList('Videos[age]',$vid_arr['age'], CHtml::listData(Agerange::model()->findAll(), 'id', 'range'), array('empty'=>'Any')); ?>                
    </div>    
    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); ?>
        
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
        
         $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'videos-grid',
            'dataProvider' => $dataProvider,
            //'filter' => $model,
            'columns' => array(                    
                //'title',
                array(
                        'type'=>'raw',
                        'header'=>'',
                        'value'=>'"<div id=\"divselectvideo".$data->id."\" class=\"new_video\">
                    <a id=\"".$data->id."\" class=\"videolink\" href=\"javascript:void(0);\" title=\"".$data->title."\">
                        <div class=\"img\">
                            <div style=\'display:none\'>".CHtml::image(UtilityHtml::getVideoImage($data->image_url))."</div>
                            <input type=\"checkbox\" id=\"videoid".$data->id."\" name=\"videoids[]\" value=\"".$data->id."\"/>
                        </div>                                         
                    </a>
                </div>"',                                                                  
                ),
                array(
                        'type'=>'raw',
                        'header'=>'Title',
                        'value'=>'CHtml::link($data->title, Yii::app()->createUrl(\'admin/videos/watchVideo\', array(\'iframe_code\' => base64_encode($data->iframe_code), \'description\' => base64_encode($data->description))), array(\'class\' => "ajax play", \'onclick\' => \'_gaq.push([\\\'_trackEvent\\\', \\\'Videos\\\', \\\'Play\\\', \\\'\' . addslashes($data->title) . \'\\\']); js:publisOnFb("\' . Yii::app()->createAbsoluteUrl(\'/site/watchVideoPublisFb\', array(\'id\' => \'93\')) . \'");\'))',                                                                  
                ),
                 array(
                        'header'=>'Genre',
                        'value'=>'($data->genreRel!=null) ? $data->genreRel->name : null',
                        //'filter'=> CHtml::activeTextField($model, 'genreRel'),
                ),
                array(
                        'header'=>'Category',
                        'value'=>'($data->categoryRel!=null) ? $data->categoryRel->name : null',
                ),
                array(
                        'header'=>'Age range',
                        'value'=>'($data->agerangeRel!=null) ? $data->agerangeRel->range : null',
                )


            )
        ));                          
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
        var snCheckBoxLength = $('input:checkbox:checked').length;
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