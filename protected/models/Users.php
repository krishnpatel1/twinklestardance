<?php

Yii::import('application.models._base.BaseUsers');

class Users extends BaseUsers {

    public $q;
    public $num;
    public $rpassword;
    public $name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('studio_name, email', 'required', 'on' => 'update'),
            array('password, rpassword, first_name, last_name, status', 'safe', 'on' => 'update'),
            array('first_name, last_name, email', 'safe', 'on' => 'search'),
            array('studio_name, first_name, last_name', 'safe', 'on' => 'settings'),
            array('password, rpassword', 'required', 'on' => 'settings'),
            array('first_name, username, email, password', 'required', 'on' => 'add_instructor'),
            array('username, email', 'unique', 'on' => 'add_instructor'),
            array('first_name, username, password, status', 'safe', 'on' => 'edit_instructor'),
            array('email', 'email', 'on' => 'add_instructor'),
            array('email', 'email', 'on' => 'edit_instructor'),
            array('password', 'compare', 'compareAttribute' => 'rpassword', 'on' => 'settings'),
            array('address_1, address_2, city, state_id, zip, other_email, contact_email, phone, first_name, last_name, status', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'studio_name' => Yii::t('app', 'Studio Name'),
            'rpassword' => Yii::t('app', 'Repeat Password'),
            'picture' => Yii::t('app', 'Picture'),
            'email' => Yii::t('app', 'Email'),
            'address_1' => Yii::t('app', 'Street Address'),
            'address_2' => Yii::t('app', 'Other Address'),
            'email' => Yii::t('app', 'Email'),
            'city' => Yii::t('app', 'City'),
            'state_id' => Yii::t('app', 'State/Province'),
            'zip' => Yii::t('app', 'Zip/Postal Code'),
            'phone' => Yii::t('app', 'Phone'),
        );
    }

    public function search() {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = '*,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $ssAddCriteria = ($this->q == '') ? 'user_type = 2' : 'user_type = 2 AND (first_name LIKE :q OR middle_name LIKE :q OR last_name LIKE :q OR studio_name LIKE :q)';
        $oCriteria->condition = $ssAddCriteria;
        $oCriteria->order = "studio_name";
        $oCriteria->params = array(':q' => "%$this->q%");

        return new CActiveDataProvider($this, array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['listPerPageLimit'])
        ));
    }

    /** function getInstructorsOrDancers()
     * for instructor or dancers as per parent id(studio id)
     * @param  int     $snParentId
     * return  object criteria
     */
    public static function getInstructorsOrDancers($snParentId, $ssUserType,$name="",$lastname="",$email="") {

        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'u.*,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 'u';
        $oCriteria->condition = "u.user_type = $ssUserType";
        $oCriteria->order = "num";

        if ($ssUserType == Yii::app()->params['user_type']['instructor']) {
            $oCriteria->addCondition('u.parent_id = :studioID');
            $oCriteria->params = array(':studioID' => $snParentId);
        } else {
            $oCriteria->join = 'INNER JOIN class_users cu ON u.id = cu.user_id';
            $oCriteria->join .= ' INNER JOIN classes c ON cu.class_id = c.id AND c.created_by = :createdBy';
            $oCriteria->params = array(':createdBy' => $snParentId);
        }
        
        if($name!=""){
            $oCriteria->addCondition("first_name LIKE :name");        
            $oCriteria->params[':name'] ="%$name%";
        }
        if($lastname!=""){
            $oCriteria->addCondition("last_name LIKE :lname");        
            $oCriteria->params[':lname'] ="%$lastname%";
        }
        if($email!=""){
            $oCriteria->addCondition("email LIKE :email");        
            $oCriteria->params[':email'] ="%$email%";
        }
        
        $oCriteria->group = 'u.id';

        return $oCriteria;
    }

    /** function getAllInstructorsOrStudents()
     * for instructor or students as per parent id(studio id)
     * @param  int     $snParentId
     * return  object
     */
    public static function getAllInstructorsOrStudents($snParentId, $ssUserType = "") {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'u.id,CONCAT(u.first_name,"",u.last_name) as name';
        $oCriteria->alias = 'u';

        if ($ssUserType == "") {
            $oCriteria->condition = 'u.parent_id = :ssParentID AND (u.user_type = :ssInstructor OR u.user_type = :ssStudents)';
            $oCriteria->params = array(':ssParentID' => $snParentId, ":ssInstructor" => Yii::app()->params['user_type']['instructor'], ":ssStudents" => Yii::app()->params['user_type']['dancer']);
        } else {
            $oCriteria->condition = 'u.parent_id = :ssParentID AND u.user_type = :ssUserType';
            $oCriteria->params = array(':ssParentID' => $snParentId, ":ssUserType" => $ssUserType);
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResults = self::model()->findAll();

        return $omResults;
    }

    /** function addUser()
     * for add studio/dancer record
     * @param  array     $amData
     * return  object
     */
    public static function addUser($amData) {
        $model = new Users;
        $model->first_name = $amData['first_name'];
        $model->username = $amData['username'];
        $model->email = $amData['email'];
        $model->password = $amData['password'];
        $model->role_id = $amData['role_id'];
        $model->user_type = $amData['user_type'];
        $model->studio_name = $amData['studio_name'];
        $model->country_id = $amData['country_id'];
        $model->phone = $amData['phone'];

        $model->save();
        return $model;
    }

    public static function getStudioDetailsRelatedWithInstructor($snInstructorId) {

        $omResult = Users::model()->findByPk($snInstructorId);
        return ($omResult) ? $omResult : false;
    }
    
    public static function removeSelectedItems($itemIds) {
        $bDeleted = Users::model()->deleteAll('id IN(' . implode(',', $itemIds) . ')');
        return $bDeleted;
    }

}