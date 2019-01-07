<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Documents') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'My Assigned Documents') . "<span>&nbsp;</span>")
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'package-subscription-documents-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'name' => 'document_title',
            'value' => 'ucfirst($data->document->document_title)',
            'header' => 'Document Name',
            'htmlOptions' => array('style' => 'width:250px;')
        ),
        array(
            'name' => 'class_id',
            'value' => '$data->class->name',
            'header' => 'Class'
        ),
        array(
            'name' => 'created_at',
            'value' => 'date(Yii::app()->params[\'defaultDateFormat\'],strtotime($data->document->created_at))',
            'header' => 'Date',
            'htmlOptions' => array('style' => 'text-align:center;width:90px;')
        ),
        array(
            'template' => (AdminModule::isStudioAdmin()) ? '{view}{update}' : '{view}',
            'class' => 'CButtonColumn',
            'header' => Yii::t('inx', 'Actions'),
            'buttons' => array
                (
                'view' => array(
                    'url' => '(!strstr($data->document->document_name, \'http\')) ? Yii::app()->params[\'site_url\'] . Yii::app()->baseUrl . \'/uploads/packagesubscription/documents/\' . $data->document->document_name : $data->document->document_name',
                    'options' => array('title' => 'Click here to view document', 'target' => '_blank'),
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl(\'admin/packageSubscriptionDocuments/addClassesToDocument\',array(\'id\' => $data->document->id))',
                    'click' => 'js:function() { $.colorbox({href: $(this).attr("href"),width: "840px",height: "500px",iframe: true,scrolling: false}); return false;}',
                    'options' => array('title' => 'Add to classes', 'class' => 'ajax')
                )
            ),
        )
    ),
));
?>
