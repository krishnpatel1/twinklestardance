<?php

Yii::import('application.models._base.BaseConfigurations');

class Configurations extends BaseConfigurations {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getValue($attribute = '') {
        $oModel = Configurations::model()->findbyPk(1);
        return ($oModel) ? $oModel->$attribute : '';
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'paypal_partner' => Yii::t('app', 'Paypal Partner'),
            'paypal_merchant_login' => Yii::t('app', 'Paypal Merchant Login'),
            'paypal_password' => Yii::t('app', 'Paypal Password'),
            'paypal_payment_mode' => Yii::t('app', 'Paypal Payment Mode'),
            'facebook_appid' => Yii::t('app', 'Facebook App ID'),
            'facebook_secret' => Yii::t('app', 'Facebook Secret'),
            'status' => Yii::t('app', 'Status'),
            'last_updated_at' => Yii::t('app', 'Last Updated At'),
        );
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->setAttribute('last_updated_at', new CDbExpression('NOW()'));
            }
            $this->setAttribute('last_updated_at', new CDbExpression('NOW()'));

            return true;
        } else {
            return false;
        }
    }

}