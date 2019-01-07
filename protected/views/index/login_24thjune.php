<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<div class="inner_page">
    <div class="fix">
        <div class="login_signup_page">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',                
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,                    
                ),
                'htmlOptions' => array('class' => 'formLoginSignUp')
            ));
            //echo $form->errorSummary($model);
            ?>
            <div class="login_signup ieSupport">
                <h2>Please Login</h2>
                <div class="block">
                    <form method="">
                        <div class="row">                                                        
                            <?php echo $form->textField($model, 'username'); ?>
                            <?php echo $form->error($model, 'username'); ?>
                        </div>
                        <div class="row">                            
                            <?php echo $form->passwordField($model, 'password', array('autocomplete' => 'off')); ?>
                            <?php echo CHtml::textField('password-clear','Password',array('id' => 'password-clear', 'autocomplete' => 'off')); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                        <div class="forgot">Forgot login information? <?php echo CHtml::link(Yii::t('app','Click Here'),array('/index/forgotPassword'));?>.</div>
                        <div class="row rememberMe">
                            <?php echo $form->checkBox($model, 'rememberMe'); ?>
                            <?php echo $form->label($model, 'rememberMe'); ?>
                            <?php echo $form->error($model, 'rememberMe'); ?>   
                        </div>
                        <div class="row">
                            <?php echo CHtml::submitButton('Login'); ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'signup-form',                
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true                    
                ),
                'htmlOptions' => array('class' => 'formLoginSignUp')
            ));
            //echo $form->errorSummary($smodel);
            ?>
            <div class="login_signup signup ieSupport">
                <h2>Not a member? Sign up!</h2>
                <div class="block">
                    <form method="">
                        <div class="row">                                                        
                            <?php echo $form->textField($smodel, 'name'); ?>
                            <?php echo $form->error($smodel, 'name'); ?>
                        </div>
                        <div class="row">                                                        
                            <?php echo $form->textField($smodel, 'phone'); ?>
                            <?php echo $form->error($smodel, 'phone'); ?>
                        </div>
                        <?php if(!isset($_REQUEST['isDancer'])):?>
                        <div class="row">                                                        
                            <?php echo $form->textField($smodel, 'studio_name'); ?>
                            <?php echo $form->error($smodel, 'studio_name'); ?>
                        </div>
                        <?php endif;?>
                        <div class="row">                                                        
                            <?php echo $form->textField($smodel, 'email'); ?>
                            <?php echo $form->error($smodel, 'email'); ?>
                        </div>
                        <div class="row">
                            <?php echo CHtml::textField('spassword','Password', array('id' => 'spassword', 'value' => 'Password', 'autocomplete' => 'off')); ?>
                            <?php echo $form->passwordField($smodel, 'password', array('autocomplete' => 'off')); ?>
                            <?php echo $form->error($smodel, 'password'); ?>
                        </div>
                        <div class="row">                                                        
                            <?php echo CHtml::textField('sconfirmpassword','Confirm Password' ,array('id' => 'sconfirmpassword', 'value' => 'Confirm Password', 'autocomplete' => 'off')); ?>
                            <?php echo $form->passwordField($smodel, 'confirmpassword', array('autocomplete' => 'off')); ?>
                            <?php echo $form->error($smodel, 'confirmpassword'); ?>
                        </div>
                        <div class="row country">                                                                                    
                            <?php echo $form->labelEx($smodel, 'country_id'); ?>
                            <?php echo $form->dropDownList($smodel, 'country_id', Common::getListCountry(),array('prompt'=>'Select country','class'=>'styled')); ?>
                            <?php echo $form->error($smodel, 'country_id'); ?>
                        </div>
                        <div class="row"><?php echo CHtml::submitButton('Sign Up'); ?></div>
                    </form>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
        </div>
    </div>
</div>

<style>
    #password-clear {
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#password-clear').show();
        $('#LoginForm_password').hide();
 
        $('#password-clear').focus(function() {
            $('#password-clear').hide();
            $('#LoginForm_password').show();
            $('#LoginForm_password').focus();                        
        });
        $('#LoginForm_password').blur(function() {
            if($('#LoginForm_password').val() == "") {
                $('#password-clear').show();
                $('#LoginForm_password').hide();
            }
        });        
        $('#LoginForm_username').each(function() {
            var default_value = 'Username';
            $(this).focus(function() {
                if(this.value == default_value) {
                    this.value = '';
                }
            });
            $(this).blur(function() {
                if(this.value == '') {
                    this.value = default_value;
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
 
        $('#spassword').show();
        $('#sconfirmpassword').show();
        $('#SignupForm_password').hide();
        $('#SignupForm_confirmpassword').hide();
 
        $('#spassword').focus(function() {
            $('#spassword').hide();
            $('#SignupForm_password').show();
            $('#SignupForm_password').focus();
        });
        $('#sconfirmpassword').focus(function() {
            $('#sconfirmpassword').hide();
            $('#SignupForm_confirmpassword').show();
            $('#SignupForm_confirmpassword').focus();
        });
        $('#SignupForm_password').blur(function() {
            if($('#SignupForm_password').val() == '') {
                $('#SignupForm_password').hide();
                $('#spassword').show();                
            }
        }); 
        $('#SignupForm_confirmpassword').blur(function() {
            if($('#SignupForm_confirmpassword').val() == '') {
                $('#SignupForm_confirmpassword').hide();
                $('#sconfirmpassword').show();                
            }
        }); 
        $('#SignupForm_name').each(function() {
            var default_value = 'Name';
            $(this).focus(function() {
                if(this.value == default_value) {
                    this.value = '';
                }
            });
            $(this).blur(function() {
                if(this.value == '') {
                    this.value = default_value;
                }
            });
        });
        $('#SignupForm_phone').each(function() {
            var default_value = 'Phone Number';
            $(this).focus(function() {
                if(this.value == default_value) {
                    this.value = '';
                }
            });
            $(this).blur(function() {
                if(this.value == '') {
                    this.value = default_value;
                }
            });
        });
        $('#SignupForm_studio_name').each(function() {
            var default_value = 'Studio Name';
            $(this).focus(function() {
                if(this.value == default_value) {
                    this.value = '';
                }
            });
            $(this).blur(function() {
                if(this.value == '') {
                    this.value = default_value;
                }
            });
        }); 
        $('#SignupForm_email').each(function() {
            var default_value = 'Email';
            $(this).focus(function() {
                if(this.value == default_value) {
                    this.value = '';
                }
            });
            $(this).blur(function() {
                if(this.value == '') {
                    this.value = default_value;
                }
            });
        }); 
    });
</script>