<div class="inner_page">
    <div class="fix">
        <div class="one_subscription monthly_application_form">
            <h2>Monthly Payment Application Form</h2>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'monthly-payment-application-form',
                'enableAjaxValidation' => false,
            ));
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'studio_name'); ?>
                <?php echo $form->textField($oModel, 'studio_name', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'studio_name'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'studio_owner_first_name'); ?>
                <?php echo $form->textField($oModel, 'studio_owner_first_name', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'studio_owner_first_name'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'studio_owner_last_name'); ?>
                <?php echo $form->textField($oModel, 'studio_owner_last_name', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'studio_owner_last_name'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'email_address'); ?>
                <?php echo $form->textField($oModel, 'email_address', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'email_address'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'street_address'); ?>
                <?php echo $form->textField($oModel, 'street_address', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'street_address'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'city'); ?>
                <?php echo $form->textField($oModel, 'city', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'city'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'state_province'); ?>
                <?php echo $form->dropDownList($oModel, 'state_province', $amStates, array('prompt' => 'Select', 'autocomplete' => 'off', 'class' => 'ddlSelect')); ?>
                <?php echo $form->error($oModel, 'state_province'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'zip_postal'); ?>
                <?php echo $form->textField($oModel, 'zip_postal', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'zip_postal'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'business_phone'); ?>
                <?php echo $form->textField($oModel, 'business_phone', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'business_phone'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'mobile_phone'); ?>
                <?php echo $form->textField($oModel, 'mobile_phone', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'mobile_phone'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'social_security_number'); ?>
                <?php echo $form->textField($oModel, 'social_security_number', array('autocomplete' => 'off')); ?>
                <?php echo $form->error($oModel, 'social_security_number'); ?>
            </div>
            <div class="row">  
                <?php echo $form->labelEx($oModel, 'date_of_birth'); ?>
                <?php
                $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $oModel,
                    'attribute' => 'date_of_birth',
                    'value' => $oModel->date_of_birth,
                    'options' => array(
                        'showAnim' => 'fold',
                        'showTimepicker' => false,
                        'dateFormat' => 'mm/dd/yy',
                        'changeMonth' => true,
                        'changeYear' => true,
                        'showButtonPanel' => true,
                        'yearRange' => '1950:2030',
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'price'
                    ),
                    'htmlOptions' => array(
                        'class' => 'price'
                    ),
                ));
                ?>
                <?php echo $form->error($oModel, 'date_of_birth'); ?>
            </div>                    
            <div class="row buttrow">
            	<?php echo '<p>By clicking on the "Submit/Apply" button below I am providing written consent for Twinkle Star Dance under the Fair Credit Reporting Act authorizing Twinkle Star Dance to obtain my credit report.</p></br></br>'; ?>
                <?php echo CHtml::submitButton('Submit/Apply'); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

