<?php
/* @var $this ImageController */
/* @var $model Image */

$this->breadcrumbs = array(
    Yii::t('app', 'Home Page Gallery') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Home Page Gallery') . "<span>&nbsp;</span>")
);
?>

<h1>Add new images</h1>
<form action="<?php echo Yii::app()->createUrl("image/uploadPost"); ?>"
      class="dropzone"
      id="image-dropzone"></form>

<br/><br/><br/>
<h1>Modify existing images</h1>
<p>Click and drag a row to reorder the images. Click on the save button at the bottom to save your changes.</p>
<?php
$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-image-form',
    'enableAjaxValidation' => false,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'image-grid',
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
        array(
            'type'=>'raw',
            //'sortable'=>false,
            'name'=>'imglink',
            'value'=>'"<input class=\"imglink\" type=\"text\" style=\"width:350px;\" value=\"".$data->imglink . "\"/>"',
        ),					
        array(
            'type'=>'raw',
            //'sortable'=>false,
            'name'=>'Image',
            'value'=>'"<span style=\"text-align:center; width:100%; display:block;\"><img style=\"max-width:500px;\" src=\"".Yii::app()->getBaseUrl(true)."/images/banner/".$data->url . "\"/></span>"',
        ),			
    )
));

if (AdminModule::isAdmin()){
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'image-delete', 'class' => 'submitbtnclass'));
    echo GxHtml::submitButton(Yii::t('app', 'Save changes'), array('id' => 'image-save', 'class' => 'submitbtnclass'));
}
$this->endWidget();
?>

<script type="text/javascript">



$(document).ready(function() {             
    Dropzone.options.imageDropzone = {
        sending: function(file, xhr, formData) {
            formData.append("position", $('.items tr').length);
        },
        init: function() {
            this.on("complete", function(file) {                 
                $.fn.yiiGridView.update("image-grid",{
                      complete: function(jqXHR, status) {
                            if (status=='success'){
                                console.log('hallo');
                                $(".items tbody").sortable({
                                    helper: fixHelper
                                }).disableSelection();
                            }
                        }
                });                
            });
        }        
    };
        
    $("#image-save").click(function(event) {               
        event.preventDefault();        	        
        updateids=[];
        updatelinks=[];
        updatepos=[];
        $(".items tr").each(function(index){
            if(index!=0){                
                updateids.push($(this).find('.ordercheck').val()); 
                updatelinks.push($(this).find('.imglink').val());
                updatepos.push(index);
            }
        });
        $.post( "/user/homepage", { 'updateids[]': updateids, 'updatelinks[]': updatelinks, 'updatepos[]': updatepos }, function( data ) {
            $(".flash_message").html('<div class="flash-success">Images saved successfully</div>');
            window.scrollTo(0, 0);
        } );
    });
    
    $("#image-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one item to perform this action.");
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