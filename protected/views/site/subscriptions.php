<?php
//$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/multizoom.js');
?>
<div class="inner_page">
    <div class="fix">
        <div class="one_subscription subscription newsletter_info">
            <h2>Subscriptions
                <div class="button2">
                    <?php echo CHtml::button('Sign Up', array('onclick' => 'js:openColorBox("' . CController::createUrl("index/joinNewsletter") . '",400,300);return false;', 'class' => 'ajax')); ?>
                </div>
                <div class="text-sub">
                    Join our Mailing List for FREE offers and tips on how to grow your studio with Twinkle Bear
                </div>
            </h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'subscription-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                )
            ));
            $i = 1;
            foreach ($allData as $data) {
                $divClass = ($i % 3 == 0) ? 'block last' : 'block';
                $i++;
                echo '<a href="' . Yii::app()->createUrl('site/subscriptions', array('id' => $data['id'], 'type' => $data['type'])) . '">';
                echo '<div class="' . $divClass . '">';

                //echo '<div class="img">';
                echo CHtml::image(UtilityHtml::getImageDisplay($data['image_url']));
                //echo '</div>';

                echo '<div class="details"><span></span><p>' . $data['name'] . '</p></div>';
                echo '</div></a>';
            }
            if (isset($allData[0]['videos']) && count($allData[0]['videos'])) {
                echo CHtml::radioButtonList('duration', null, array('M' => 'Monthly ($' . $allData[0]['price'] . ')', 'Y' => 'Yearly ($' . $allData[0]['price_one_time'] . ')'));
                echo '<br>';
                echo CHtml::submitButton('Subscribe', array('name' => 'susbscribe', 'value' => 'subscribe'));
            }
            $this->endWidget();
            ?>
            <div class="clear"></div>
        </div>
    </div>
</div><div>