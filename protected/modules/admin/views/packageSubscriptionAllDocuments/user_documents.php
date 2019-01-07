<head>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
</head>

<?php

$seach_keyword = (isset($_GET['PackageSubscriptionAllDocuments']) && isset($_GET['PackageSubscriptionAllDocuments']['document_title']) && !empty($_GET['PackageSubscriptionAllDocuments']['document_title']))? $_GET['PackageSubscriptionAllDocuments']['document_title'] : '';

$this->breadcrumbs = array(
    Yii::t('app', 'Documents') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Documents') . "<span>&nbsp;</span>")
);

$model_search = new PackageSubscriptionAllDocuments('search');
$form=$this->beginWidget('CActiveForm', array(
    'method'=>'get',
));

?>
   <div class="row row-spaced">
        <?php echo $form->label($model_search,'document_title',array('class'=>'inline document_title_lbl')); ?>
        <?php echo CHtml::textField('PackageSubscriptionAllDocuments[document_title]', $seach_keyword, array('id'=>'document_title', 'maxlength'=>255,'placeholder' => 'Search documents')); ?>
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>    
    
    <div class="row row-spaced buttons">
        
    </div>

<?php $this->endWidget(); ?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'package-subscription-documents-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'name' => 'document_title',
            'value' => 'ucfirst($data->document_title)',
            'header' => 'Document Name',
            'htmlOptions' => array('style' => 'width:250px;')
        ),
        array(
            'name' => 'created_at',
            'value' => 'date(Yii::app()->params[\'defaultDateFormat\'],strtotime($data->created_at))',
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
                    'url' => '(!strstr($data->document_name, \'http\')) ? Yii::app()->params[\'site_url\'] . Yii::app()->baseUrl . \'/uploads/packagesubscription/documents/\' . $data->document_name : $data->document_name',
                    'options' => array('title' => 'Click here to view document', 'target' => '_blank'),
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl(\'admin/packageSubscriptionAllDocuments/addClassesToDocument\',array(\'id\' => $data->id))',
                    'click' => 'js:function() { $.colorbox({href: $(this).attr("href"),width: "840px",height: "500px",iframe: true,scrolling: false}); return false;}',
                    'options' => array('title' => 'Add to classes', 'class' => 'ajax')
                )
            ),
        )
    ),
));
?>
