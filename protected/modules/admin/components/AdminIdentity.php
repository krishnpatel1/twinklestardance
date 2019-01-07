<?php

/**
 * CustomerIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends UserIdentity {

    private $_id;

    const ERROR_NONE = 0;
    const ERROR_EMAIL_INVALID = 3;
    const ERROR_STATUS_NOTACTIV = 4;
    const ERROR_STATUS_BAN = 5;
    const ERROR_PASSWORD_INVALID = 6;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the email and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public $email;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->email = $username;
        $this->password = $password;
    }

    public function authenticate() {
        
        $email = $this->email;

        $criteria = new CDbCriteria();
        $criteria->select = "t.*, CONCAT_WS(' ', t.first_name, t.last_name) AS fullname";
        $criteria->alias = 't';
        $criteria->condition = '(t.username = :username OR t.email = :email)';
        $criteria->params = array(":username" => $this->username, ":email" => $this->username);
        $admin = Users::model()->find($criteria);
        if ($admin === null) {
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        } else if($admin->status!=1) {
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        }   
        else if (Yii::app()->getModule('admin')->encrypting($this->password) !== $admin->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $admin->id;
            $this->email = $admin->email;
            $this->username = $admin->email;
            $this->errorCode = self::ERROR_NONE;
            Yii::app()->admin->setId($this->_id);
            Yii::app()->admin->name = UserRole::getRoleNameAsPerId($admin->role_id);

            $adminData = $admin->attributes;
            Yii::app()->admin->setState('admin', $adminData);
        }
        return !$this->errorCode;
    }

    public function fbAuthenticate() {        
        $email = $this->username;

        $criteria = new CDbCriteria();
        $criteria->select = "t.*, CONCAT_WS(' ', t.first_name, t.last_name) AS fullname";
        $criteria->alias = 't';
        $criteria->condition = 't.username = :username OR t.email = :email';
        $criteria->params = array(":username" => $this->username, ":email" => $this->username);
        $admin = Users::model()->find($criteria);
        if ($admin === null) {
            $this->errorCode = self::ERROR_EMAIL_INVALID;        
        } else {            
            $this->_id = $admin->id;
            $this->email = $admin->email;
            $this->username = $admin->email;
            $this->errorCode = self::ERROR_NONE;
            Yii::app()->admin->setId($this->_id);
            Yii::app()->admin->name = UserRole::getRoleNameAsPerId($admin->role_id);

            $adminData = $admin->attributes;
            Yii::app()->admin->setState('admin', $adminData);
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}