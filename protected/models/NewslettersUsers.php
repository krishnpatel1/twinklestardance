<?php

Yii::import('application.models._base.BaseNewslettersUsers');

class NewslettersUsers extends BaseNewslettersUsers {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'checkUnique'),
            array('user_id, is_subscribed', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 255),
            array('created_at, updated_at', 'safe'),
            array('user_id, email, is_subscribed, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, user_id, email, is_subscribed, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    public function checkUnique($attribute, $params) {
        if ($attribute == "email") {
            $omUser = NewslettersUsers::model()->findByAttributes(array("email" => $_POST['NewslettersUsers'][$attribute]));
            if ($omUser)
                $this->addError($attribute, 'Email already exists!');
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->setAttribute('created_at', new CDbExpression('NOW()'));
            }
            $this->setAttribute('updated_at', new CDbExpression('NOW()'));
            return true;
        } else {
            return false;
        }
    }

}