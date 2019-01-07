<?php

class SiteController extends GxController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

//    public function defaultAccessRules() {
//        return array();
//    }

    public $layout = 'admin';

    public function actionIndex() {
        if (!Yii::app()->admin->id)
            $this->redirect($this->createUrl("index/login"));

        $this->render('index');
    }

    public function actionforgot() {
        $this->pageTitle = "Forgot Password";
        $model = new ForgotPasswordForm();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-password-form-forgotpassword-form') {
            CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['ForgotPasswordForm'])) {

            if (empty($_POST['ForgotPasswordForm']['email'])) {
                Yii::app()->user->setFlash('error', Yii::t("app", "Email can not be empty."));
                $this->render('forgotpassword', array('model' => $model,));
                Yii::app()->end();
            }

            CActiveForm::validate($model);

            $pwd = $this->generatePassword();
            $Npwd = Yii::app()->getModule('admin')->encrypting($pwd);
            $email = $_POST['ForgotPasswordForm']['email'];
            $user = Users::model()->find("email='$email'");
            if (empty($user->id)) {
                Yii::app()->user->setFlash('error', "Cannot find the email address.!");
                $this->render('forgotpassword', array('model' => $model));
            } else {
                $arr = array('password' => $Npwd);
                $user->attributes = $arr;
                $user->save();

                /*
                  $email = Yii::app()->email;
                  $email->to = $_POST['ForgotPasswordForm']['email'];
                  $email->subject = 'Forgot Password';
                  $content = "<p> Please find the following password</p>";
                  $content.="<span>Password:$pwd</span> <br/>";
                  $content.="<span>Go into your account and reset your password.!</span>";
                  $email->message = $content;
                  $email->send();
                 */
                $content = "<p> Please find the following password</p>";
                $content.= "<span>Password:$pwd</span> <br/>";
                $content.= "<span>Go into your account and reset your password.!</span>";
                $bMailStatus = Common::sendMail($email, array("admin@twinklestardance.com" => 'Admin Email'), 'Forgot Password', $content);

                Yii::app()->user->setFlash('success', "Password sent in your email!");
            }
        }
        // display the forgor password form
        $this->render('forgotpassword', array('model' => $model));
    }

    public function generatePassword() {
        $length = 7;
        $strength = 0;
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    public function actionUpdateOrder() {
        if (Yii::app()->getRequest()->getIsPostRequest() || array_key_exists('token', $_REQUEST)) {
            // FOR REDIRECT TO PAYPAL FOR GET PAYMENT //
            $objPaypal = new Paypal();
            $responseGECD = $objPaypal->GetExpressCheckoutDetails('GetExpressCheckoutDetails');
            $responseDECP = $objPaypal->DoExpressCheckoutPayment('DoExpressCheckoutPayment', $responseGECD);
            $amDecodeParams = (array) json_decode(base64_decode($_REQUEST['reqData']));
            $snOrderId = $amDecodeParams['order_id'];
            $snClassId = $amDecodeParams['class_id'];
            if ($responseDECP['ACK'] == "Success") {

                // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderId);

                // ADD DANCER PURCHASED VIDEOS INTO ORDER TRANSACTION TABLE //                                
                $anVideoIds = $amDecodeParams['videoids'];
                UserVideosTransaction::saveUserVideos($snClassId, $anVideoIds, $snOrderId);

                Yii::app()->user->setFlash('success', "Thank you for purchasing the videos.");
                $this->redirect(CController::createUrl('classes/listClassVideos', array("id" => $snClassId)));
            } else {
                // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                Common::commonUpdateField("orders_dancers", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $snOrderId);
                Yii::app()->user->setFlash('error', "Error in payment.");
                $this->redirect(CController::createUrl('classes/listClassVideos', array("id" => $snClassId)));
            }
        }
    }

}