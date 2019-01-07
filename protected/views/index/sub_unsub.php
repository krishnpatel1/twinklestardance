<div class="inner_page">
    <div class="fix">
        <div class="ubsubscribe">
            <div class="box">
                <h2>
                    <?php
                    if ($omNewsletterUsers):
                        if (!$omNewsletterUsers->is_subscribed):
                            echo "You're unsubscribed. " . CHtml::link('Re-subscribe?', Yii::app()->createUrl('index/subscribe', array('id' => base64_encode($omNewsletterUsers->id))));
                        else:
                            echo "You're subscribed!";
                        endif;
                    endif;
                    ?>
                </h2>
            </div>
        </div>
    </div>
</div>