<?php

class PayFlowPaymentForm extends CFormModel {

    public $payment_method;
    public $card_number;
    public $expiration_month;
    public $expiration_year;    
    public $account_number;
    public $routing_number;
    public $account_type;
    public $first_name;
    public $last_name;
    public $email;
    public $address_1;
    public $city;
    public $state_code;
    public $zip;
    public $country_code;
    public $phone_number;

    public function rules() {

        return array(
            array('first_name,last_name,email,address_1,city,state_code,zip,phone_number', 'required'),
            array('email', 'email'),
            array('card_number,expiration_month,expiration_year', 'required', 'on' => 'full_payment'),
            array('card_number,expiration_month,expiration_year, routing_number, account_number, account_type', 'safe', 'on' => 'recurring_payment'),
            array('payment_method', 'validData', 'on' => 'recurring_payment'),
            array('card_number,routing_number,account_number,expiration_month,expiration_year, zip', 'numerical'),
        );
    }

    /**
     * Validate if entry made during subscription
     */
    public function validData($attribute, $params) {
        //p($_POST['PayFlowPaymentForm'][$attribute]);
        if ($_POST['PayFlowPaymentForm'][$attribute] == 'A') {
            if ($_POST['PayFlowPaymentForm']["routing_number"] == "")
                $this->addError('routing_number', 'Routing Number cannot be blank.');
            if ($_POST['PayFlowPaymentForm']["account_number"] == "")
                $this->addError('account_number', 'Account Number cannot be blank.');            
        }
        if ($_POST['PayFlowPaymentForm'][$attribute] == 'C') {
            if ($_POST['PayFlowPaymentForm']["card_number"] == "")
                $this->addError('card_number', 'Credit Card Number cannot be blank.');
            if ($_POST['PayFlowPaymentForm']["expiration_month"] == "")
                $this->addError('expiration_month', 'Month cannot be blank.');
            if ($_POST['PayFlowPaymentForm']["expiration_year"] == "")
                $this->addError('expiration_year', 'Year cannot be blank');
        }
    }

    public function attributeLabels() {
        return array(
            'card_number' => Yii::t('app', 'Credit Card Number'),
            'expiration_month' => Yii::t('app', 'Month'),
            'expiration_year' => Yii::t('app', 'Year'),            
            'account_number' => Yii::t('app', 'Account Number'),
            'routing_number' => Yii::t('app', 'Routing Number'),
            'account_type' => Yii::t('app', 'Account Type'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'address_1' => Yii::t('app', 'Street Address'),
            'city' => Yii::t('app', 'City'),
            'state_code' => Yii::t('app', 'State / Province'),
            'zip' => Yii::t('app', 'Zip / Postal Code'),
            'country_code' => Yii::t('app', 'Country'),
        );
    }

}

