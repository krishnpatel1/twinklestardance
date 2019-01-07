<?php

/**
 * ForgotPasswordForm class.
 * ForgotPasswordForm is the data structure for keeping
 * user forgot form data. It is used by the 'forgotpassowrd' action of 'IndexController'.
 */
class ForgotPasswordForm extends CFormModel {

    public $email;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('email', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            array('email', 'checkEmailExists'),
        );
    }

    public function checkEmailExists($attribute, $params) {

        $omUser = Users::model()->findByAttributes(array("email" => $_POST['ForgotPasswordForm'][$attribute]));
        if (!$omUser)
            $this->addError($attribute, 'Email does not exists');
    }

}

