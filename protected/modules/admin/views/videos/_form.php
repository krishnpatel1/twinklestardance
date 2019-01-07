<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'videos-form',
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnChange' => false,
                    'validateOnSubmit' => true
                )
                    ));
            ?>
            <div class="basic_nav_left">
                <div class="user_p">
                    <?php
                    if ($model->image_url != ""):
                        echo '<span>';
                        echo CHtml::image($model->image_url);
                        echo '</span>';
                    else:
                        echo '<span class="default_icon">';
                        echo CHtml::image(Yii::app()->baseUrl . '/images/icon/video2.png');
                        echo '</span>';
                    endif;
                    ?>                    
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'image_url'); ?>:</h6>
                    <?php echo $form->textField($model, 'image_url'); ?>
                    <br /> <span style="color:yellowgreen;">Note: For getting YouTube video image "http://img.youtube.com/vi/ VIDEO_ID/0.jpg"</span>
                    <?php echo $form->error($model, 'image_url'); ?>
                </div>
            </div>

            <div class="basic_nav_right">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'title'); ?>:</h6>
                    <?php echo $form->textField($model, 'title'); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <div class="info2 fckwidth">
                    <h6><?php echo $form->labelEx($model, 'description'); ?>:</h6>
                    <?php //echo $form->textArea($model, 'description'); ?>
                    <?php
                    $this->widget('application.extensions.fckeditor.FCKEditorWidget', array(
                        "model" => $model,
                        "attribute" => 'description',
                        "fckeditor" => Yii::app()->basePath . "/../fckeditor/fckeditor.php",
                        "fckBasePath" => Yii::app()->baseUrl . "/fckeditor/"
                    ));
                    ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'price'); ?>:</h6>
                    <?php echo $form->textField($model, 'price', array('class' => 'price')); ?>
                    <?php echo $form->error($model, 'price'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'iframe_code'); ?>:</h6>
                    <?php echo $form->textArea($model, 'iframe_code'); ?> <br />
                    <span class="notice" style="color:yellowgreen;">Ex: http://api.smugmug.com/services/embed/VIDEO_ID?width=800&height=600</span>
                    <?php echo $form->error($model, 'iframe_code'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'status'); ?>:</h6>
                    <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive', '2' => 'Deleted')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'genre'); ?>:</h6>
                    <?php echo $form->dropDownList($model,'genre', CHtml::listData(Genre::model()->findAll(), 'id', 'name'), array('empty'=>'Select genre')); ?>
                    <?php echo $form->error($model, 'genre'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'age_range'); ?>:</h6>
                    <?php echo $form->dropDownList($model,'age_range', CHtml::listData(Agerange::model()->findAll(), 'id', 'range'), array('empty'=>'Select age range')); ?>
                    <?php echo $form->error($model, 'age_range'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'category'); ?>:</h6>
                    <?php echo $form->dropDownList($model,'category', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty'=>'Select category')); ?>
                    <?php echo $form->error($model, 'category'); ?>
                </div>
                <div class="info2">
                    <?php
                    echo GxHtml::submitButton(Yii::t('app', 'Save')) . '&nbsp;';
                    echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
            <?php if ($model->id > 0): ?>                
                <div class="subscriptions">
                    <!-- FOR ADD BASE SUBSCRIPTION / VIDEOS -->
                    <div class="sub_left">
                        <h6>Base Subscription:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Subscription", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("videos/addToSubscription", array('id' => $model->id, 'updated' => '0')) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "video_id=" . $model->id;
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->subscription_id, $amSelected) && $omData->additional_status == 0):
                                    $ssName = $omData->subscription_name;
                                    $ssUpdateDivId = "base_sub_" . $omData->subscription_id;
                                    $ssLoaderDivId = "loader_base_sub_" . $omData->subscription_id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('videos/removeSubscriptionVideo', array('id' => $omData->subscription_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <!-- FOR ADD UPDATED SUBSCRIPTION / VIDEOS -->                    
                    <div class="sub_left last">
                        <h6>Update Subscription:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Subscription", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("videos/addToSubscription", array('id' => $model->id, 'updated' => '1')) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->subscription_id, $amSelected) && $omData->additional_status == 1):
                                    $ssName = $omData->subscription_name;
                                    $ssUpdateDivId = "updated_sub_" . $omData->subscription_id;
                                    $ssLoaderDivId = "loader_updated_sub_" . $omData->subscription_id;

                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('videos/removeSubscriptionVideo', array('id' => $omData->subscription_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>                   
                    <div class="clear"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>