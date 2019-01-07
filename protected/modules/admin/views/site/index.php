<?php $this->breadcrumbs = array(); ?>
<div class="middle_inner">
    <div class="fix">
        <?php
        $amMenus = Common::getDashboadMenusAsPerRole();

        if (count($amMenus) > 0) {
            foreach ($amMenus as $asValues) {
                $ssLInkName = "<span>" . CHtml::image($asValues['icon']) . "</span>";
                $ssLInkName .= $asValues['name'];
                echo CHtml::link($ssLInkName, $asValues['url'], array('class' => $asValues['class']));
            }
        }
        
        /*

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/video.png') . "</span>";
        $ssLInkName .= "<font>Videos</font>";
        echo CHtml::link($ssLInkName, array('videos/index'), array('class' => 'block'));

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/subscriptions.png') . "</span>";
        $ssLInkName .= "<font>Subscriptions</font>";
        echo CHtml::link($ssLInkName, Yii::app()->createUrl("admin/packageSubscription/index", array("type" => "Subscription")), array('class' => 'block'));

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/packages.png') . "</span>";
        $ssLInkName .= "<font>Packages</font>";
        echo CHtml::link($ssLInkName, Yii::app()->createUrl("admin/packageSubscription/index", array("type" => "Package")), array('class' => 'block last'));

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/orders.png') . "</span>";
        $ssLInkName .= "<font>Orders</font>";
        echo CHtml::link($ssLInkName, array('orders/admin'), array('class' => 'block'));

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/studios.png') . "</span>";
        $ssLInkName .= "<font>Studios</font>";
        echo CHtml::link($ssLInkName, array('users/index'), array('class' => 'block'));

        $ssLInkName = "<span>" . CHtml::image(Yii::app()->baseUrl . '/images/icon/settings.png') . "</span>";
        $ssLInkName .= "<font>Settings</font>";
        echo CHtml::link($ssLInkName, array('adminUser/update'), array('class' => 'block last'));
         * */
         
        ?>                
        <div class="clear"></div>
    </div>
</div>
