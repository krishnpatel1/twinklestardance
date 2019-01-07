<div class="middle">
    <div class="fix">
        <div class="basic_nav">
            <?php
            $form = $this->beginWidget('GxActiveForm', array(
                'id' => 'system-config-form',
                'enableAjaxValidation' => true,
            ));
            ?>

            <div class="basic_nav_center">
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'name'); ?>:</h6>
                    <?php echo $model->name; ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'value'); ?>:</h6>
                    <?php echo $form->textArea($model, 'value'); ?>
                    <?php echo $form->error($model, 'value'); ?>
                </div>
                <div class="info2">
                    <h6><?php echo $form->labelEx($model, 'position'); ?>:</h6>
                    <?php echo $form->textField($model, 'position'); ?>
                    <?php echo $form->error($model, 'position'); ?>
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
