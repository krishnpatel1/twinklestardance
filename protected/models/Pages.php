<?php

Yii::import('application.models._base.BasePages');

class Pages extends BasePages {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        $rules = parent::rules();
        $rules[] = array('custom_url_key', 'required');
        $rules[] = array('custom_url_key', 'application.validators.GUrlValidator', 'uriPattern' => '/^(([A-Z0-9][A-Z0-9_-]*)+)/i', 'customUrlKeyOnly' => true);

        return $rules;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->setAttribute('created_user_id', Yii::app()->admin->id);
                $this->setAttribute('created_at', new CDbExpression('NOW()'));
            }
            $this->setAttribute('updated_user_id', Yii::app()->admin->id);
            $this->setAttribute('updated_at', new CDbExpression('NOW()'));

            //p($this->attributes);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels() {

        $attr = parent::attributeLabels();
        $attr['createdUser'] = Yii::t('app', 'Created By');
        $attr['updatedUser'] = Yii::t('app', 'Updated By');
        return $attr;
    }

    public function passwordStrength($attribute, $params) {
        if ($params['strength'] === self::WEAK)
            $pattern = '/^(?=.*[a-zA-Z0-9]).{5,}$/';
        elseif ($params['strength'] === self::STRONG)
            $pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';

        if (!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'your password is not strong enough!');
    }

}