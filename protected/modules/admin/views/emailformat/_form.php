<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'email-format-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    ));
            ?>
            <div class="basic_nav_center">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'title'); ?>:</h6>
                    <?php echo EmailFormat::model()->getEmailTitleLabel($model->title); ?>
                    <?php echo $form->hiddenField($model, 'title', array('value' => $model->title)); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'subject'); ?>:</h6>
                    <?php echo $form->textField($model, 'subject'); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'body'); ?>:</h6>
                    <?php
                    $this->widget('application.extensions.fckeditor.FCKEditorWidget', array(
                        "model" => $model,
                        "attribute" => 'body',
                        // "toolbarSet"=>'Basic',
                        "fckeditor" => Yii::app()->basePath . "/../fckeditor/fckeditor.php",
                        "fckBasePath" => Yii::app()->baseUrl . "/fckeditor/"
                    ));
                    ?>
                    <?php echo $form->error($model, 'body'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'last_updated'); ?>:</h6>
                    <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->last_updated, 'yyyy-MM-dd H:i:s'), 'medium', null) ?>
                    <?php echo $form->error($model, 'last_updated'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'status'); ?>:</h6>
                    <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>
            <div class="info2">
                <?php
                echo GxHtml::submitButton(Yii::t('app', 'Save')) . '&nbsp;';
                echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                ?>                   
            </div>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
        </div>
    </div>
</div>