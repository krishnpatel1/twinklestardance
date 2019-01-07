<?php

Yii::import('application.models._base.BasePackageSubscriptionDocumentsTransaction');

class PackageSubscriptionDocumentsTransaction extends BasePackageSubscriptionDocumentsTransaction {

    public $document_name;
   
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addSubscriptionInDocument() 
     * for add/remove selected/unselected subscription ids from document
     * @param  int     $snDocumentId
     * @param  array   $anSubIds
     * return  boolean
     */
    public static function addSubscriptionInDocument($snDocumentId, $anSubIds) {
        foreach ($anSubIds as $snSubscriptionId) {
            // FOR CHECK VIDEO SUBSCRIPTION ALREADY EXISTS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'psdt';
            $oCriteria->condition = 'psdt.document_id=:snDocumentID AND psdt.subscription_id=:subscriptionID';
            $oCriteria->params = array(':subscriptionID' => $snSubscriptionId, ':snDocumentID' => $snDocumentId);
            $omRecordExists = PackageSubscriptionDocumentsTransaction::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD SUBSCRIPTION UNDER VIDEOS //
                $oModel = new PackageSubscriptionDocumentsTransaction();
                $oModel->subscription_id = $snSubscriptionId;
                $oModel->document_id = $snDocumentId;
                $oModel->save();
            }
        }
        // REMOVE SUBSCRIPTION FROM WHICH ARE UNSELECTED //
        self::removeUnselectedSubscriptions($snDocumentId, $anSubIds);
        return true;
    }

    /** function removeUnselectedSubscriptions() 
     * for remove subscription ids which are unselected from documents
     * @param  int     $snDocumentId
     * @param  array   $anSubIds
     * return  boolean
     */
    public static function removeUnselectedSubscriptions($snDocumentId, $anSubIds) {
        $ssDocsCriteria = (count($anSubIds) > 0) ? 'subscription_id NOT IN(' . implode(',', $anSubIds) . ') AND document_id = ' . $snDocumentId : 'document_id = ' . $snDocumentId;
        PackageSubscriptionDocumentsTransaction::model()->deleteAll($ssDocsCriteria);
        return true;
    }
    
    /** function addDocumentsInSubscription() 
     * for add/remove selected/unselected subscription ids from document
     * @param  int     $snDocumentId
     * @param  array   $anSubIds
     * return  boolean
     */
    public static function addDocumentsInSubscription($snSubscriptionId, $anDocsIds) {
        foreach ($anDocsIds as $snDocumentId) {
            // FOR CHECK VIDEO SUBSCRIPTION ALREADY EXISTS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'psdt';
            $oCriteria->condition = 'psdt.document_id=:snDocumentID AND psdt.subscription_id=:subscriptionID';
            $oCriteria->params = array(':subscriptionID' => $snSubscriptionId, ':snDocumentID' => $snDocumentId);
            $omRecordExists = PackageSubscriptionDocumentsTransaction::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD SUBSCRIPTION UNDER VIDEOS //
                $oModel = new PackageSubscriptionDocumentsTransaction();
                $oModel->subscription_id = $snSubscriptionId;
                $oModel->document_id = $snDocumentId;
                $oModel->save();
            }
        }
        // REMOVE SUBSCRIPTION FROM WHICH ARE UNSELECTED //
        self::removeUnselectedDocuments($snSubscriptionId, $anDocsIds);
        return true;
    }

    /** function removeUnselectedDocuments() 
     * for remove subscription ids which are unselected from documents
     * @param  int     $snDocumentId
     * @param  array   $anSubIds
     * return  boolean
     */
    public static function removeUnselectedDocuments($snSubscriptionId, $anDocsIds) {
        $ssDocsCriteria = (count($anDocsIds) > 0) ? 'document_id NOT IN(' . implode(',', $anDocsIds) . ') AND subscription_id = ' . $snSubscriptionId : 'subscription_id = ' . $snSubscriptionId;
        PackageSubscriptionDocumentsTransaction::model()->deleteAll($ssDocsCriteria);
        return true;
    }

    /** function removeSubscriptionFromDocument() 
     * for remove particular document from the subscription
     * @param  int     $snSubscriptionId
     * @param  array   $snDocumentID
     * return  boolean
     */
    public static function removeSubscriptionFromDocument($snSubscriptionId, $snDocumentID) {

        $bDeleteStatus = PackageSubscriptionDocumentsTransaction::model()->deleteAll('subscription_id = :subscriptionID AND document_id =:snDocumentID', array('subscriptionID' => $snSubscriptionId, 'snDocumentID' => $snDocumentID));
        return $bDeleteStatus;
    }

}