<?php

/**
 * SignupForm class.
 * SignupForm is the data structure for keeping
 * user signup form data. It is used by the 'signup' action of 'SiteController'.
 */
class SignupForm extends CFormModel {

    public $name = 'Name';
    public $phone = 'Phone Number';
    public $studio_name = 'Studio Name';
    public $email = 'Email';
    public $password;
    public $confirmpassword;
    public $country_id;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('name, phone, studio_name, email, password, confirmpassword', 'required'),
            array('name,phone,email', 'validateentry'),
            //array('phone', 'match', 'pattern'=>'/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/'),
            array('phone', 'validPhone'),
            array('studio_name', 'validateentry', 'on' => 'studio'),
            array('studio_name', 'safe', 'on' => 'dancer'),
            array('email', 'email'),
            array('email', 'checkUnique'),
            array('country_id', 'safe'),
            array('password', 'compare', 'compareAttribute' => 'confirmpassword')
        );
    }

    public function validPhone($attribute, $params) {
        //if (!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['SignupForm'][$attribute]) && !preg_match('/^[0-9]{10}$/', $_POST['SignupForm'][$attribute]))
        if (!preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s-]\d{3}[\s-]\d{4}$/', $_POST['SignupForm'][$attribute]) && !preg_match('/^[0-9]{10}$/', $_POST['SignupForm'][$attribute]))
            $this->addError($attribute, 'Phone is invalid');
    }

    public function attributeLabels() {
        return array(
            'country_id' => Yii::t('app', 'Country')
        );
    }

    /**
     * Validate if entry made during subscription
     */
    public function validateentry($attribute, $params) {
        if ($_POST['SignupForm'][$attribute] == 'Name')
            $this->addError($attribute, 'Name not specified');
        if ($_POST['SignupForm'][$attribute] == 'Phone Number')
            $this->addError($attribute, 'Phone Number not specified');
        if ($_POST['SignupForm'][$attribute] == 'Studio Name')
            $this->addError($attribute, 'Studio Name not specified');
        if ($_POST['SignupForm'][$attribute] == 'Email')
            $this->addError($attribute, 'Email not specified');
    }

    public function checkUnique($attribute, $params) {
        if ($attribute == "email") {
            $omUser = Users::model()->findByAttributes(array("email" => $_POST['SignupForm'][$attribute]));
            if ($omUser)
                $this->addError($attribute, 'Email already exists');
        }
    }

}
