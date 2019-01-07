<?php

class CreditCardForm extends CFormModel {

    public $card_type;
    public $card_number;
    public $expiration_month;
    public $expiration_year;
    public $cvv;
    public $firstname;
    public $lastname;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zipcode;
    public $country;

    public function rules() {

        return array(
            array('card_type,card_number,cvv,expiration_month,expiration_year', 'required'),
            array('card_number,cvv,expiration_month,expiration_year', 'numerical'),
        );
    }

    public function attributeLabels() {
        return array(
            'card_type' => Yii::t('app', 'Card Type'),
            'card_number' => Yii::t('app', 'Card Number'),
            'expiration_month' => Yii::t('app', 'Expiry Month'),
            'expiration_year' => Yii::t('app', 'Expiry Year'),
            'firstname' => Yii::t('app', 'First Name'),
            'lastname' => Yii::t('app', 'Last Name'),
            'address1' => Yii::t('app', 'Street 1'),
            'address2' => Yii::t('app', 'Street 2'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State / Province'),
            'zipcode' => Yii::t('app', 'Zip / Postal Code'),
            'country' => Yii::t('app', 'Country'),
        );
    }

}

