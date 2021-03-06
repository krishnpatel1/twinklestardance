<?php

/**
 * This is the model base class for the table "package_subscription_documents".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PackageSubscriptionDocuments".
 *
 * Columns in table "package_subscription_documents" available as properties of the model,
 * followed by relations of table "package_subscription_documents" available as properties of the model.
 *
 * @property integer $id
 * @property string $document_title
 * @property string $document_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ClassDocuments[] $classDocuments
 * @property PackageSubscriptionDocumentsTransaction[] $packageSubscriptionDocumentsTransactions
 */
abstract class BasePackageSubscriptionAllDocuments extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'package_subscription_documents';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'PackageSubscriptionAllDocuments|PackageSubscriptionAllDocuments', $n);
	}

	public static function representingColumn() {
		return 'document_title';
	}

	public function rules() {
		return array(
			array('document_title, document_name', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			array('document_title, document_name, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, document_title, document_name, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'classDocuments' => array(self::HAS_MANY, 'ClassDocuments', 'document_id'),
			'packageSubscriptionDocumentsTransactions' => array(self::HAS_MANY, 'PackageSubscriptionDocumentsTransaction', 'document_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'document_title' => Yii::t('app', 'Document Title'),
			'document_name' => Yii::t('app', 'Document Name'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'classDocuments' => null,
			'packageSubscriptionDocumentsTransactions' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('document_title', $this->document_title, true);
		$criteria->compare('document_name', $this->document_name, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}