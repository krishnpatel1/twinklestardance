<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Documents') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Documents') . "<span>&nbsp;</span>")
);
if (AdminModule::isAdmin()):
    $this->menu = array(
        array('label' => Yii::t('app', 'Add Document'), 'url' => array('create')),
    );
endif;

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-orders-form',
    'enableAjaxValidation' => false,
));
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'package-subscription-documents-grid',
    'dataProvider' => $model,
    //'filter' => $model,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'document_sub_id[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->document->id."_".$data->subscription->id',
        ),
        array(
            'name' => 'subscription_id',
            'value' => '$data->subscription->name',
            'header' => 'Subscription'
        ),
        array(
            'name' => 'document_title',
            'value' => 'ucfirst($data->document->document_title)',
            'header' => 'Document Name',
            'htmlOptions' => array('style' => 'width:250px;')
        ),
        array(
            'name' => 'created_at',
            'value' => 'date(Yii::app()->params[\'defaultDateFormat\'],strtotime($data->document->created_at))',
            'header' => 'Date',
            'htmlOptions' => array('style' => 'text-align:center;width:90px;')
        ),
        array(
            'template' => '{view}{update}{delete}',
            'class' => 'CButtonColumn',
            'header' => Yii::t('inx', 'Actions'),
            'deleteConfirmation' => "Are you sure want to delete this document?",
            'buttons' => array
                (
                'view' => array(
                    'url' => '(!strstr($data->document->document_name, \'http\')) ? Yii::app()->params[\'site_url\'] . Yii::app()->baseUrl . \'/uploads/packagesubscription/documents/\' . $data->document->document_name : $data->document->document_name',
                    'options' => array('title' => 'Click here to view document', 'target' => '_blank'),
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl(\'admin/packageSubscriptionDocuments/update\',array(\'id\' => $data->document->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl(\'admin/packageSubscriptionDocuments/delete\',array(\'document_id\' => $data->document->id,\'subscription_id\' => $data->subscription->id))'
                )
            ),
        )
    ),
));
if (AdminModule::isAdmin())
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'document-delete', 'class' => 'submitbtnclass'));
$this->endWidget();
?>

<script type="text/javascript">
    $("#document-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one document to permorm this action.");
            return false;
        }
    });
</script>