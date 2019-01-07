<?php

class PackageSubscriptionController extends AdminCoreController {

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
            'model' => $this->loadModel($id, 'PackageSubscription'),
        ));
    }

    public function actionCreate($type) {
        $model = new PackageSubscription;
        $model->scenario = 'add_package_subscription';

        // FOLLOWING LINE IF AJAX VALIDATION IS NEEDED //
        $this->performAjaxValidation($model);

        if (isset($_POST['PackageSubscription'])) {
            $amPostData = $_POST['PackageSubscription'];
            $model->setAttributes($amPostData);
            $model->type = $type;

            // IMAGE SAVE HERE
            $model->image_url = $_FILES['PackageSubscription']['name']['image_url'];
            $model->image_url = CUploadedFile::getInstance($model, 'image_url');
            if (isset($_FILES['PackageSubscription']['name']['image_url']) && $_FILES['PackageSubscription']['name']['image_url'] != '') {
                // FOR UPLOAD ORGINAL IMAGE //
                $ssUploadPath = Yii::getPathOfAlias('webroot');
                $amImageInfo = explode(".", $model->image_url);
                $ssImageName = Yii::app()->params['package_sub_prefix'] . '_' . time() . '.' . $amImageInfo[1];
                $ssSaveImageFile = $ssUploadPath . '/uploads/packagesubscription/' . $ssImageName;
                $model->image_url->saveAs($ssSaveImageFile);
                $model->image_url = $ssImageName;

                // GENERATE THUMBNAIL FOR DISPLY INTO FRONT SIDE //
                $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                $ssImgThumbWidth = Yii::app()->params['package_sub_front_width'];
                $ssImgThumbHeight = Yii::app()->params['package_sub_front_height'];
                $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                $ssStoreThumbImage = $ssUploadPath . '/uploads/packagesubscription/thumb/' . $ssImageName;
                $oThumb->save($ssStoreThumbImage);
            } else {
                $model->image_url = ($model->static_image_url) ? $model->static_image_url : '';
            }
            if ($model->save()) {

                if (isset($_POST['subscriptions_videos']) && count($_POST['subscriptions_videos']) > 0) {
                    // SAVE SUBSCRIPTIONS AS PER PACKAGE//
                    if ($type == "Package" && (isset($_POST['subscriptions_videos']) && count($_POST['subscriptions_videos']) > 0)) {
                        PackageSubscriptionTransaction::saveSubscriptionsIds($model->id, $_POST['subscriptions_videos']);
                    } else {
                        SubscriptionVideoTransaction::saveVideosIds($model->id, $_POST['subscriptions_videos']);
                    }
                }
                $this->redirect(CController::createUrl("packageSubscription/index", array('type' => $type)));
            }
        }

        // FOR GET SUBSCRIPTION/VIDEOS AS PER TYPE //
        $ssType = isset($amPostData['type']) ? $amPostData['type'] : 'Package';
        $amResult = $amSelected = array();
        if ($ssType == "Package") {
            $oModel = PackageSubscription::getAllPackageSubscription();
            $amResult = CHtml::listData($oModel, 'id', 'name');
        } else {
            $oModel = Videos::getAllActiveVideos();
            $amResult = CHtml::listData($oModel, 'id', 'title');
        }
        // FOR SHOW SELECTED SUBSCRIPTION/VIDOES ON SAME PAGE //            
        if (isset($_POST['subscriptions_videos']) && count($_POST['subscriptions_videos']) > 0) {
            foreach ($_POST['subscriptions_videos'] as $snSelectedIndex) {
                $amSelected[$snSelectedIndex] = array("selected" => true);
            }
        }
        $this->render('create', array('model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'ssType' => $type
        ));
    }

    public function actionUpdate($id, $type) {
        $model = $this->loadModel($id, 'PackageSubscription');
        $model->scenario = 'edit_package_subscription';

        // FOLLOWING LINE IF AJAX VALIDATION IS NEEDED //
        $this->performAjaxValidation($model);

        if (isset($_POST['PackageSubscription'])) {
            $amPostData = $_POST['PackageSubscription'];
            unset($amPostData['image_url']);
            $ssOldImageName = $model->image_url;
            $model->setAttributes($amPostData);

            //IMAGE UPDATE CODE
            if ($_FILES['PackageSubscription']['name']['image_url'] != "") {
                $oImage = CUploadedFile::getInstance($model, 'image_url');
                $model->image_url = $oImage;
                if (is_object($oImage)) {
                    // FOR UPLOAD ORGINAL IMAGE //
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $amImageInfo = explode(".", $model->image_url);
                    $ssImageName = Yii::app()->params['package_sub_prefix'] . '_' . time() . '.' . $amImageInfo[1];
                    $ssSaveImageFile = $ssUploadPath . '/uploads/packagesubscription/' . $ssImageName;
                    $model->image_url->saveAs($ssSaveImageFile);
                    $model->image_url = $ssImageName;

                    // GENERATE THUMBNAIL FOR DISPLY INTO FRONT SIDE //
                    $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                    $ssImgThumbWidth = Yii::app()->params['package_sub_front_width'];
                    $ssImgThumbHeight = Yii::app()->params['package_sub_front_height'];
                    $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                    $ssStoreThumbImage = $ssUploadPath . '/uploads/packagesubscription/thumb/' . $ssImageName;
                    $oThumb->save($ssStoreThumbImage);

                    // FOR REMOVE OLD IMAGE //
                    Common::removePackageSubscriptionImage($ssOldImageName);
                }
            } else {
                if ($amPostData['static_image_url'] != "") {
                    Common::removePackageSubscriptionImage($ssOldImageName);
                    $model->image_url = $amPostData['static_image_url'];
                }
            }

            if ($model->validate()) {
                unset($model->available_update);
                $model->save();

                // SAVE SUBSCRIPTIONS AS PER PACKAGE//
                if (isset($_POST['subscriptions_videos']) && count($_POST['subscriptions_videos']) > 0) {
                    if ($type == "Package") {
                        PackageSubscriptionTransaction::saveSubscriptionsIds($model->id, $_POST['subscriptions_videos']);
                    } else {
                        SubscriptionVideoTransaction::saveVideosIds($model->id, $_POST['subscriptions_videos']);
                    }
                }
                $this->redirect(CController::createUrl("packageSubscription/index", array('type' => $type)));
            }
        }

        //Check image URL        
        if (strstr($model->image_url, 'http'))
            $model->static_image_url = $model->image_url;


        // FOR GET SUBSCRIPTION/VIDEOS AS PER TYPE //
        $ssType = isset($amPostData['type']) ? $amPostData['type'] : $model->type;
        $amResult = $amSelected = array();

        if ($ssType == "Package") {
            // FOR GET ALL SUBSCRIPTIONS //
            $oModel = PackageSubscription::getAllPackageSubscription();
            $amResult = CHtml::listData($oModel, 'id', 'name');

            // FOR GET SELECTED SUBSCRIPTION AS PER PACKAGE //
            $omModelTrans = PackageSubscription::getSubscriptionsAsPerPackage($model->id);
            $amSelectedResult = CHtml::listData($omModelTrans, 'id', 'name');
            foreach ($amSelectedResult as $snId => $ssValue) {
                $amSelected[] = $snId;
            }
        } else {
            // FOR GET ALL VIDEOS //
            $oModel = Videos::getAllActiveVideos();
            $amResult = CHtml::listData($oModel, 'id', 'title');

            // FOR GET SELECTED VIDEOS AS PER SUBSCRIPTION //
            $omModelTrans = Videos::getVideosAsPerSubscription($model->id);
            $amSelectedResult = CHtml::listData($omModelTrans, 'id', 'title');
            foreach ($amSelectedResult as $snId => $ssValue) {
                $amSelected[] = $snId;
            }
        }
        // FOR SELECTED SUBSCRIPTION/VIDOES ON SAME PAGE //                                
        if (isset($_POST['subscriptions_videos']) && count($_POST['subscriptions_videos']) > 0) {
            foreach ($_POST['subscriptions_videos'] as $snSelectedIndex) {
                $amSelected[$snSelectedIndex] = array("selected" => true);
            }
        }
        // FOR GET ALL DOCUMENTS OF PACKAGE/SUBSCRIPTION //
        //$omDocuments = PackageSubscriptionDocuments::model()->findAll("package_sub_id =:packageSubID", array(":packageSubID" => $model->id));
        //
        // FOR GET SELECTED SUBSCRIPTION AS PER DOCUMENT //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "subscription_id =:snSubscriptionID";
        $omCriteria->params = array(':snSubscriptionID' => $model->id);
        $omDocuments = PackageSubscriptionDocumentsTransaction::model()->findAll($omCriteria);

        $this->render('update', array('model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'ssType' => $type,
            'omModelTrans' => $omModelTrans,
            'omDocuments' => $omDocuments
        ));
    }

    public function actionDelete($id, $type) {
        $oModel = $this->loadModel($id, 'PackageSubscription');
        if ($oModel) {
            // FOR REMOVE IMAGE //
            Common::removePackageSubscriptionImage($oModel->image_url);
            // FOR REMOVE DOCUMENTS //
            $ssDirectoryPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/';
            Common::removeDirectory($oModel->id, $ssDirectoryPath);

            $oModel->delete();
            Yii::app()->user->setFlash('success', "Record has been successfully deleted");
            $this->redirect(CController::createUrl("packageSubscription/index", array('type' => $type)));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex($type) {
        $omCriteria = PackageSubscription::getAllPackageSubscriptionCriteria($type);
        $dataProvider = new CActiveDataProvider('PackageSubscription', array('criteria' => $omCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'ssType' => $type
        ));
    }

    public function actionAdmin() {
        $model = new PackageSubscription('search');
        $model->unsetAttributes();

        if (isset($_GET['PackageSubscription']))
            $model->setAttributes($_GET['PackageSubscription']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Get all actions as per controller
     */
    public function actionGetSubVideos() {
        $ssType = Yii::app()->getRequest()->getParam('type', '');
        // For get subscription as per type.

        $amResult = array();
        $ssHTML = '';
        if ($ssType == "Package") {
            $oModel = PackageSubscription::getAllPackageSubscription();
            $amResult = CHtml::listData($oModel, 'id', 'name');
        } else {
            $oModel = Videos::getAllActiveVideos();
            $amResult = CHtml::listData($oModel, 'id', 'title');
        }
        $ssHTML = $this->renderPartial('_subscription', array(
            'amResult' => $amResult,
            'amSelected' => array()), false, true);

        echo $ssHTML;
        Yii::app()->end();
    }

    public function actionAssignSubVideos($id, $updated) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'PackageSubscription');

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if ($_POST) {
            $anSubVideoIds = isset($_POST['subscriptions_videos']) ? $_POST['subscriptions_videos'] : array();
            if ($model->type == "Package") {
                PackageSubscriptionTransaction::saveSubscriptionsIds($model->id, $anSubVideoIds, $updated);
            } else {
                SubscriptionVideoTransaction::saveVideosIds($model->id, $anSubVideoIds, $updated);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        // FOR GET SUBSCRIPTION/VIDEOS AS PER TYPE //
        $amResult = $amSelected = array();
        if ($model->type == "Package") {
            $oModel = PackageSubscription::getAllPackageSubscription();
            $amResult = CHtml::listData($oModel, 'id', 'name');

            $omSubscriptionsTrans = PackageSubscription::getSubscriptionsAsPerPackage($model->id);
            $amSelectedResult = CHtml::listData($omSubscriptionsTrans, 'id', 'name');
            foreach ($amSelectedResult as $snId => $ssValue) {
                $amSelected[$snId] = array("selected" => true);
            }
        } else {
            $oModel = Videos::getAllActiveVideos();
            $amResult = CHtml::listData($oModel, 'id', 'title');

            $omVideosTrans = Videos::getVideosAsPerSubscription($model->id);
            $amSelectedResult = CHtml::listData($omVideosTrans, 'id', 'title');
            foreach ($amSelectedResult as $snId => $ssValue) {
                $amSelected[$snId] = array("selected" => true);
            }
        }
        $this->render('assignSubVideos', array('model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'ssType' => $model->type
        ));
    }

    public function actionAddDocuments($id) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'PackageSubscription');

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anDocumentsIds = isset($_POST['document_ids']) ? $_POST['document_ids'] : array();
            if (count($anDocumentsIds) > 0) {
                PackageSubscriptionDocumentsTransaction::addDocumentsInSubscription($model->id, $anDocumentsIds);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $oModel = PackageSubscriptionDocuments::model()->findAll();
        $amResult = CHtml::listData($oModel, 'id', 'document_title');

        // FOR GET SELECTED SUBSCRIPTION AS PER DOCUMENT //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "subscription_id =:snSubscriptionID";
        $omCriteria->params = array(':snSubscriptionID' => $id);
        $omDocuments = PackageSubscriptionDocumentsTransaction::model()->findAll($omCriteria);

        if ($omDocuments) {
            foreach ($omDocuments as $omData) {
                $amSelected[] = $omData->document_id;
            }
        }

        $this->render('addDocuments', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
        ));
        
        /* OLD code:
        $this->layout = '..//layouts/create_admin';
        $oModel = new PackageSubscriptionDocuments();

        if (Yii::app()->request->isPostRequest) {
            $oModel->setAttributes($_POST['PackageSubscriptionDocuments']);
            if ($oModel->validate()) {

                // CREATE PACKAGE/SUBSCRIPTION ID DIRECTORY IF NOT EXISTS //
                $ssDirectoryPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/';
                Common::createDirectory($id, $ssDirectoryPath);

                // UPLOAD DOCUMENT FOR PACKAGE/SUBSCRIPTION //                
                if ($_POST['PackageSubscriptionDocuments']['document_url']) {
                    // SAVE DOCUMENT INFO INTO DB //
                    $oModel->package_sub_id = $id;
                    $oModel->document_name = $_POST['PackageSubscriptionDocuments']['document_url'];
                    $oModel->save();
                } else {
                    $oFile = CUploadedFile::getInstanceByName('PackageSubscriptionDocuments[document_name]');
                    if ($oFile) {
                        $ssUploadPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/' . $id;
                        $ssNewName = md5($oFile->name . time()) . '.' . $oFile->extensionName;
                        $oFile->saveAs($ssUploadPath . '/' . $ssNewName);

                        // SAVE DOCUMENT INFO INTO DB //
                        $oModel->package_sub_id = $id;
                        $oModel->document_name = $ssNewName;
                        $oModel->save();
                    }
                }

                // CLOSE COLOR BOX //
                echo Common::closeColorBox();
                Yii::app()->end();
            }
        }
        $this->render('addDocuments', array(
            'model' => $oModel
        ));
         * 
         */
    }

    public function actionRemoveDocument($id) {

        $snPackageSubId = Yii::app()->getRequest()->getParam('package_sub_id', '');
        $bResponse = PackageSubscriptionDocumentsTransaction::removeSubscriptionFromDocument($snPackageSubId, $id);

        echo $bResponse;
        Yii::app()->end();
        
        /*$bResponse = false;
        $model = $this->loadModel($id, 'PackageSubscriptionDocuments');
        if ($model) {
            $model->delete();
            Common::removePackageSubscriptionDocs($model->package_sub_id, $model->document_name);
            $bResponse = true;
        }
        echo $bResponse;
        Yii::app()->end();*/
    }

    public function actionRemoveSubscriptionVideo($id, $type) {

        $bResponse = false;
        $snPackageSubId = Yii::app()->getRequest()->getParam('package_sub_id', '');
        if ($type == "Package") {
            $bResponse = PackageSubscriptionTransaction::removeSubscriptionFromPackage($snPackageSubId, $id);
        } else {
            $bResponse = SubscriptionVideoTransaction::removeVideoFromSubscription($snPackageSubId, $id);
        }
        echo $bResponse;
        Yii::app()->end();
    }

    public function actionSetAvailableUpdate() {

        $snPackageSubId = Yii::app()->getRequest()->getParam('id', '0');
        $snUpdatedValue = Yii::app()->getRequest()->getParam('value', '0');
        $model = $this->loadModel($snPackageSubId, 'PackageSubscription');
        // Phase-II: Commented as per Aidan Note: 2nd Oct, '13
        //$model->available_update = $model->available_update + $snUpdatedValue;        
        $model->available_update = $snUpdatedValue;
        $model->save();

        echo CJSON::encode(array('available_update' => $model->available_update));
        Yii::app()->end();
    }

    /**
     * function: performAjaxValidation()
     * For perform Yii Ajax validation
     */
    protected function performAjaxValidation($model, $form = NULL) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionActiveSubscriptionList() 
    {
        $snUserId = Yii::app()->user->id;

        $criteria=new CDbCriteria;
        $criteria->condition='id=:id';
        $criteria->params=array(':id'=>Yii::app()->user->id);
        $user = Users::model()->find($criteria);

        $ssModel = "OrderDetails";

        $oCriteria = new CDbCriteria;
        $oCriteria->select = "o.id, od.*";
        $oCriteria->alias = 'od';
        $oCriteria->join = 'INNER JOIN orders o ON o.id = od.order_id';

        if($user->user_type != 1)
        {
            $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1 AND od.is_deleted = 0";
            $oCriteria->params = array(':snUserId' => $snUserId);
        }
        else
        {
            $oCriteria->condition = "o.payment_status = 1 AND od.is_deleted = 0";
        }
        
        $oCriteria->order = "od.id DESC";
       
        $omOrders = OrderDetails::model()->findAll($oCriteria);
        $filterOrderArr = array();

        if(!empty($omOrders))
        {
            foreach ($omOrders as $key => $order) 
            {
                $diff = strtotime(date('Y-m-d',strtotime($order->expiry_date))) - strtotime(date('Y-m-d')); 
                $days = round($diff / 86400); 

                if($days >= 0 && $days <= 30)
                {
                   $filterOrderArr[$key] = $order;
                }
            }
        }

        $dataProvider = new CArrayDataProvider($filterOrderArr); 

        $this->layout = false; 
        $this->render('active_subscription', array(
            'model' => $dataProvider,
            'user_type' => $user->user_type
        ));
    }

    public function actionCancelSubscription() 
    {
        if (Yii::app()->getRequest()->getIsPostRequest() && isset($_POST['orderID']) && !empty($_POST['orderID'])) 
        {
            //$bDeleted = OrderDetails::model()->deleteAll('id='.$_POST['orderID']);

            //echo ($bDeleted) ? 1 : 0;

            OrderDetails::model()->updateByPk($_POST['orderID'],array('is_deleted' => 1));

            echo 1;
        }
        else
        {
            echo 0;
        }
        exit();
    }

    public function actionCheckExpiringSubscription() 
    {
        $snUserId = Yii::app()->user->id;

        $criteria=new CDbCriteria;
        $criteria->condition='id=:id';
        $criteria->params=array(':id'=>Yii::app()->user->id);
        $user = Users::model()->find($criteria);

        $oCriteria = new CDbCriteria;
        $oCriteria->select = "o.id, od.*";
        $oCriteria->alias = 'od';
        $oCriteria->join = 'INNER JOIN orders o ON o.id = od.order_id';

        if($user->user_type != 1)
        {
            $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1";
            $oCriteria->params = array(':snUserId' => $snUserId);
        }
        else
        {
            $oCriteria->condition = "o.payment_status = 1";
        }

        $ssModel = "OrderDetails";

        $omOrders = OrderDetails::model()->findAll($oCriteria);
        $filterOrderArr = array();

        if(!empty($omOrders))
        {
            foreach ($omOrders as $key => $order) 
            {
                $diff = strtotime(date('Y-m-d',strtotime($order->expiry_date))) - strtotime(date('Y-m-d')); 
                $days = round($diff / 86400); 

                if($days >= 0 && $days <= 30)
                {
                   $filterOrderArr[$key] = $order;
                }
            }
        }

        echo count($filterOrderArr);exit();
    }

}