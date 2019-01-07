<div class="inner_page">
    <div class="fix">
        <div class="one_subscription subscription">
            <h2>Associate with Class</h2>
            <div class="clear"></div>
            <div class="flash_message">
                <?php
                foreach (Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
                ?>
            </div>
        </div>
    </div>
</div><div>