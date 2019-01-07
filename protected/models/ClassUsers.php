<?php

Yii::import('application.models._base.BaseClassUsers');

class ClassUsers extends BaseClassUsers {

    public $first_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addUsers() 
     * for add/remove selected/unselected user ids from class id
     * @param  int     $snClassId
     * @param  array   $anUserIds
     * return  boolean
     */
    public static function addUsers($snClassId, $anUserIds, $ssUserType) {
        foreach ($anUserIds as $snUserId) {
            // FOR CHECK USER ALREADY EXISTS INTO CLASS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'cu';
            $oCriteria->condition = 'cu.class_id=:classID AND cu.user_id=:userID';
            $oCriteria->params = array(':classID' => $snClassId, ':userID' => $snUserId);
            $omRecordExists = ClassUsers::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD USER UNDER CLASS //
                $oModel = new ClassUsers();
                $oModel->class_id = $snClassId;
                $oModel->user_id = $snUserId;
                $oModel->save();
            }
        }
        // REMOVE USERS FROM CLASS WHICH ARE UNSELECTED //
        self::removeUnselectedIds($snClassId, $anUserIds, $ssUserType);
        return true;
    }

    /** function removeUnselectedIds() 
     * for remove user ids which are unselected from class
     * @param  int     $snClassId
     * @param  array   $anUserIds
     * return  boolean
     */
    public static function removeUnselectedIds($snClassId, $anUserIds, $ssUserType) {

        // FOR CHECK USER ALREADY EXISTS INTO CLASS OR NOT //
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'cu';
        $oCriteria->condition = 'cu.class_id=:classID';
        $oCriteria->params = array(':classID' => $snClassId);
        $omResults = ClassUsers::model()->findAll($oCriteria);

        if ($omResults) {
            foreach ($omResults as $omData) {
                if (!in_array($omData->user_id, $anUserIds) && $omData->user->user_type == $ssUserType) {
                    self::removeClasUsers($omData->class_id, $omData->user_id);
                }
            }
        }
        return true;
    }
    /** function addUsers() 
     * for add/remove selected/unselected user ids from class id
     * @param  int     $snClassId
     * @param  array   $anUserIds
     * return  boolean
     */
    public static function addClasses($snUserId, $anClassIds) {
        foreach ($anClassIds as $snClassId) {
            // FOR CHECK USER ALREADY EXISTS INTO CLASS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'cu';
            $oCriteria->condition = 'cu.class_id=:classID AND cu.user_id=:userID';
            $oCriteria->params = array(':classID' => $snClassId, ':userID' => $snUserId);
            $omRecordExists = ClassUsers::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD USER UNDER CLASS //
                $oModel = new ClassUsers();
                $oModel->class_id = $snClassId;
                $oModel->user_id = $snUserId;
                $oModel->save();
            }
        }
        // REMOVE USERS FROM CLASS WHICH ARE UNSELECTED //
        self::removeUnselectedClassIds($snUserId, $anClassIds);
        return true;
    }
    
    /** function removeUnselectedSubscriptionIds() 
     * for remove subscription which are unselected from the package
     * @param  int     $snPackageId
     * @param  array   $anSubscriptionIds
     * return  boolean
     */
    public static function removeUnselectedClassIds($snUserId, $anClassIds) {
        $ssCriteria = (count($anClassIds) > 0) ? 'class_id NOT IN(' . implode(',', $anClassIds) . ') AND user_id = ' . $snUserId : 'user_id = ' . $snUserId;
        ClassUsers::model()->deleteAll($ssCriteria);
        return true;
    }

    /** function removeClasUsers() 
     * for remove row from class user table
     * @param  int     $snClassId
     * @param  int     $snUserId
     * return  boolean
     */
    public static function removeClasUsers($snClassId, $snUserId) {
        $bDeleteStatus = ClassUsers::model()->deleteAll('class_id = :classID AND user_id =:userID', array('classID' => $snClassId, 'userID' => $snUserId));
        return $bDeleteStatus;
    }

    /** function getClassUsers() 
     * for get all class users
     * @param  int     $snClassId
     * return  object
     */
    public static function getClassUsers($snClassId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->condition = 'class_id=:classID';
        $oCriteria->params = array(':classID' => $snClassId);

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResults = self::model()->findAll();

        return $omResults;
    }

    /** function getUserClasses()
     * for get all classes user associate with.
     * @param  int     $snUserId
     * return  object
     */
    public static function getUserClasses($snUserId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->condition = 'user_id=:userID';
        $oCriteria->params = array(':userID' => $snUserId);

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResults = self::model()->findAll();

        return $omResults;
    }

}