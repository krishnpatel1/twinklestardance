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
    public function actionLogout() 
    {
        unset($_SESSION['display_subscription']);
        
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

    public function actionSendNewsletter() {

        $oModel = new SendNewsletterForm();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $amPostData = $_POST['SendNewsletterForm'];
            $oModel->setAttributes($amPostData);

            if ($oModel->validate()) {
                // FOR GET ALL SIGNED UP USERS FOR TSD NEWS LETTERS //
                $oCriteria = new CDbCriteria();
                $oCriteria->condition = "is_subscribed = 1";
                $omSignedUpUsers = NewslettersUsers::model()->findAll($oCriteria);
                if ($omSignedUpUsers) {
                    foreach ($omSignedUpUsers as $omDataSet) {

                        $ssBody = $oModel->body;
                        $ssBody .= '<div style="margin-top:55px;background:#404040;min-height: 50px;font-size: 11px;color:#fff;width:100%;">';
                        $ssBody .= '<p>Don\'t want our emails anymore? ' . CHtml::link('Unsubscribe here in one click.', Yii::app()->createAbsoluteUrl('/index/unsubscribe', array('id' => base64_encode($omDataSet->id))), array('style' => 'color:#0066FF;')) . '</p>';
                        $ssBody .= '</div>';

                        // FOR GET PARENT INFO //
                        $omAdminInfo = Users::model()->findByPk(Yii::app()->params['admin_id']);

                        // FOR SEND MAIL //
                        Common::sendMail($omDataSet->email, array($omAdminInfo->email => ucfirst($omAdminInfo->first_name . ' ' . $omAdminInfo->last_name)), $oModel->subject, $ssBody);
                    }
                    Yii::app()->user->setFlash('success', "Newsletter has been successfully send to subscribed users.");
                    $this->redirect(array('index/sendNewsletter'));
                }
            }
        }
        $this->render('sendNewsletter', array(
            'model' => $oModel
        ));
    }

}