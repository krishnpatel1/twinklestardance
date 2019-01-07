<?php

class PackageSubscriptionAllDocumentsController extends AdminCoreController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'PackageSubscriptionAllDocuments'),
        ));
    }

    public function actionCreate() {
        $oModel = new PackageSubscriptionAllDocuments;
        $oModel->scenario = 'add_document';

        if (Yii::app()->request->isPostRequest) {
            $oModel->setAttributes($_POST['PackageSubscriptionAllDocuments']);

            if ($oModel->validate()) {

                // UPLOAD DOCUMENT FOR PACKAGE/SUBSCRIPTION //                
                if ($_POST['PackageSubscriptionAllDocuments']['document_url'] != "") {
                    // SAVE DOCUMENT INFO INTO DB //
                    $oModel->document_name = $_POST['PackageSubscriptionAllDocuments']['document_url'];
                } else {
                    $oFile = CUploadedFile::getInstanceByName('PackageSubscriptionAllDocuments[document_name]');
                    if ($oFile) {
                        $ssUploadPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/';
                        $ssNewName = md5($oFile->name . time()) . '.' . $oFile->extensionName;
                        $oFile->saveAs($ssUploadPath . '/' . $ssNewName);

                        // SAVE DOCUMENT INFO INTO DB //
                        $oModel->document_name = $ssNewName;
                    }
                }
                $oModel->save();
                // ADD SUBSCRIPTION INTO DOCUMENT //
                if ($oModel) {
                    $oDocModel = new PackageSubscriptionDocumentsTransaction();
                    $oDocModel->document_id = $oModel->id;
                    $oDocModel->subscription_id = $_POST['PackageSubscriptionAllDocuments']['subscription_id'];
                    $oDocModel->save();
                }

                Yii::app()->user->setFlash('success', "Document has been successfully uploaded");
                $this->redirect(array('admin'));
            }
        }

        // FOR GET ALL ACTIVE SUBSCRIPTOINS 
        $oCriteria = new CDbCriteria();
        $oCriteria->condition = 'price > 0 AND status = 1 AND type = "Subscription"';
        $omSubscription = PackageSubscription::model()->findAll($oCriteria);
        $amSubscriptions = CHtml::listData($omSubscription, 'id', 'name');


        $this->render('create', array('model' => $oModel,
            'amSubscriptions' => $amSubscriptions
        ));
    }

    public function actionUpdate($id) {
        $oModel = $this->loadModel($id, 'PackageSubscriptionAllDocuments');
        $oModel->scenario = 'edit_document';
        $oModel->document_url = (strstr($oModel->document_name, 'http')) ? $oModel->document_name : "";

        if (Yii::app()->request->isPostRequest) {
            $ssOldDocument = $oModel->document_name;
            $amPostData = $_POST['PackageSubscriptionAllDocuments'];
            $oModel->document_title = $amPostData['document_title'];
            $oModel->document_url = $amPostData['document_url'];

            if ($oModel->validate()) {
                // UPLOAD DOCUMENT FOR PACKAGE/SUBSCRIPTION //                
                if ($_POST['PackageSubscriptionAllDocuments']['document_url'] != "") {
                    // SAVE DOCUMENT INFO INTO DB //
                    $oModel->document_name = $_POST['PackageSubscriptionAllDocuments']['document_url'];
                } else {
                    $oFile = CUploadedFile::getInstanceByName('PackageSubscriptionAllDocuments[document_name]');
                    if ($oFile) {
                        $ssUploadPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/';
                        $ssNewName = md5($oFile->name . time()) . '.' . $oFile->extensionName;
                        $oFile->saveAs($ssUploadPath . '/' . $ssNewName);

                        // REMOVE OLD DOCUMENT //
                        Common::removeSubscriptionDocs($ssOldDocument);
                        // SAVE DOCUMENT INFO INTO DB //
                        $oModel->document_name = $ssNewName;
                    }
                }
                $oModel->save(false);
                Yii::app()->user->setFlash('success', "Document has been successfully uploaded");
                $this->redirect(array('admin'));
            }
        }

        // FOR GET ALL DOCUMENTS OF PACKAGE/SUBSCRIPTION //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "document_id =:snDocumentID";
        $omCriteria->params = array(':snDocumentID' => $id);
        $omDocuments = PackageSubscriptionDocumentsTransaction::model()->findAll($omCriteria);

        $this->render('update', array(
            'model' => $oModel,
            'omDocuments' => $omDocuments
        ));
    }

    public function actionDelete($document_id, $subscription_id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $bDeleted = PackageSubscriptionDocumentsTransaction::removeSubscriptionFromDocument($subscription_id, $document_id);
            if ($bDeleted) {
                Yii::app()->user->setFlash('success', "Document has been successfully removed");
                $this->redirect(array('admin'));
            }
            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                Yii::app()->user->setFlash('success', "Document has been successfully removed");
                $this->redirect(array('admin'));
            }
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PackageSubscriptionAllDocuments');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {

        // FOR DELETE SELECTED ORDERS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anDeletedIds = isset($_POST['document_sub_id']) ? $_POST['document_sub_id'] : array();
            if (count($anDeletedIds) > 0) {
                $bDeleted = 0;
                foreach ($anDeletedIds as $smDocAndSubIds) {
                    list($snDocumentID, $snSubscriptionId) = explode('_', $smDocAndSubIds);
                    $bDeleted = PackageSubscriptionDocumentsTransaction::removeSubscriptionFromDocument($snSubscriptionId, $snDocumentID);
                }
                if ($bDeleted) {
                    Yii::app()->user->setFlash('success', "Record has been successfully deleted");
                    $this->redirect(array('admin'));
                }
            }
        }

        if (AdminModule::isAdmin()) {
            $ssModel = "PackageSubscriptionDocumentsTransaction";
            $ssView = "admin";
            $oCriteria = new CDbCriteria();
        } 
        else 
        {
            $ssModel = "PackageSubscriptionAllDocuments";
            $ssView = "user_documents";

            if (AdminModule::isStudioAdmin()) 
            {
                $omResult = Orders::getAndCheckUserPurchasedSubscriptions(true);
                $anSubIds = $anPackageSubIds = array();

                if ($omResult) 
                {
                    foreach ($omResult as $omDataSet) 
                    {
                        foreach ($omDataSet->orderDetails as $omOrderDetails) 
                        {
                            if ($omOrderDetails->packageSubscription->type == "Package")
                            {
                                $anPackageSubIds = PackageSubscription::getSubscriptionsIdsAsPerPackage($omOrderDetails->packageSubscription->id);
                            } 
                            else 
                            {
                                $anSubIds[] = $omOrderDetails->packageSubscription->id;
                            }
                        }
                    }
                }

                $anSubIds = (count($anPackageSubIds) > 0) ? array_merge($anPackageSubIds, $anSubIds) : $anSubIds;
                $anSubIds = array_unique($anSubIds);

                if (count($anSubIds) == 0) 
                {

                    $oCriteria = new CDbCriteria();
                    $oCriteria->condition = "0";
                } 
                else 
                {
                    $oCriteria = new CDbCriteria();
                    $oCriteria->select = 'psd.*';
                    $oCriteria->alias = 'psd';

                    if(isset($_GET['PackageSubscriptionAllDocuments']) && isset($_GET['PackageSubscriptionAllDocuments']['document_title']) && !empty($_GET['PackageSubscriptionAllDocuments']['document_title']))
                    {
                        $oCriteria->condition = "psd.document_title LIKE :document_title";
                        $oCriteria->params = array(':document_title' => '%'.$_GET['PackageSubscriptionAllDocuments']['document_title'].'%');      
                    }
                }
            }
            else 
            {    // FOR INSTRUCTOR //
                $oCriteria = new CDbCriteria();
                $oCriteria->alias = 'cd';
                $oCriteria->join = 'INNER JOIN class_users cu ON cd.class_id = cu.class_id';
                $oCriteria->join .= ' INNER JOIN classes c ON c.id = cu.class_id';
                $oCriteria->condition = "cu.user_id =:snUserID AND DATE_FORMAT( c.end_date, '%Y-%m-%d' ) >= DATE_FORMAT( NOW(), '%Y-%m-%d')";
                $oCriteria->params = array(':snUserID' => Yii::app()->admin->id);
            }
        }
        $dataProvider = new CActiveDataProvider($ssModel, array(
            'criteria' => $oCriteria
        ));

        //p($dataProvider);
        
        $this->render($ssView, array(
            'model' => $dataProvider
        ));
    }

    public function actionAddSubscription($id) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'PackageSubscriptionAllDocuments');

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anSubIds = isset($_POST['subscriptions']) ? $_POST['subscriptions'] : array();
            if (count($anSubIds) > 0) {
                PackageSubscriptionDocumentsTransaction::addSubscriptionInDocument($model->id, $anSubIds);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $oModel = PackageSubscription::getAllPackageSubscription();
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET SELECTED SUBSCRIPTION AS PER DOCUMENT //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "document_id =:snDocumentID";
        $omCriteria->params = array(':snDocumentID' => $id);
        $omDocuments = PackageSubscriptionDocumentsTransaction::model()->findAll($omCriteria);

        if ($omDocuments) {
            foreach ($omDocuments as $omData) {
                $amSelected[] = $omData->subscription_id;
            }
        }

        $this->render('addSubscription', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
        ));
    }

    public function actionAddClassesToDocument($id) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'PackageSubscriptionAllDocuments');

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anClassIds = isset($_POST['classes']) ? $_POST['classes'] : array();
            if (count($anClassIds) > 0) {
                ClassDocuments::addClassesInDocument($model->id, $anClassIds);
            }
//            else{
//                ClassDocuments::removeUnselectedClasses($model->id);
//            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $snLoggedInUserId = Yii::app()->admin->id; // (studio,instructor,dancer)
        $oModel = Classes::getAllClassesCreateByUser($snLoggedInUserId);
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET SELECTED SUBSCRIPTION AS PER DOCUMENT //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "document_id =:snDocumentID";
        $omCriteria->params = array(':snDocumentID' => $id);
        $omDocuments = ClassDocuments::model()->findAll($omCriteria);

        if ($omDocuments) {
            foreach ($omDocuments as $omData) {
                $amSelected[] = $omData->class_id;
            }
        }

        $this->render('addClassesToDocument', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
        ));
    }

    public function actionRemoveSubscriptionFromDocument($id) {

        $snDocumentId = Yii::app()->getRequest()->getParam('document_id', '');
        $bResponse = PackageSubscriptionDocumentsTransaction::removeSubscriptionFromDocument($id, $snDocumentId);

        echo $bResponse;
        Yii::app()->end();
    }

}