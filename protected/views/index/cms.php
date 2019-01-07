<div class="inner_page">
    <div class="fix">
        <div class="about_page">
            <h2>
                <?php
                echo $pageModel->title;
                if ($pageModel->custom_url_key == 'about_us'):
                    ?>
                    <div class="button2">
                        <?php echo CHtml::button('Sign Up', array('onclick' => 'js:openColorBox("' . CController::createUrl("index/joinNewsletter") . '",400,300);return false;', 'class' => 'ajax')); ?>
                    </div>
                    <div class="text-sub">
                        Join our Mailing List for FREE offers and tips on how to grow your studio with Twinkle Bear
                    </div>
                <?php endif; ?>
            </h2>

            <?php echo $pageModel->content; ?>
        </div>
    </div>
</div>