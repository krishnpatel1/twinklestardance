<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'package-subscription-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            ?>
            <div class="basic_nav_left">
                <div class="user_p">
                    <?php
                    $ssImageClass = 'staticurl';
                    $ssDefaultImage = Yii::app()->baseUrl . '/images/icon/video2.png';
                    if (!(strpos($model->image_url, 'http') === false)) {
                        $ssDisplayImage = $model->image_url;
                    } else if ($model->image_url != '') {
                        $ssImage = Yii::app()->baseUrl . '/uploads/packagesubscription/thumb/' . $model->image_url;
                        $ssDisplayImage = ($model->image_url != "" && file_exists(Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/thumb/' . $model->image_url)) ? $ssImage : $ssDefaultImage;
                    } else {
                        $ssDisplayImage = $ssDefaultImage;
                        $ssImageClass = 'default_icon';
                    }
                    ?>
                    <span class="<?php echo $ssImageClass; ?>">
                        <?php echo CHtml::image($ssDisplayImage); ?>
                    </span>
                </div>               
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'image_url'); ?>:</h6>
                    <?php echo $form->fileField($model, 'image_url'); ?>
                    <?php echo $form->error($model, 'image_url'); ?>
                </div> <br />OR<br /><br />
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'static_image_url'); ?>:</h6>
                    <?php echo $form->textField($model, 'static_image_url'); ?>
                    <?php echo $form->error($model, 'static_image_url'); ?>
                </div>               
            </div>
            <div class="basic_nav_right">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'name'); ?>:</h6>
                    <?php echo $form->textField($model, 'name'); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
                <div class="info2 fckwidth">
                    <h6><?php echo $form->labelEx($model, 'description'); ?>:</h6>
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
                    <h6><?php echo $form->labelEx($model, 'price_one_time'); ?>:</h6>
                    <?php echo $form->textField($model, 'price_one_time', array('class' => 'price')); ?>
                    <?php echo $form->error($model, 'price_one_time'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'price'); ?>:</h6>
                    <?php echo $form->textField($model, 'price', array('class' => 'price')); ?>
                    <?php echo $form->error($model, 'price'); ?>
                </div>
                <div class="info2 term">
                    <h6><?php echo $form->labelEx($model, 'duration'); ?>:</h6>
                    <?php echo $form->dropDownlist($model, 'duration', PackageSubscription::getTerms(), array('class' => 'styled')); ?>
                    <?php echo $form->error($model, 'duration'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'base_video_limit'); ?>:</h6>
                    <?php echo $form->textField($model, 'base_video_limit', array('class' => 'price')); ?>
                    <?php echo $form->error($model, 'base_video_limit'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'available_update'); ?>:</h6>
                    <?php
                    echo $form->textField($model, 'available_update', array('class' => 'price')) . '&nbsp;';
                    if (!$model->isNewRecord):
                        echo CHtml::ajaxLink(Yii::t('app', 'Update'), Yii::app()->createUrl('admin/packageSubscription/setAvailableUpdate'), array(// ajaxOptions
                            'type' => 'POST',
                            'beforeSend' => 'js:function(request){
                                if(confirm("Are you sure you want to update?")){
                                    $("#loader_available_update").show();
                                    return true;
                                }
                                else 
                                    return false;
                            }',
                            'success' => "function( resultJSON ){// handle return data   
                                var data = $.parseJSON(resultJSON);
                                $('#PackageSubscription_available_update').val(data.available_update);
                                $('#loader_available_update').hide();
                            }",
                            'data' => array('id' => $model->id, 'value' => "js:$('#PackageSubscription_available_update').val()")), array(//htmlOptions
                            'class' => 'link-button'
                        ));
                        echo '<span id="loader_available_update" style="display:none;">&nbsp;' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                    endif;
                    ?>
                    <?php echo $form->error($model, 'available_update'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'status'); ?>:</h6>
                    <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive', '2' => 'Deleted')); ?>
                    <?php echo $form->error($model, 'status'); ?>
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
                        <h6><?php echo ($ssType == "Package") ? "Base Subscription" : "Base Videos"; ?>:</h6>
                        <?php
                        $ssLinkName = ($ssType == "Package") ? "Add Subscription" : "Add Video";
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . $ssLinkName, 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("packageSubscription/assignSubVideos", array('id' => $model->id, 'updated' => '0')) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "package_sub_id=" . $model->id;
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->id, $amSelected) && $omData->additional_status == 0):
                                    $ssName = ($ssType == "Package") ? $omData->name : $omData->title;
                                    $ssUpdateDivId = ($ssType == "Package") ? "base_sub_" . $omData->id : "base_video_" . $omData->id;
                                    $ssLoaderDivId = ($ssType == "Package") ? "loader_base_sub_" . $omData->id : "loader_base_video_" . $omData->id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('packageSubscription/removeSubscriptionVideo', array('id' => $omData->id, 'type' => $model->type)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "');return false;}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <!-- FOR ADD UPDATED SUBSCRIPTION / VIDEOS -->                    
                    <div class="sub_left">
                        <h6><?php echo ($ssType == "Package") ? "Update Subscription" : "Update Videos"; ?>:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . $ssLinkName, 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("packageSubscription/assignSubVideos", array('id' => $model->id, 'updated' => '1')) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->id, $amSelected) && $omData->additional_status == 1):
                                    $ssName = ($ssType == "Package") ? $omData->name : $omData->title;
                                    $ssUpdateDivId = ($ssType == "Package") ? "updated_sub_" . $omData->id : "updated_video_" . $omData->id;
                                    $ssLoaderDivId = ($ssType == "Package") ? "loader_updated_sub_" . $omData->id : "loader_updated_video_" . $omData->id;

                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('packageSubscription/removeSubscriptionVideo', array('id' => $omData->id, 'type' => $model->type)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "');return false;}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php if($ssType != "Package"):?>
                    <!-- FOR ADD DOCUMENTS FOR PACKAGE / SUBSCRIPTION -->                                        
                    <div class="sub_left last">
                        <h6>Documents:</h6>                       
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Document", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("packageSubscription/addDocuments", array('id' => $model->id)) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "package_sub_id=" . $model->id;
                        if ($omDocuments):
                            foreach ($omDocuments as $omData):
                                $ssDocumentLink = Yii::app()->params['site_url'] . '/' . Yii::app()->baseUrl . '/uploads/packagesubscription/documents/' . $omData->document->document_name;
                                $ssUpdateDivId = "document_" . $omData->document->id;
                                $ssLoaderDivId = "loader_document_" . $omData->document->id;

                                echo '<div id="' . $ssUpdateDivId . '" class="buttons">';

                                $ssDirectoryPath = Yii::app()->params['site_url'] . Yii::app()->baseUrl . '/uploads/packagesubscription/documents/';
                                $ssUrl = (!strstr($omData->document->document_name, 'http')) ? $ssDirectoryPath . $omData->document->document_name : $omData->document->document_name;
                                echo CHtml::link('<span class="white">' . $omData->document->document_title . '</span>', $ssUrl, array('target' => '_blank'));

                                //echo CHtml::link($omData->document_title, $ssDocumentLink, array('title' => 'Click here to view this document', 'target' => '_blank'));
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ ajaxRequest('" . CController::createUrl('packageSubscription/removeDocument', array('id' => $omData->document->id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "');return false; }else{return false;}", "class" => "close"));
                                echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                echo '</div>';
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php endif;?>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>