<div style="height:50px;"></div>
<div class="form">
    <?php $form = $this->beginWidget('GxActiveForm', array(
            'id'=>'add-users-form',
            'enableAjaxValidation' => true,
            'clientOptions'=>array(
                'validateOnChange'=>false,
                'validateOnSubmit'=>true            
            )
        ));?>
    <div class="row">
        <p><strong>Add to Class</strong></p>
        <p>
        <?php $this->widget('application.widget.emultiselect.EMultiSelect', array(
                'sortable'=>true, 
                'searchable'=>true,
                'doubleClickable'=>true,
                'width'=>600));

            echo CHtml::listbox(
                'class_ids',
                $amSelected,
                $amResult,
                array('options'=>array(),
                        'multiple'=>'multiple', 
                        'key'=>'class_ids', 
                        'class'=>'multiselect')
            );?>
        </p>
    </div>
    <div class="row">
        <label for="space">&nbsp;</label>
        <?php            
            echo GxHtml::submitButton(Yii::t('app', 'Save')).'&nbsp;';
            echo GxHtml::button(Yii::t('app', 'Cancel'),array('onclick'=>'parent.jQuery.colorbox.close();'));
        ?>
    </div>
    <?php $this->endWidget();?>
</div>