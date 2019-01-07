<?php

class IndexController extends FrontCoreController {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
        $this->render('error');
    }

    public function actionIndex() {

        // FOR NEWS LETTER SUBSCRIPTION //
        $model = new NewslettersUsers;
        $model->email = 'Email';
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $amPostData = $_POST['NewslettersUsers'];
            $model->setAttributes($amPostData);
            if ($model->validate()) {
                // ADD SUBSCRIBED EMAIL ID INTO NEWS LETTER TABLE //
                if (!Yii::app()->user->isGuest)
                    $model->user_id = Yii::app()->admin->id;
                $model->is_subscribed = 1;
                $model->save(false);
                Yii::app()->user->setFlash('success', "Thank you for joining our mailing list.");
                $this->redirect(array('index'));
            }
        }

        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionCms() {
        if (isset($_REQUEST['id'])) {
            $keyUrl = trim($_REQUEST['id']);
            $pageModel = Pages::model()->find('id = :key OR custom_url_key = :key', array(':key' => $keyUrl));
            if (empty($pageModel)) {
                $this->forward('index');
            }
            $this->pageTitle = $pageModel->meta_title;
            Yii::app()->clientScript->registerMetaTag($pageModel->meta_title, 'Title');
            Yii::app()->clientScript->registerMetaTag($pageModel->meta_description, 'Description');
            Yii::app()->clientScript->registerMetaTag($pageModel->meta_keyword, 'Keywords');
            $this->render('cms', array('pageModel' => $pageModel));
        } else {
            $this->forward('index');
        }
    }

    //update custom url
    public function actionUpdateUrlKey() {
        //update host url

        foreach (Hosts::model()->findAll() as $row) {
            $row->custom_url_key = UtilityHtml::getUrlKey($row->name);
            $row->save(false);
        }
        //update Tv show url
        foreach (Tvshows::model()->findAll() as $row) {
            //$row->update(array('custom_url_key' => UtilityHtml::getUrlKey($row->title)));
            $row->save(false);
        }
        //update keywords url
        foreach (Keywords::model()->findAll() as $row) {
            $row->save(false);
        }
        //update video url
        foreach (Videos::model()->findAll() as $row) {
            $row->save(false);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;
        $smodel = new SignupForm;
        if (isset($_REQUEST['isDancer'])) {
            $smodel->scenario = 'dancer';
        } else {
            $smodel->scenario = 'studio';
        }
        // if it is ajax validation request
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'login-form' || $_POST['ajax'] === 'signup-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data for login        
        if (isset($_POST['LoginForm'])) {
            $amPostData = $_POST['LoginForm'];
            $model->setAttributes($amPostData);
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {

                $ssReturnUrl = CController::createUrl('admin/index/index');
                if (isset($_REQUEST['isDancer'])) {
                    $ssReturnUrl = CController::createUrl('site/addToClass', array('token' => $_REQUEST['token']));
                } elseif (isset($_REQUEST['isStudio'])) {
                    $id = Yii::app()->request->getParam('id', 0);
                    $type = Yii::app()->request->getParam('type', '');
                    $ssReturnUrl = CController::createUrl('site/subscriptions', array('id' => $id, 'type' => $type));
                }
                $this->redirect($ssReturnUrl);
            }
        }
        // collect user input data for login
        if (isset($_POST['SignupForm'])) {
            $amPostData = $_POST['SignupForm'];
            $smodel->attributes = $amPostData;
            // validate user input and redirect to the previous page if valid
            if ($smodel->validate()) {

                $ssRoleId = isset($_REQUEST['isDancer']) ? Yii::app()->params['user_type']['dancer'] : Yii::app()->params['user_type']['studio'];
                $amData = array(
                    'first_name' => $amPostData['name'],
                    'username' => $amPostData['email'],
                    'email' => $amPostData['email'],
                    'password' => md5($amPostData['password']),
                    'role_id' => $ssRoleId,
                    'user_type' => $ssRoleId,
                    'phone' => $amPostData['phone'],
                    'studio_name' => isset($amPostData['studio_name']) ? $amPostData['studio_name'] : NULL,
                    'country_id' => ($amPostData['country_id'] != "" ) ? $amPostData['country_id'] : NULL
                );
                // FOR ADD NEW USER (DANCER / STUDIO) //
                $omUser = Users::addUser($amData);

                $ssEmailTemplate = (isset($amPostData['studio_name'])) ? "WELCOME_STUDIO" : "WELCOME_DANCER";
                // FOR GET INSTRUCTOR LOGIN DETAILS MAIL CONTENT FROM DB //
                $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => $ssEmailTemplate));

                // REPLACE SOME CONTENT TO PRINT //
                $amReplaceParams = array(
                    '{USERNAME}' => $amPostData['email'],
                    '{PASSWORD}' => $amPostData['password'],
                );
                $ssSubject = $omMailContent->subject;
                $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                // FOR GET PARENT INFO //
                $omAdminInfo = Users::model()->findByPk(Yii::app()->params['admin_id']);

                // FOR SEND MAIL //
                Common::sendMail($omUser->email, array($omAdminInfo->email => ucfirst($omAdminInfo->first_name . ' ' . $omAdminInfo->last_name)), $ssSubject, $ssBody);

                // FOR SET RETURN URL AFTER LOGGED IN //
                $ssReturnUrl = CController::createUrl('admin/index/index');
                if (isset($_REQUEST['isDancer'])) {
                    $ssReturnUrl = CController::createUrl('site/addToClass', array('token' => $_REQUEST['token']));
                } elseif (isset($_REQUEST['isStudio'])) {
                    $id = Yii::app()->request->getParam('id', 0);
                    $type = Yii::app()->request->getParam('type', '');
                    $ssReturnUrl = CController::createUrl('site/subscriptions', array('id' => $id, 'type' => $type));
                }
                // FOR LOGIN AFTER SUCCESSFULLY SIGN UP //                
                $model->setAttributes($amPostData);
                $model->username = $amPostData['email'];
                $model->login();

                Yii::app()->user->setFlash('success', "Thank you for registration. please check your mail.");
                $this->redirect($ssReturnUrl);
            }
            $smodel->password = '';
            $smodel->confirmpassword = '';
        }
        // display the login form
        $this->render('login', array('model' => $model, 'smodel' => $smodel));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('http://www.twinklestardance.com');
    }

    /**
     * Displays the login page
     */
    public function actionForgotPassword() {
        $model = new ForgotPasswordForm();

        if (isset($_POST['ForgotPasswordForm'])) {
            $amPostData = $_POST['ForgotPasswordForm'];
            $model->setAttributes($amPostData);
            // validate user input and redirect to the previous page if valid
            if ($model->validate()) {

                $oUser = Users::model()->findByAttributes(array('email' => $amPostData['email']));

                // FOR RESET PASSWORD //
                $smNewPassword = Common::generateToken(6);
                $smEncriptedNewPassword = Yii::app()->getModule('admin')->encrypting($smNewPassword);
                Common::commonUpdateField("users", "password", $smEncriptedNewPassword, "id", $oUser->id);

                // FOR GET INSTRUCTOR LOGIN DETAILS MAIL CONTENT FROM DB //
                $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => "FORGOT_PASSWORD"));
                // REPLACE SOME CONTENT TO PRINT //
                $amReplaceParams = array(
                    '{USERNAME}' => $oUser->username,
                    '{PASSWORD}' => $smNewPassword,
                );
                $ssSubject = $omMailContent->subject;
                $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                // FOR GET PARENT INFO //
                $omAdminInfo = Users::model()->findByPk(Yii::app()->params['admin_id']);

                // FOR SEND MAIL //
                Common::sendMail($oUser->email, array($omAdminInfo->email => ucfirst($omAdminInfo->first_name . ' ' . $omAdminInfo->last_name)), $ssSubject, $ssBody);
                Yii::app()->user->setFlash('success', "Your password will be sent to your mail id.");
                $this->redirect(array('forgotPassword'));
            }
        }
        // display the forgor password form
        $this->render('forgotPassword', array('model' => $model));
    }

    public function actionJoinNewsletter() {
        $this->layout = '..//layouts/popup';
        // FOR NEWS LETTER SUBSCRIPTION //
        $model = new NewslettersUsers;
        $model->email = 'Email';
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $amPostData = $_POST['NewslettersUsers'];
            $model->setAttributes($amPostData);
            if ($model->validate()) {
                // ADD SUBSCRIBED EMAIL ID INTO NEWS LETTER TABLE //
                if (!Yii::app()->user->isGuest)
                    $model->user_id = Yii::app()->admin->id;
                $model->is_subscribed = 1;
                $model->save(false);
                Yii::app()->user->setFlash('success', "Thank you for joining our mailing list.");
                echo Common::closeColorBox();
                Yii::app()->end();
            }
        }
        // display the forgor password form
        $this->render('joinNewsletter', array('model' => $model));
    }

    public function actionUnsubscribe($id) {

        $snId = base64_decode($id);
        $omNewsletterUsers = NewslettersUsers::model()->findByPk($snId);
        if ($omNewsletterUsers) {
            $omNewsletterUsers->is_subscribed = 0;
            $omNewsletterUsers->save(false);
        }
        $this->render('sub_unsub', array(
            'omNewsletterUsers' => $omNewsletterUsers
        ));
    }

    public function actionSubscribe($id) {

        $snId = base64_decode($id);
        $omNewsletterUsers = NewslettersUsers::model()->findByPk($snId);
        if ($omNewsletterUsers) {
            $omNewsletterUsers->is_subscribed = 1;
            $omNewsletterUsers->save(false);
        }
        $this->render('sub_unsub', array(
            'omNewsletterUsers' => $omNewsletterUsers
        ));
    }

    /*
      protected function afterRender($view, &$output) {
      parent::afterRender($view, $output);
      //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
      Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
      Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
      return true;
      } */
}