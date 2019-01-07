<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'pages-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            
            <div class="basic_nav_center">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'title'); ?>:</h6>
                    <?php echo $form->textField($model, 'title'); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <?php if($model->isNewRecord):?>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'custom_url_key'); ?>:</h6>
                    <?php echo $form->textField($model, 'custom_url_key'); ?>
                    <?php echo $form->error($model, 'custom_url_key'); ?>
                </div>
                <?php endif;?>
                <div class="info2 fckwidth">
                    <h6><?php echo $form->labelEx($model, 'content'); ?>:</h6>
                    <?php
                    $this->widget('application.extensions.fckeditor.FCKEditorWidget', array(
                        "model" => $model,
                        "attribute" => 'content',
                        // "toolbarSet"=>'Basic',
                        "fckeditor" => Yii::app()->basePath . "/../fckeditor/fckeditor.php",
                        "fckBasePath" => Yii::app()->baseUrl . "/fckeditor/"
                    ));
                    ?>
                    <?php echo $form->error($model, 'content'); ?>
                </div>               
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'meta_title'); ?>:</h6>
                    <?php echo $form->textField($model, 'meta_title'); ?>
                    <?php echo $form->error($model, 'meta_title'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'meta_keyword'); ?>:</h6>
                    <?php echo $form->textField($model, 'meta_keyword'); ?>
                    <?php echo $form->error($model, 'meta_keyword'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'meta_description'); ?>:</h6>
                    <?php echo $form->textArea($model, 'meta_description'); ?>
                    <?php echo $form->error($model, 'meta_description'); ?>
                </div>
<!--                <div class="info2">
                    <h6><?php /*echo $form->labelEx($model, 'pos'); ?>:</h6>
                    <?php echo $form->textField($model, 'pos'); ?>
                    <?php echo $form->error($model, 'pos'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'status'); ?>:</h6>
                    <?php echo $form->dropDownlist($model, 'status', UtilityHtml::getStatusArray()); ?>
                    <?php echo $form->error($model, 'status'); */?>
                </div>-->
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