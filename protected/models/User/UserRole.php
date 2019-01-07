<?php

Yii::import('application.models.User._base.BaseUserRole');

class UserRole extends BaseUserRole {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* function getRoleNameAsPerId() 
     * for get role name as per role id.	 
     * @param	int $snRoleId 
     * return	string
     */

    public static function getRoleNameAsPerId($snRoleId) {
        $oModel = UserRole::model()->find(array(
            'condition' => 'id=:roleId',
            'params' => array(':roleId' => $snRoleId)
        ));

        return ($oModel) ? $oModel->role_type : 'guest';
    }
    /* function getRoleIdAsPerType() 
     * for get role name as per role id.	 
     * @param	string $ssRoleType 
     * return	int
     */

    public static function getRoleIdAsPerType($ssRoleType) {
        $oModel = UserRole::model()->find(array(
            'condition' => 'role_type=:roleName',
            'params' => array(':roleName' => $ssRoleType)
        ));

        return ($oModel) ? $oModel->id : '';
    }

}