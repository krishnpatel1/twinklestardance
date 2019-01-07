<?php
$this->breadcrumbs = array(
    "Send Newsletter" => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>Send Newsletter<span>&nbsp;</span>")
);?>
<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'send-newsletter-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="basic_nav_center">                
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
            </div>
            <div class="info2">
                <?php
                echo GxHtml::submitButton(Yii::t('app', 'Send')) . '&nbsp;';
                echo GxHtml::button(Yii::t('app', 'Cancel'), array('onclick' => 'javascript:history.back();'));
                ?>                   
            </div>            
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
        </div>
    </div>
</div>