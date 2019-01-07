<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Classes::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelClass->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelClass->name . " - " . Videos::label(2) . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">        
        <?php
        if (AdminModule::isDancer()):
            $this->beginWidget('GxActiveForm', array(
                'id' => 'purchase-video-form',
                'enableAjaxValidation' => false
            ));
            echo GxHtml::hiddenField("class_id", $oModelClass->id);
            echo GxHtml::submitButton(Yii::t('app', 'Buy Videos'), array('id' => 'buy-video', 'class' => 'submitbtnclass'));
        endif;
        echo '<div class="clear"></div>';
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view_class_videos',
            'template' => '{items}{pager}'
        ));
        if (AdminModule::isDancer()):
            $this->endWidget();
        endif;
        ?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $("#buy-video").click(function(){
        if ($('input:checkbox:checked').length > 0) { 
            if(confirm("Parental supervision is required to make purchase.")){
                return true;
            }else{return false;}
        }else{
            history.go(-1);
            return false;
        }
    });
    $(".videolink").click(function(){
        if (!$("#divselectvideo"+this.id).hasClass("add_block")) {
            $("#divselectvideo"+this.id).addClass("add_block");
            $("#videoid"+this.id).attr('checked','checked');
        }
        else{
            $("#divselectvideo"+this.id).removeClass("add_block");
            $("#videoid"+this.id).attr('checked', false);
        }
    });

</script>