<?php

Yii::import('application.models._base.BaseClassDocuments');

class ClassDocuments extends BaseClassDocuments {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addClassesInDocument() 
     * for add/remove selected/unselected class ids from document
     * @param  int     $snDocumentId
     * @param  array   $anClassIds
     * return  boolean
     */
    public static function addClassesInDocument($snDocumentId, $anClassIds) {
        foreach ($anClassIds as $snClassID) {
            // FOR CHECK VIDEO SUBSCRIPTION ALREADY EXISTS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'cd';
            $oCriteria->condition = 'cd.document_id=:snDocumentID AND cd.class_id=:snClassID';
            $oCriteria->params = array(':snClassID' => $snClassID, ':snDocumentID' => $snDocumentId);
            $omRecordExists = ClassDocuments::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD SUBSCRIPTION UNDER VIDEOS //
                $oModel = new ClassDocuments();
                $oModel->class_id = $snClassID;
                $oModel->document_id = $snDocumentId;
                $oModel->save();
            }
        }
        // REMOVE CLASSES FROM WHICH ARE UNSELECTED //
        self::removeUnselectedClasses($snDocumentId, $anClassIds);
        return true;
    }

    /** function removeUnselectedClasses() 
     * for remove class ids which are unselected from documents
     * @param  int     $snDocumentId
     * @param  array   $anClassIds
     * return  boolean
     */
    public static function removeUnselectedClasses($snDocumentId, $anClassIds = array()) {
        
        $ssClassCriteria = (count($anClassIds) > 0) ? 'class_id NOT IN(' . implode(',', $anClassIds) . ') AND document_id = ' . $snDocumentId : 'document_id = ' . $snDocumentId;
        $bRemoved = ClassDocuments::model()->deleteAll($ssClassCriteria);
        return $bRemoved;
    }
    
    /** function addDocumentsInClass() 
     * for add/remove selected/unselected class ids from document
     * @param  int     $snClassId
     * @param  array   $anDocsIds
     * return  boolean
     */
    public static function addDocumentsInClass($snClassId, $anDocsIds) {
        foreach ($anDocsIds as $snDocumentId) {
            // FOR CHECK VIDEO SUBSCRIPTION ALREADY EXISTS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'cd';
            $oCriteria->condition = 'cd.document_id=:snDocumentID AND cd.class_id=:snClassID';
            $oCriteria->params = array(':snClassID' => $snClassId, ':snDocumentID' => $snDocumentId);
            $omRecordExists = ClassDocuments::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD SUBSCRIPTION UNDER VIDEOS //
                $oModel = new ClassDocuments();
                $oModel->class_id = $snClassId;
                $oModel->document_id = $snDocumentId;
                $oModel->save();
            }
        }
        // REMOVE SUBSCRIPTION FROM WHICH ARE UNSELECTED //
        self::removeUnselectedDocuments($snClassId, $anDocsIds);
        return true;
    }

    /** function removeUnselectedDocuments() 
     * for remove class ids which are unselected from documents
     * @param  int     $snClassId
     * @param  array   $anDocsIds
     * return  boolean
     */
    public static function removeUnselectedDocuments($snClassId, $anDocsIds = array()) {
        $ssDocsCriteria = (count($anDocsIds) > 0) ? 'document_id NOT IN(' . implode(',', $anDocsIds) . ') AND class_id = ' . $snClassId : 'class_id = ' . $snClassId;
        ClassDocuments::model()->deleteAll($ssDocsCriteria);
        return true;
    }
    
    /** function removeDocumentFromClass() 
     * for remove row from class document table
     * @param  int     $snClassId
     * @param  int     $snDocumentId
     * return  boolean
     */
    public static function removeDocumentFromClass($snClassId, $snDocumentId) {
        $bDeleteStatus = ClassDocuments::model()->deleteAll('class_id = :classID AND document_id =:docsID', array('classID' => $snClassId, 'docsID' => $snDocumentId));
        return $bDeleteStatus;
    }

}