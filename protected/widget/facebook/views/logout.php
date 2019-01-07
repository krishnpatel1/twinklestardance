<?php if(Yii::app()->user->isGuest): ?>
    <div id="<?php
    echo $this->logoutButtonId; ?>"><?php echo $this->facebookButtonTitle; ?></div>
<?php endif; ?>