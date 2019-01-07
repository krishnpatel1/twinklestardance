<head>
    <style type="text/css">
        #video-add.submitbtnclass {
            padding: 10px;
            float: left;
            height: 39px !important;
            line-height: normal !important;
            border-radius: 3px !important;
            font: bold 13px Arial;
            color: #fff;
            display: block;
            top: 5px;
            position: absolute;
        }
    
    </style>
</head>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Add ') . Videos::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Add ') . Videos::label(2) . "<span>&nbsp;</span>")
);

$this->menu = array(
    array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('/user/classes/vtable/'.Yii::app()->getRequest()->getParam('id'))),        
);

?>
<div class="middle">
    <div class="fix videos">
        <?php
        $this->beginWidget('GxActiveForm', array(
            'id' => 'assign-video-form',
            'enableAjaxValidation' => false
        ));
        echo GxHtml::submitButton(Yii::t('app', 'Done Adding'), array('id' => 'video-add', 'class' => 'submitbtnclass'));
        echo '<div class="clear"></div>';
        if (count($dataProvider->rawData) > 0)
        {
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view_assign_videos_tile',
                'template' => '{items}{pager}',
                'afterAjaxUpdate' => '$(".ajax").colorbox();'
            ));
        }
        else
        {
            echo "<div style='text-align:center;'>No results found!</div>";
        }
     
        $this->endWidget();
        ?>
        <div class="clear"></div>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $(".ajax").colorbox();
    });
    function bindColorbox() {
        $(".ajax").colorbox();
    }

    $("#video-add").click(function() 
    {
       // alert($('input:checkbox:checked').length);

        if ($('input:checkbox:checked').length > 0) 
        {
            return true;
        } 
        else 
        {
            history.go();
            return false;
        }
    });
    $(".videolink").click(function() {
        if (!$("#divselectvideo" + this.id).hasClass("add_block")) {
            $("#divselectvideo" + this.id).addClass("add_block");
            $("#videoid" + this.id).attr('checked', 'checked');
        }
        else {
            $("#divselectvideo" + this.id).removeClass("add_block");
            $("#videoid" + this.id).attr('checked', false);
        }
    });
</script>