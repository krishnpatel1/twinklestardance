<?php

Yii::import('application.models._base.BaseModule');

class Module extends BaseModule
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}