<?php
$this->breadcrumbs = array(
    Videos::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        if (AdminModule::isAdmin()) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/add.png") . "</span><font>Add Video</font>";
            echo CHtml::link($ssLinkName, Yii::app()->createUrl("admin/videos/create"), array("class" => "block add"));
        } elseif (AdminModule::isStudioAdmin()) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/updates_available.png") . "</span><font>Updates Available</font><div class='numb'>" . $snTotalAvailableVideo . "</div>";
            echo CHtml::link($ssLinkName, "javascript:void(0);", array("class" => "block add"));
        }

        $ssView = (AdminModule::isAdmin()) ? "_view" : "_view_other";
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => $ssView,
            'template' => '{items}{pager}'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>