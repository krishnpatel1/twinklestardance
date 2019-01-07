<?php
class ChangePasswordForm extends CFormModel
{
	public $password;
	public $password_repeat;
	public $salt;
	public $id;

	public function rules(){

		//$message ="<span class='ui-icon ui-icon-alert'></span><span class='app'>". Yii::t('app','{attribute} cannot be blank.')."</span>";
		return array(
			array('password', 'required'),
			array('password', 'length', 'max'=>128, 'min' =>''),
			array('password_repeat', 'required'),
			array('password', 'compare','compareAttribute'=>'password_repeat',),
		);
	}

	public function attributeLabels() {
		return array(
			'password' => Yii::t('app', 'New Password'),
			'password_repeat' => Yii::t('app', 'Repeat New Password'),
		);
	}

}


