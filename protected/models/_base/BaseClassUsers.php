<?php

/**
 * This is the model base class for the table "class_users".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ClassUsers".
 *
 * Columns in table "class_users" available as properties of the model,
 * followed by relations of table "class_users" available as properties of the model.
 *
 * @property integer $class_id
 * @property integer $user_id
 *
 * @property Users $user
 * @property Classes $class
 */
abstract class BaseClassUsers extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'class_users';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ClassUsers|ClassUsers', $n);
	}

	public static function representingColumn() {
		return 'class_id';
	}

	public function rules() {
		return array(
			array('class_id, user_id', 'numerical', 'integerOnly'=>true),
			array('class_id, user_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('class_id, user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'class' => array(self::BELONGS_TO, 'Classes', 'class_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'class_id' => null,
			'user_id' => null,
			'user' => null,
			'class' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('class_id', $this->class_id);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}