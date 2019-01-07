<?php

class SecureApplicationForm extends CFormModel {

    public $studio_name;
    public $studio_owner_first_name;
    public $studio_owner_last_name;
    public $email_address;
    public $street_address;
    public $city;
    public $state_province;
    public $zip_postal;
    public $business_phone;
    public $mobile_phone;
    public $social_security_number;
    public $date_of_birth;

    public function rules() {

        return array(
            array('studio_name,studio_owner_first_name,studio_owner_last_name,email_address,street_address,city,state_province,zip_postal,business_phone,social_security_number,date_of_birth', 'required'),
            array('email_address', 'email'),
            //array('business_phone', 'match', 'pattern' => '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/'),
            array('business_phone', 'validPhone'),
        );
    }

    public function validPhone($attribute, $params) {
        //if (!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['SignupForm'][$attribute]) && !preg_match('/^[0-9]{10}$/', $_POST['SignupForm'][$attribute]))
        if (!preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s-]\d{3}[\s-]\d{4}$/', $_POST['SecureApplicationForm'][$attribute]) && !preg_match('/^[0-9]{10}$/', $_POST['SecureApplicationForm'][$attribute]))
            $this->addError($attribute, 'Phone is invalid');
    }

    public function attributeLabels() {
        return array(
            'studio_name' => Yii::t('app', 'Studio Name'),
            'studio_owner_first_name' => Yii::t('app', 'Studio Owner First Name'),
            'studio_owner_last_name' => Yii::t('app', 'Studio Owner Last Name'),
            'email_address' => Yii::t('app', 'Email Address'),
            'street_address' => Yii::t('app', 'Street Address'),
            'city' => Yii::t('app', 'City'),
            'state_province' => Yii::t('app', 'State Province'),
            'zip_postal' => Yii::t('app', 'Zip/Postal'),
            'business_phone' => Yii::t('app', 'Business Phone'),
            'mobile_phone' => Yii::t('app', 'Mobile'),
            'social_security_number' => Yii::t('app', 'Social Security Number'),
            'date_of_birth' => Yii::t('app', 'Date of Birth'),
            'cc_number' => Yii::t('app', 'Credit Card Number'),
            'cc_expiry_month' => Yii::t('app', 'Credit Card Expiry Date'),
        );
    }

}

