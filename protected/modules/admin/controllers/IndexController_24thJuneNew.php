<?php

class IndexController extends AdminCoreController {

    public $defaultAction = 'index';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->redirect(CController::createUrl('/index/login'));

        $this->layout = 'admin_login';
        $model = new AdminLoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['AdminLoginForm'])) {
            $model->attributes = $_POST['AdminLoginForm'];
            // validate user input and redirect to the previous page if valid

            if ($model->validate()) {
                if ($model->login()) {
                    $this->redirect(Yii::app()->createUrl('admin/index/index'));
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->returnUrl);
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionDocuments() {

        $userId = Yii::app()->admin->id;
        $model = PackageSubscriptionDocuments::getUserDocuments($userId);

        $this->render('documents', array(
            'model' => $model,
        ));
    }

    /**
     * Force Downloads File.
     */
    public function actionDownloadDoc() {
        $file = Yii::app()->request->getParam('file');
        $psid = Yii::app()->request->getParam('psid');
        $getFile = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/' . $psid . '/' . $file;
        if (file_exists($getFile)) {
            return Yii::app()->getRequest()->sendFile($file, @file_get_contents($getFile));
            Yii::app()->end();
        } else {
            $userId = Yii::app()->admin->id;
            $model = PackageSubscriptionDocuments::getUserDocuments($userId);
            Yii::app()->user->setFlash('error', "Error... File cannot be downloaded !!!");
            $this->render('documents', array(
                'model' => $model,
            ));
        }
    }

}