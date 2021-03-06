<?php

/**
 * This is the model base class for the table "class_documents".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ClassDocuments".
 *
 * Columns in table "class_documents" available as properties of the model,
 * followed by relations of table "class_documents" available as properties of the model.
 *
 * @property integer $id
 * @property integer $class_id
 * @property integer $document_id
 *
 * @property Classes $class
 * @property PackageSubscriptionDocuments $document
 */
abstract class BaseClassDocuments extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'class_documents';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ClassDocuments|ClassDocuments', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('class_id, document_id', 'numerical', 'integerOnly'=>true),
			array('class_id, document_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, class_id, document_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'class' => array(self::BELONGS_TO, 'Classes', 'class_id'),
			'document' => array(self::BELONGS_TO, 'PackageSubscriptionDocuments', 'document_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'class_id' => null,
			'document_id' => null,
			'class' => null,
			'document' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('class_id', $this->class_id);
		$criteria->compare('document_id', $this->document_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}