<?php

Yii::import('application.models._base.BaseStateMaster');

class StateMaster extends BaseStateMaster {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getStatesAsPerCountry($snCountryId){
        $oCriteria = new CDbCriteria();
        $oCriteria->condition = "country_id =:snCountryId";
        $oCriteria->params = array(':snCountryId' => $snCountryId);
        
        return self::model()->findAll($oCriteria);
    }

}