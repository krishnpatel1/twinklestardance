<?php

class ContactForm extends CFormModel {

    public $contact_name;
    public $contact_email;
    public $contact_phone;
    public $contact_subject;
    public $contact_message;

    public function rules() {

        return array(
            array('contact_name,contact_email,contact_subject,contact_message', 'required'),
            array('contact_email', 'email'),
            array('contact_phone', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'contact_name' => Yii::t('app', 'Name'),
            'contact_email' => Yii::t('app', 'Email'),
            'contact_subject' => Yii::t('app', 'Subject'),
            'contact_message' => Yii::t('app', 'Message'),
            'contact_phone' => Yii::t('app', 'Phone Number'),            
        );
    }

}

