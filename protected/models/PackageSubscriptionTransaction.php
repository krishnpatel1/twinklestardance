<?php

Yii::import('application.models._base.BasePackageSubscriptionTransaction');

class PackageSubscriptionTransaction extends BasePackageSubscriptionTransaction {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function saveSubscriptionsIds() 
     * for get subscription as per package.
     * @param  int     $snPackageId
     * @param  array   $anSubscriptions
     * return  boolean 
     */
    public static function saveSubscriptionsIds($snPackageId, $anSubscriptions, $updated = 0) {
        if (count($anSubscriptions) > 0) {
            foreach ($anSubscriptions as $snSubscriptionId) {
                $oCriteria = new CDbCriteria;
                $oCriteria->alias = 'pst';
                $oCriteria->condition = 'pst.package_id=:packageId AND pst.subscription_id=:subscriptionId';
                $oCriteria->params = array(':packageId' => $snPackageId, ':subscriptionId' => $snSubscriptionId);
                $omRecordExists = PackageSubscriptionTransaction::model()->find($oCriteria);

                if (!$omRecordExists) {
                    $oModel = new PackageSubscriptionTransaction();
                    $oModel->package_id = $snPackageId;
                    $oModel->subscription_id = $snSubscriptionId;
                    $oModel->additional_status = $updated;
                    $oModel->save();
                }
            }
        }
        // REMOVE VIDEOS FROM SUBSCRIPOTION WHICH ARE UNSELECTED //
        self::removeUnselectedSubscriptionIds($snPackageId, $anSubscriptions);

        return true;
    }

    /** function removeUnselectedSubscriptionIds() 
     * for remove subscription which are unselected from the package
     * @param  int     $snPackageId
     * @param  array   $anSubscriptionIds
     * return  boolean
     */
    public static function removeUnselectedSubscriptionIds($snPackageId, $anSubscriptionIds) {
        $ssSubscriptionIdCriteria = (count($anSubscriptionIds) > 0) ? 'subscription_id NOT IN(' . implode(',', $anSubscriptionIds) . ') AND package_id = ' . $snPackageId : 'package_id = ' . $snPackageId;
        PackageSubscriptionTransaction::model()->deleteAll($ssSubscriptionIdCriteria);
        return true;
    }

    /** function removeSubscriptionFromPackage() 
     * for remove particular subscription from the package
     * @param  int     $snPackageId
     * @param  array   $snSubscriptionId
     * return  boolean
     */
    public static function removeSubscriptionFromPackage($snPackageId, $snSubscriptionId) {

        $bDeleteStatus = PackageSubscriptionTransaction::model()->deleteAll('package_id = :packageID AND subscription_id =:subscriptionID', array('packageID' => $snPackageId, 'subscriptionID' => $snSubscriptionId));
        return $bDeleteStatus;
    }

    /** function getSubscriptionsAsPerPackage() 
     * for get all subscription id as per package id.
     * @param  int     $snPackageId
     * return  object
     */
    public static function getSubscriptionsAsPerPackage($snPackageId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'pst.*';
        $oCriteria->alias = 'pst';
        $oCriteria->condition = 'pst.package_id = :snPackageID';
        $oCriteria->params = array(':snPackageID' => $snPackageId);

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResultSet = self::model()->findAll();

        return $omResultSet;
    }

}