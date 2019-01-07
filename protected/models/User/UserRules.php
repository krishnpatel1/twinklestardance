<?php

Yii::import('application.models.User._base.BaseUserRules');

class UserRules extends BaseUserRules
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}