<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'instructor-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    ));

            //echo $form->errorSummary($model);
            ?>
            <div class="basic_nav_left">
                <div class="user_p">
                    <?php
                    $ssImage = Yii::app()->baseUrl . '/uploads/users/thumb/' . $model->picture;
                    $ssDefaultImage = Yii::app()->baseUrl . '/images/icon/video2.png';
                    $ssDisplayImage = ($model->picture != "" && file_exists(Yii::getPathOfAlias('webroot') . '/uploads/users/thumb/' . $model->picture)) ? $ssImage : $ssDefaultImage;
                    $ssImageClass = ($model->picture != "" && file_exists(Yii::getPathOfAlias('webroot') . '/uploads/users/thumb/' . $model->picture)) ? '' : 'default_icon';
                    ?>
                    <span class="<?php echo $ssImageClass; ?>">
                        <?php echo CHtml::image($ssDisplayImage); ?>
                    </span>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'picture'); ?>:</h6>
                    <?php echo $form->fileField($model, 'picture'); ?>
                    <?php echo $form->error($model, 'picture'); ?>
                </div>
            </div>
            <div class="basic_nav_right">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'first_name'); ?>:</h6>
                    <?php echo $form->textField($model, 'first_name'); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'last_name'); ?>:</h6>
                    <?php echo $form->textField($model, 'last_name'); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'username'); ?>:</h6>
                    <?php echo ($model->isNewRecord) ? $form->textField($model, 'username') : "<strong>".$model->username."</strong>"; ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'email'); ?>:</h6>
                    <?php echo $form->textField($model, 'email'); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
                <?php //if($model->isNewRecord):?>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'password'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'password',array('value'=>'')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <?php //endif;?>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'phone'); ?>:</h6>
                    <?php echo $form->textField($model, 'phone'); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </div>
                 <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'status'); ?>:</h6>                    
                    <?php echo $form->dropDownList($model,'status',  array('1' => 'Active', '2' => 'Inactive')); ?>
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
                    <!-- FOR ADD TO CLASS -->
                    <div class="sub_left">
                        <h6>Classes:</h6>
                        <?php
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/add_small.png", '', array('class' => 'icon')) . "Add Class", 'javascript:void(0);', array('onclick' => 'js:openColorBox("' . CController::createUrl("users/addToClass", array('id' => $model->id)) . '");return false;', 'class' => 'ajax buttons add_butt'));
                        $ssPostData = "user_id=" . $model->id;
                        if ($omModelTrans):
                            foreach ($omModelTrans as $omData):
                                if (in_array($omData->class_id, $amSelected)):
                                    $ssName = ucfirst($omData->class->name);
                                    $ssUpdateDivId = "instructor_" . $omData->class_id;
                                    $ssLoaderDivId = "loader_instructor_" . $omData->class_id;
                                    echo '<span id="' . $ssUpdateDivId . '" class="buttons">';
                                    echo $ssName;
                                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/icon/close_butt.png"), "javascript:void(0);", array("onclick" => "if(confirm('Are you sure?')){ajaxRequest('" . CController::createUrl('users/removeFromClass', array('id' => $omData->class_id)) . "','" . $ssPostData . "','" . $ssUpdateDivId . "','" . $ssLoaderDivId . "')}else{return false;}", "class" => "close"));
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