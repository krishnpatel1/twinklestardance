<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'users-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            echo $form->errorSummary($model);
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
                    <h6><?php echo $form->labelEx($model, 'studio_name'); ?>:</h6>
                    <?php echo $form->textField($model, 'studio_name'); ?>
                    <?php echo $form->error($model, 'studio_name'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'email'); ?>:</h6>
                    <?php echo $form->textField($model, 'email'); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'password'); ?>:</h6>
                    <?php echo $form->passwordField($model, 'password', array('autocomplete' => 'off', 'value' => '')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'address_1'); ?>:</h6>
                    <?php echo $form->textArea($model, 'address_1'); ?>
                    <?php echo $form->error($model, 'address_1'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'city'); ?>:</h6>
                    <?php echo $form->textField($model, 'city'); ?>
                    <?php echo $form->error($model, 'city'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'state_id'); ?>:</h6>
                    <?php echo $form->dropDownList($model, 'state_id', $amStates, array('prompt' => 'Select')); ?>
                    <?php echo $form->error($model, 'state_id'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'zip'); ?>:</h6>
                    <?php echo $form->textField($model, 'zip'); ?>
                    <?php echo $form->error($model, 'zip'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'phone'); ?>:</h6>
                    <?php echo $form->textField($model, 'phone'); ?>
                    <?php echo $form->error($model, 'phone'); ?>
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
        </div>
    </div>
</div>