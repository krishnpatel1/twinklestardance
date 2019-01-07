<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Videos::label(2) . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    $oModelPackgeSub->name => array('class' => 'display two active', 'label' => "<font>&nbsp;</font>" . $oModelPackgeSub->name . "<span>&nbsp;</span>")
);
?>
<div class="middle">
    <div class="fix videos">
        <?php
        $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/updates_available.png") . "</span><font>Updates Available</font><div class='numb'>" . $snTotalAvailableVideo . "</div>";
        $ssLinkParams = (Yii::app()->getRequest()->getParam('package_id')) ? array('id' => $snPackageSubID, 'type' => $ssType, 'package_id' => Yii::app()->getRequest()->getParam('package_id')) : array('id' => $snPackageSubID, 'type' => $ssType);
        $ssLinkUrl = ($snTotalAvailableVideo > 0 && $ssType != "Package") ? Yii::app()->createUrl("admin/videos/chooseVideoToAddYourSubscription", $ssLinkParams) : "javascript:void(0);";
        echo CHtml::link($ssLinkName, $ssLinkUrl, array("class" => "block add"));

        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view_details',
            'template' => '{items}{pager}'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>