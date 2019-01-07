<?php 
$this->widget('application.widget.emultiselect.EMultiSelect', array(
        'sortable'=>true, 
        'searchable'=>true,
        'doubleClickable'=>true,
        'width'=>600
    ));
echo CHtml::listbox(
        'subscriptions_videos',
        $amSelected,
        $amResult,
        array('options'=>$amSelected,
                'multiple'=>'multiple', 
                'key'=>'subscriptions_videos', 
                'class'=>'multiselect')
    );
    
?>