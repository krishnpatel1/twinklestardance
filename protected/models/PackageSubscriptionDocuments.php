<?php

Yii::import('application.models._base.BasePackageSubscriptionDocuments');

class PackageSubscriptionDocuments extends BasePackageSubscriptionDocuments {

    public $document_url;
    public $subscription_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('subscription_id, document_title', 'required', 'on' => 'add_document'),
            array('subscription_id', 'safe', 'on' => 'edit_document'),
            array('document_name', 'file',
                'types' => 'pdf',
                'maxSize' => 1024 * 1024 * 50, // 50MB
                //'tooLarge' => 'The file was larger than 50MB. Please upload a smaller file.',
                'allowEmpty' => true,
            ),
            array('document_name,document_url', 'validateDocSelection', 'on' => 'add_document'),
        );
    }

    public function attributeLabels() {
        return array(
            'subscription_id' => Yii::t('app', 'Subscription:'),
            'document_title' => Yii::t('app', 'Name:'),
            'document_name' => Yii::t('app', 'Upload Document:'),
            'document_url' => Yii::t('app', 'Document URL:'),
        );
    }

    /**
     * Validate if entry made during subscription
     */
    public function validateDocSelection($attribute, $params) {
        if ($_FILES['PackageSubscriptionDocuments']['name']['document_name'] == '' && $_POST['PackageSubscriptionDocuments']['document_url'] == '')
            $this->addError('document_name', 'Please select a file or provide external url !!!');
        if (!strstr($_POST['PackageSubscriptionDocuments']['document_url'], 'http') && $_POST['PackageSubscriptionDocuments']['document_url'] != '')
            $this->addError('document_url', 'Please provide valid external url !!!');
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->setAttribute('created_at', new CDbExpression('NOW()'));
            }
            $this->setAttribute('updated_at', new CDbExpression('NOW()'));
            return true;
        } else {
            return false;
        }
    }

}
