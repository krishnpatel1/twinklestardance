<?php

/**
 * This is the model base class for the table "mst_pages".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Pages".
 *
 * Columns in table "mst_pages" available as properties of the model,
 * followed by relations of table "mst_pages" available as properties of the model.
 *
 * @property string $id
 * @property string $title
 * @property string $custom_url_key
 * @property string $content
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property integer $pos
 * @property integer $created_user_id
 * @property integer $updated_user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 *
 * @property Users $createdUser
 * @property Users $updatedUser
 */
abstract class BasePages extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mst_pages';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Pages|Pages', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('title, content', 'required'),
			array('pos, created_user_id, updated_user_id, status', 'numerical', 'integerOnly'=>true),
			array('title, custom_url_key', 'length', 'max'=>255),
			array('meta_title, meta_keyword, meta_description, created_at, updated_at', 'safe'),
			array('custom_url_key, meta_title, meta_keyword, meta_description, pos, created_user_id, updated_user_id, created_at, updated_at, status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, title, custom_url_key, content, meta_title, meta_keyword, meta_description, pos, created_user_id, updated_user_id, created_at, updated_at, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'createdUser' => array(self::BELONGS_TO, 'Users', 'created_user_id'),
			'updatedUser' => array(self::BELONGS_TO, 'Users', 'updated_user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'title' => Yii::t('app', 'Title'),
			'custom_url_key' => Yii::t('app', 'Custom Url Key'),
			'content' => Yii::t('app', 'Content'),
			'meta_title' => Yii::t('app', 'Meta Title'),
			'meta_keyword' => Yii::t('app', 'Meta Keyword'),
			'meta_description' => Yii::t('app', 'Meta Description'),
			'pos' => Yii::t('app', 'Pos'),
			'created_user_id' => null,
			'updated_user_id' => null,
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'status' => Yii::t('app', 'Status'),
			'createdUser' => null,
			'updatedUser' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('custom_url_key', $this->custom_url_key, true);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('meta_title', $this->meta_title, true);
		$criteria->compare('meta_keyword', $this->meta_keyword, true);
		$criteria->compare('meta_description', $this->meta_description, true);
		$criteria->compare('pos', $this->pos);
		$criteria->compare('created_user_id', $this->created_user_id);
		$criteria->compare('updated_user_id', $this->updated_user_id);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}