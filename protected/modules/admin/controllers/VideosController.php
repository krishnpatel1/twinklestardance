<?php

class VideosController extends AdminCoreController {

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
            'model' => $this->loadModel($id, 'Videos'),
        ));
    }

    public function actionCreate() {
        $model = new Videos;

        // FOLLOWING LINE IF AJAX VALIDATION IS NEEDED //
        $this->performAjaxValidation($model);

        if (isset($_POST['Videos'])) {

            $model->setAttributes($_POST['Videos']);

            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Videos');

        // FOLLOWING LINE IF AJAX VALIDATION IS NEEDED //
        $this->performAjaxValidation($model);
        if (isset($_POST['Videos'])) {
            $model->setAttributes($_POST['Videos']);
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $oModel = PackageSubscription::getAllPackageSubscription();
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET SELECTED SUBSCRIPTION AS PER VIDEO //
        $omModelTrans = Videos::getSubscriptionsAsPerVideo($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'subscription_id', 'subscription_name');
        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }

        $this->render('update', array('model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'omModelTrans' => $omModelTrans
        ));
    }

    public function actionDelete($id) {
        $oModel = $this->loadModel($id, 'Videos');
        if ($oModel) {
            $oModel->delete();
            Yii::app()->user->setFlash('success', "Record has been successfully deleted");
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {

        // FOR GET DATA AS PER USER ROLE WISE //
        $snTotalAvailableVideo = 0;
        if (AdminModule::isAdmin()) {
            $ssModel = "Videos";
            $oCriteria = Videos::getAllActiveVideosCriteria();
        } else {
            $ssModel = "Orders";
            $oCriteria = Orders::getUserVideos();

            // FOR GET TOTAL UPDATED VIDEOS COUNT FROM AVAILABLE SUBSCRIPTIONS //
            $snTotalAvailableVideo = Orders::getTotalAvailableUpdateFromPurchasedPackageSub();
        }
        $dataProvider = new CActiveDataProvider($ssModel, array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
                )
        );

        // FOR GET ORDER INFO WHEN USER PURCHASED ANY SUBSCRIPTION FOR E-COMMERCE TRACKING //
        $omOrderInfo = false;
        if (Yii::app()->user->hasFlash('order_info')) {
            $omOrderInfo = Orders::model()->findByPk(Yii::app()->user->getFlash('order_info'));
        }

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'snTotalAvailableVideo' => ($snTotalAvailableVideo >= 0) ? $snTotalAvailableVideo : 0,
            'omOrderInfo' => $omOrderInfo
        ));
    }

    public function actionAdmin() {
        $model = new Videos('search');
        $model->unsetAttributes();

        if (isset($_GET['Videos']))
            $model->setAttributes($_GET['Videos']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAddToSubscription($id, $updated) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'Videos');

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anSubIds = isset($_POST['subscriptions']) ? $_POST['subscriptions'] : array();
            if (count($anSubIds) > 0) {
                SubscriptionVideoTransaction::saveSubscriptionIds($model->id, $anSubIds, $updated);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $oModel = PackageSubscription::getAllPackageSubscription();
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET SELECTED SUBSCRIPTION AS PER VIDEO //
        $omModelTrans = Videos::getSubscriptionsAsPerVideo($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'subscription_id', 'subscription_name');
        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }

        $this->render('addToSubscription', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
        ));
    }

    public function actionRemoveSubscriptionVideo($id) {

        $snVideoId = Yii::app()->getRequest()->getParam('video_id', '');
        $bResponse = SubscriptionVideoTransaction::removeVideoFromSubscription($id, $snVideoId);

        echo $bResponse;
        Yii::app()->end();
    }

    public function actionViewDetails($id, $type) {
        $oModelPackgeSub = PackageSubscription::model()->findByPk($id);
        if (!$oModelPackgeSub)
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));

        if ($type == "Package") {
            $ssModel = "PackageSubscription";
            $oCriteria = PackageSubscription::getSubscriptionsAsPerPackage($id, true);

            // FOR GET TOTAL AVAILABLE VIDEO COUNT AS PER PACKAGE //
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);
        } else {
            $ssModel = "Videos";
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $oCriteria = Videos::getUserPurchasedVideosFromSub($id, $snPackageId, true);

            // FOR GET TOTAL AVAILABLE VIDEO COUNT AS PER SUBSCRIPTION //
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);
        }

        $dataProvider = new CActiveDataProvider($ssModel, array('criteria' => $oCriteria));
        $this->render('viewDetails', array(
            'dataProvider' => $dataProvider,
            'oModelPackgeSub' => $oModelPackgeSub,
            'snPackageSubID' => $id,
            'snTotalAvailableVideo' => ($snAvailableUpdateCount >= 0) ? $snAvailableUpdateCount : 0,
            'ssType' => $type
        ));
    }

    public function actionChooseVideoToAddYourSubscription($id, $type) {

        // FOR TO CHECK IS USER PURCHASED PACKAGE/SUBSCRIPTION HAS BEEN EXPIRED OR NOT //
        $snPackageSubId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : $id;
        $omIsPackageSubExpired = Orders::checkIsUserPackageSubHasBeenExpired($snPackageSubId);
        if (!$omIsPackageSubExpired)
            throw new CHttpException(400, Yii::t('app', 'Your package/subscription has been expired!'));

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anVideoIds = isset($_POST['videoids']) ? $_POST['videoids'] : array();
            $snTotalAvailableVideo = isset($_POST['total_available_video']) ? $_POST['total_available_video'] : 0;
            if (count($anVideoIds) > 0 && count($anVideoIds) <= $snTotalAvailableVideo) {
                $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
                UserPurchasedVideos::addUpdatedVideosToSubscription($id, $anVideoIds, $snPackageId);
                Yii::app()->user->setFlash('success', "Video has been successfully added to your subscription.");

                $ssCriteriaParams = ($snPackageId > 0) ? array("id" => $id, "type" => $type, "package_id" => $snPackageId) : array("id" => $id, "type" => $type);
                $this->redirect(CController::createUrl("videos/viewDetails", $ssCriteriaParams));
            } else { // FOR PURCHASE PAID VIDEO //
                Yii::app()->user->setFlash('error', "Your credit for added free videos into your subscription is over.");
            }
        }
        // FOR GET TOTAL AVAILABLE VIDEO COUNT //                
        $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
        $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);

        // FOR GET ALL UPDATED VIDEOS FROM THE SUBSCRIPTION //
        $omAdditionalVideos = Videos::getUpdatedVideos($id);

        $this->render('chooseVideoToAddYourSubscription', array(
            'omAdditionalVideos' => $omAdditionalVideos,
            'snTotalAvailableVideo' => ($snAvailableUpdateCount >= 0) ? $snAvailableUpdateCount : 0,
            'snSubscriptionId' => $id,
            'ssType' => $type
        ));
    }

    public function actionWatchVideo($iframe_code, $description) {

        //echo $iframe_code = '<iframe frameborder="0" scrolling="no" width="425" height="266" src="http://api.smugmug.com/services/embed/1482349172_HpTNjR3?width=425&amp;height=266"></iframe>';                                
        //echo base64_decode($iframe_code);
        echo "<div style='background-color:#DCDCDC;'>";
        echo "<div class='video'>" . base64_decode($iframe_code) . "<div />";

        // STRIP WIDTH FROM IFRAME //
        $ssHTML = base64_decode($iframe_code);
        $amResults = array();
        preg_match('/width="([^"]*)"/i', $ssHTML, $amResults);
        $ssDefaultWidth = (count($amResults) > 0 && isset($amResults[1]) && $amResults[1] > 0) ? 'width:' . $amResults[1] . 'px;' : 'width:' . Yii::app()->params['defaultIframeWidth'] . 'px;';
        echo "<div class='video_description' style='$ssDefaultWidth'>" . base64_decode($description) . '<div />';
        echo "<div />";
        exit;
    }

    public function actionPublishOnFb($id) {
        $this->layout = false;
        $omVideo = Videos::model()->findByPk($id);        

        $this->render('publishOnFb', array(
            'omVideo' => $omVideo
        ));
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
    
    
    public function actionViewDetailsTable($id, $type) {
        $oModelPackgeSub = PackageSubscription::model()->findByPk($id);
        if (!$oModelPackgeSub)
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));

        if ($type == "Package") {
            $ssModel = "PackageSubscription";
            $oCriteria = PackageSubscription::getSubscriptionsAsPerPackage($id, true);

            // FOR GET TOTAL AVAILABLE VIDEO COUNT AS PER PACKAGE //
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);
        } else {
            $ssModel = "Videos";
            $vid_arr=Yii::app()->getRequest()->getParam('Videos');
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $oCriteria = Videos::getUserPurchasedVideosFromSub($id, $snPackageId, true,$vid_arr['title'],$vid_arr['genre'],$vid_arr['category'],$vid_arr['age']);            
            // FOR GET TOTAL AVAILABLE VIDEO COUNT AS PER SUBSCRIPTION //
            $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
            $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);
        }

        $dataProvider = new CActiveDataProvider($ssModel, array('criteria' => $oCriteria));
        $this->render('viewDetailsTable', array(
            'dataProvider' => $dataProvider,
            'oModelPackgeSub' => $oModelPackgeSub,
            'snPackageSubID' => $id,
            'snTotalAvailableVideo' => ($snAvailableUpdateCount >= 0) ? $snAvailableUpdateCount : 0,
            'ssType' => $type
        ));
    }

    
     public function actionChooseVideoToAddYourSubscriptionTable($id, $type) {

        // FOR TO CHECK IS USER PURCHASED PACKAGE/SUBSCRIPTION HAS BEEN EXPIRED OR NOT //
        $snPackageSubId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : $id;
        $omIsPackageSubExpired = Orders::checkIsUserPackageSubHasBeenExpired($snPackageSubId);
        if (!$omIsPackageSubExpired)
            throw new CHttpException(400, Yii::t('app', 'Your package/subscription has been expired!'));

        // SAVE SUBSCRIPTIONS AS PER PACKAGE//
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anVideoIds = isset($_POST['videoids']) ? $_POST['videoids'] : array();
            $snTotalAvailableVideo = isset($_POST['total_available_video']) ? $_POST['total_available_video'] : 0;
            if (count($anVideoIds) > 0 && count($anVideoIds) <= $snTotalAvailableVideo) {
                $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
                UserPurchasedVideos::addUpdatedVideosToSubscription($id, $anVideoIds, $snPackageId);
                Yii::app()->user->setFlash('success', "Video has been successfully added to your subscription.");

                $ssCriteriaParams = ($snPackageId > 0) ? array("id" => $id, "type" => $type, "package_id" => $snPackageId) : array("id" => $id, "type" => $type);
                $this->redirect(CController::createUrl("videos/viewDetails", $ssCriteriaParams));
            } else { // FOR PURCHASE PAID VIDEO //
                Yii::app()->user->setFlash('error', "Your credit for added free videos into your subscription is over.");
            }
        }
        // FOR GET TOTAL AVAILABLE VIDEO COUNT //                
        $snPackageId = (Yii::app()->getRequest()->getParam('package_id')) ? Yii::app()->getRequest()->getParam('package_id') : 0;
        $snAvailableUpdateCount = PackageSubscription::getAvailableUpdateAsPerPackageSub($id, $snPackageId);

        // FOR GET ALL UPDATED VIDEOS FROM THE SUBSCRIPTION //
        $omAdditionalVideos = Videos::getUpdatedVideos($id);
        $vid_arr=Yii::app()->getRequest()->getParam('Videos');
        $dataProvider = new CActiveDataProvider('Videos', array('criteria' => Videos::getUpdatedVideosAsCriteria($id,false,$vid_arr['title'],$vid_arr['genre'],$vid_arr['category'],$vid_arr['age'])));
         
        $this->render('chooseVideoToAddYourSubscriptionTable', array(
            'dataProvider' => $dataProvider,
            'omAdditionalVideos' => $omAdditionalVideos,
            'snTotalAvailableVideo' => ($snAvailableUpdateCount >= 0) ? $snAvailableUpdateCount : 0,
            'snSubscriptionId' => $id,
            'ssType' => $type
        ));
    }
}