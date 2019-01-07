<?php

class MakePaymentForm extends CFormModel {

    public $payment_views = 1;  // 1-Monthly, 2-Yearly
    public $payment_method;
    public $payment_amount;
    public $is_agree;
    public $payment_option = 1;

    public function rules() {

        return array(
            array('payment_amount,payment_method', 'required'),
            array('payment_amount', 'numerical'),
            array('is_agree', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'payment_amount' => Yii::t('app', 'Payment Amount'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'is_agree' => Yii::t('app', 'Agree to Terms')
        );
    }

}

