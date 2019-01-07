<?php
$this->breadcrumbs = array(
    Classes::label(2) => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . Classes::label(2) . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        if (AdminModule::isStudioAdmin()) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/add.png") . "</span><font>Add Class</font>";
            echo CHtml::link($ssLinkName, Yii::app()->createUrl("admin/classes/create"), array("class" => "block add"));
        }
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
            'template' => '{items}{pager}'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>
