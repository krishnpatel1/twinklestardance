<?php

/**
 * SendNewsletterForm class.
 * SendNewsletterForm is the data structure for keeping 
 */
class SendNewsletterForm extends CFormModel {

    public $subject;
    public $body;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('subject, body', 'required'),
        );
    }
}

