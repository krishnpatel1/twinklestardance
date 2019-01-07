<?php
/* @var $this VideoController */
/* @var $model Video */

$this->breadcrumbs = array(
    Yii::t('app', 'Video') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Video') . "<span>&nbsp;</span>")
);

if (AdminModule::isAdmin()) {
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('index')),
        array('label' => Yii::t('app', 'Create Video'), 'url' => array('create')),    
    );
}
else{
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('index')),        
    );
}
?>

<h1>Search videos</h1>
<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row row-spaced">
        <?php echo $form->label($model,'title',array('class'=>'inline')); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>64)); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'genre',array('class'=>'inline')); ?>
        <?php echo $form->dropDownList($model,'genre', CHtml::listData(Genre::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'category',array('class'=>'inline')); ?>
        <?php echo $form->dropDownList($model,'category', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced">
        <?php echo $form->label($model,'age_range',array('class'=>'inline')); ?>        
        <?php echo $form->dropDownList($model,'age_range', CHtml::listData(Agerange::model()->findAll(), 'id', 'range'), array('empty'=>'Any')); ?>
    </div>    
    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); 

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-videos-form',
    'enableAjaxValidation' => false,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'videos-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(    
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'deleteids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),
		'title',
        //array('name'=>'genre','value'=>'$data->genre'),
         array(
                'header'=>'Genre',
                'value'=>'($data->genreRel!=null) ? $data->genreRel->name : null',
                //'filter'=> CHtml::activeTextField($model, 'genreRel'),
        ),
        array(
                'header'=>'Category',
                'value'=>'($data->categoryRel!=null) ? $data->categoryRel->name : null',
        ),
        array(
                'header'=>'Age range',
                'value'=>'($data->agerangeRel!=null) ? $data->agerangeRel->range : null',
        ),
        
		array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('inx', 'Actions')
        )
	
    )
));



if (AdminModule::isAdmin())
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'video-delete', 'class' => 'submitbtnclass'));
$this->endWidget();
?>

<script type="text/javascript">
    $("#video-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
</script>