<div style="height:50px;"></div>
<div class="form">
    <div class="newsletter">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-letter-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false
            )
        ));
        ?>
        <div class="row"><h2 style="font-style: italic;">Join Our Mailing List</h2></div>
        <div class="row"><p>Receive free offers and learn how a recreational dance program will help your studio to grow.</p></div>
        <div class="row topmargin">
            <?php echo $form->textField($model, 'email', array('autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row topmargin">
            <?php echo CHtml::submitButton('Sign Up'); ?>
        </div>
        <?php $this->endWidget(); ?>        
    </div>
</div>
<script type="text/javascript">
    $('#NewslettersUsers_email').each(function() {
        var default_value = 'Email';
        $(this).focus(function() {
            if (this.value == default_value) {
                this.value = '';
            }
        });
        $(this).blur(function() {
            if (this.value == '') {
                this.value = default_value;
            }
        });
    });
</script>