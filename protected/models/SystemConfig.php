<?php

Yii::import('application.models._base.BaseSystemConfig');

class SystemConfig extends BaseSystemConfig
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getValue($path='',$allFields=0)
	{
		$model = SystemConfig::model();
		$criteria = new CDbCriteria();
		$criteria->condition = "TRIM(LCASE(name)) = TRIM(LCASE('".$path."'))";
		$data = $model->find($criteria);
		if($allFields==0) return $data->value;
		else return $data->attributes;
	}

	public static function getValueIndex($path='', $sep=',', $ind=0, $allFields=0)
	{
		$val = self::getValue($path, $allFields);
		$array = explode($sep, $val);
		if(isset($array[$ind])) return $array[$ind];
		else return false;
	}
}