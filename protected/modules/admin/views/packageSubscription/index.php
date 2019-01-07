<?php
$this->breadcrumbs = array(
    $ssType => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $ssType . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        $ssLinkName = "<span>".CHtml::image(Yii::app()->request->baseUrl."/images/icon/add.png")."</span><font>Add ".$ssType."</font>";
        echo CHtml::link($ssLinkName, Yii::app()->createUrl("admin/packageSubscription/create", array('type' => $ssType)), array("class"=>"block add"));

        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
            'template'=>'{items}{pager}'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>