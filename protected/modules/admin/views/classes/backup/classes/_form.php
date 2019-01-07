<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'class-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            ?>
            <div class="basic_nav_left">
                <div class="user_p">
                    <?php
                    $snStudioId = Yii::app()->admin->id;
                    $ssImageClass = 'staticurl';
                    $ssDefaultImage = Yii::app()->baseUrl . '/images/icon/video2.png';
                    if (!(strpos($model->image_url, 'http') === false)) {
                        $ssDisplayImage = $model->image_url;
                    } else if ($model->image_url != '') {
                        $ssImage = Yii::app()->baseUrl . "/uploads/users/classes/$snStudioId/thumb/$model->image_url";
                        $ssDisplayImage = ($model->image_url != "" && file_exists(Yii::getPathOfAlias('webroot') . "/uploads/users/classes/$snStudioId/thumb/$model->image_url")) ? $ssImage : $ssDefaultImage;
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
                </div><br />OR<br /><br />
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
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'start_time'); ?>:</h6>
                    <?php
                    $this->widget('application.widget.timepicker.timepicker', array(
                        'model' => $model,
                        'name' => 'start_time',
                        'select' => 'time',
                        'options' => array(
                            'showOn' => 'focus',
                            'timeFormat' => 'hh:mm'
                        )
                    ));
                    ?>
                    (format:- hh:mm)
                    <?php echo $form->error($model, 'start_time'); ?>
                </div>
                <div class="info2">
                    <div class="days">
                        <a href="javascript:void(0);" class="daylink s_check <?php echo @strstr($model->days_of_week, '0') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck0" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '0') ? 'checked="checked"' : ''; ?> value="0"/></a>
                        <a href="javascript:void(0);" class="daylink m_check <?php echo @strstr($model->days_of_week, '1') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck1" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '1') ? 'checked="checked"' : ''; ?> value="1"/></a>
                        <a href="javascript:void(0);" class="daylink t_check <?php echo @strstr($model->days_of_week, '2') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck2" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '2') ? 'checked="checked"' : ''; ?> value="2"/></a>
                        <a href="javascript:void(0);" class="daylink w_check <?php echo @strstr($model->days_of_week, '3') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck3" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '3') ? 'checked="checked"' : ''; ?> value="3"/></a>
                        <a href="javascript:void(0);" class="daylink t_check <?php echo @strstr($model->days_of_week, '4') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck4" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '4') ? 'checked="checked"' : ''; ?> value="4"/></a>
                        <a href="javascript:void(0);" class="daylink f_check <?php echo @strstr($model->days_of_week, '5') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck5" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '5') ? 'checked="checked"' : ''; ?> value="5"/></a>
                        <a href="javascript:void(0);" class="daylink s_check <?php echo @strstr($model->days_of_week, '6') ? 'active' : ''; ?>"><input type="checkbox" id="daycheck6" class="styled" name="Classes[days_of_week][]" <?php echo @strstr($model->days_of_week, '6') ? 'checked="checked"' : ''; ?> value="6"/></a>
                    </div>
                    <?php echo $form->error($model, 'days_of_week'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'start_date'); ?>:</h6>
                    <?php
                    $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'start_date',
                        'value' => $model->start_date,
                        'options' => array(
                            'showButtonPanel' => true,
                            'changeYear' => true,
                            'dateFormat' => 'yy-mm-dd'
                        ),
                        'htmlOptions' => array(
                            'class' => 'price'
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'start_date'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'end_date'); ?>:</h6>
                    <?php
                    $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'end_date',
                        'value' => $model->end_date,
                        'options' => array(
                            'showButtonPanel' => true,
                            'changeYear' => true,
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'class' => 'price'
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'end_date'); ?>
                </div>
                <?php if (!$model->isNewRecord): ?>
                    <div class="info2">
                        <h6><?php echo $form->labelEx($model, 'token'); ?>:</h6>
                        <?php echo Yii::app()->params['site_url'] . CController::createUrl('/site/addToClass', array('token' => $model->token)); ?>
                    </div>
                <?php endif; ?>
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
                <div class="subscriptions documents_tab">
                    <!-- FOR ADD BASE SUBSCRIPTION / VIDEOS -->
                    <div class="sub_left">
                        <h6>Instructors:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Instructor", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("classes/addUsers", array('id' => $model->id, 'user_type' => Yii::app()->params['user_type']['instructor'])) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "class_id=" . $model->id;
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->user_id, $amSelected) && $omData->user->user_type == Yii::app()->params['user_type']['instructor']):
                                    $ssName = ucfirst($omData->user->first_name . ' ' . $omData->user->last_name);
                                    $ssUpdateDivId = "instructor_" . $omData->user_id;
                                    $ssLoaderDivId = "loader_instructor_" . $omData->user_id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('classes/removeUsers', array('id' => $omData->user_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <!-- FOR ADD UPDATED SUBSCRIPTION / VIDEOS -->                    
                    <div class="sub_left">
                        <h6>Dancers:</h6>
                        <?php
                        //echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Students", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("classes/addUsers", array('id' => $model->id, 'user_type' => Yii::app()->params['user_type']['students'])) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        echo '<span class="ajax buttons add_butt">List of Dancers</span>';
                        $ssPostData = "class_id=" . $model->id;
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->user_id, $amSelected) && $omData->user->user_type == Yii::app()->params['user_type']['dancer']):
                                    $ssName = ucfirst($omData->user->first_name . ' ' . $omData->user->last_name);
                                    $ssUpdateDivId = "instructor_" . $omData->user_id;
                                    $ssLoaderDivId = "loader_instructor_" . $omData->user_id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('classes/removeUsers', array('id' => $omData->user_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                    echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                    echo '</span>';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div> 
                    <div class="sub_left">
                        <h6>Videos:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Videos", CController::createUrl("classes/assignVideos", array('id' => $model->id)), array('class' => 'buttons add_butt'));
                        $ssPostData = "class_id=" . $model->id;
                        if ($omClassVideos):
                            foreach ($omClassVideos as $omData):
                                $ssName = ucfirst($omData->video->title);
                                $ssUpdateDivId = "video_" . $omData->video_id;
                                $ssLoaderDivId = "loader_video_" . $omData->video_id;
                                echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                echo $ssName;
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('classes/removeVideos', array('id' => $omData->video_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
                                echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                echo '</span>';

                            endforeach;
                        endif;
                        ?>
                    </div>
                    <!-- FOR ADD DOCUMENTS FOR PACKAGE / SUBSCRIPTION -->                                        
                    <div class="sub_left last">
                        <h6>Documents:</h6>                       
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Document", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("classes/addDocumentsToClass", array('id' => $model->id)) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "class_id=" . $model->id;
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
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ ajaxRequest('" . Yii::app()->createUrl('admin/classes/removeDocumentToClass', array('id' => $omData->document->id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "');return false;}else{return false;}", "class" => "close"));
                                echo '<span id="' . $ssLoaderDivId . '" style="display:none">' . CHtml::image(Yii::app()->baseUrl . "/images/ajax_loading.gif") . '</span>';
                                echo '</div>';
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
<script>
    $(".daylink").click(function() {
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            var snCheckboxId = $(this).children('input').attr('id');
            $("#" + snCheckboxId).attr('checked', 'checked');
        }
        else {
            $(this).removeClass("active");
            var snCheckboxId = $(this).children('input').attr('id');
            //$("#"+snCheckboxId).attr('checked','');
            $("#" + snCheckboxId).attr('checked', false);
        }
    });
</script>