<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->breadcrumbs = array(
    Yii::t('app', 'Testimonials') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Testimonials') . "<span>&nbsp;</span>")
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create Testimonial'), 'url' => array('create')),
);

$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-testimonials-form',
    'enableAjaxValidation' => false,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'testimonials-grid',
    'dataProvider' => $model->search(),
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
		'id',
		'name',
		array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('inx', 'Actions')
        )
	
    )
));

if (AdminModule::isAdmin()){
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'testimonial-delete', 'class' => 'submitbtnclass'));
    echo GxHtml::submitButton(Yii::t('app', 'Save changes'), array('id' => 'testimonial-save', 'class' => 'submitbtnclass'));
}
$this->endWidget();
?>

<script type="text/javascript">
$(document).ready(function() {             
    $("#testimonial-save").click(function(event) {               
        event.preventDefault();        	        
        updateids=[];
        updatelinks=[];
        updatepos=[];
        $(".items tr").each(function(index){
            if(index!=0){                
                updateids.push($(this).find('.ordercheck').val());                 
                updatepos.push(index);
            }
        });
        $.post( "/user/testimonials", { 'updateids[]': updateids, 'updatepos[]': updatepos }, function( data ) {
            $(".flash_message").html('<div class="flash-success">Testimonials saved successfully</div>');
            window.scrollTo(0, 0);
        } );
    });

    $("#testimonial-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
    
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
    return ui;
    };

    $(".items tbody").sortable({
        helper: fixHelper
    }).disableSelection();        
});
</script>