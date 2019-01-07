<?php

/**
 * class FacebookController
 * @author Igor Ivanović
 * Used to controll facebook login system
 */
class FacebookController extends Controller {

    /**
     * This method authenticate logged in facebook user
     * @param type $id string(int)
     * @param type $name string
     * @param type $surname string
     * @param type $username string
     * @param type $email string
     * @param type $session string
     */
    public function actionLogin($id = null, $name = null, $surname = null, $username = null, $email = null, $picture = null, $session = null) {

        if (!Yii::app()->request->isAjaxRequest) {
            echo json_encode(array('error' => 'this is not ajax request'));
            die();
        } else {
            if (empty($email)) {
                echo json_encode(array('error' => 'email is not provided'));
                die();
            }
            if ($session == Yii::app()->session->sessionID) {
                //p($_REQUEST);

                $oUserExists = Users::model()->find(array(
                    'condition' => 'email=:email',
                    'params' => array(':email' => $email))
                );
                if (!$oUserExists) {
                    /*
                      $user = new User();
                      $user->email = $email;
                      $user->first_name = $name;
                      $user->last_name = $surname;
                      $user->facebook_id = $username;
                      $user->password = "";
                      $user->is_fblogin = 1;
                      $user->role_id = $_GET['type'];
                      $user->password = md5($username);
                      $user->facebook_picture = "http://graph.facebook.com/" . $username . "/picture?type=large";
                      $user->insert();
                      $identity = new UserIdentity($user->email, $username);
                      $identity->authenticate();
                     * 
                     */

                    $smFbPassword = $username; // Facebook Username is password of TSD account.s
                    $amData = array(
                        'first_name' => $name,
                        'username' => $email,
                        'email' => $email,
                        'password' => md5($smFbPassword),
                        'role_id' => $_GET['user_type'],
                        'user_type' => $_GET['user_type'],
                        'studio_name' => ($_GET['user_type'] == Yii::app()->params['user_type']['studio']) ? $name : NULL,
                        'phone' => NULL,
                        'country_id' => NULL
                    );
                    // FOR ADD NEW USER (DANCER / STUDIO) //
                    $omUser = Users::addUser($amData);

                    //---------------------- START SEND MAIL ------------------------------//                    
                    $ssEmailTemplate = ($_GET['user_type'] == Yii::app()->params['user_type']['studio']) ? "WELCOME_STUDIO" : "WELCOME_DANCER";
                    // FOR GET INSTRUCTOR LOGIN DETAILS MAIL CONTENT FROM DB //
                    $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => $ssEmailTemplate));

                    // REPLACE SOME CONTENT TO PRINT //
                    $amReplaceParams = array(
                        '{USERNAME}' => $email,
                        '{PASSWORD}' => $smFbPassword,
                    );
                    $ssSubject = $omMailContent->subject;
                    $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                    // FOR GET PARENT INFO //
                    $omAdminInfo = Users::model()->findByPk(Yii::app()->params['admin_id']);
                    Common::sendMail($omUser->email, array($omAdminInfo->email => ucfirst($omAdminInfo->first_name . ' ' . $omAdminInfo->last_name)), $ssSubject, $ssBody);
                    //---------------------- END SEND MAIL ------------------------------//
                    // LOGIN INTO TSD SITE //
                    $model = new LoginForm();
                    $identity = $model->fbLogin($email);
                } else {
                    // LOGIN INTO TSD SITE //
                    $model = new LoginForm();
                    $identity = $model->fbLogin($oUserExists->email);
                }

                if ($identity->errorCode === AdminIdentity::ERROR_NONE) {
                    Yii::app()->user->login($identity, NULL);

                    $ssReturnUrl = $this->createUrl('admin/index/index');
                    if (isset($_REQUEST['isDancer'])) {
                        $ssReturnUrl = $this->createUrl('site/addToClass', array(
                            'user_type' => Yii::app()->params['user_type']['dancer'],
                            'isDancer' => 1,
                            'token' => $_REQUEST['token']
                        ));
                    } elseif (isset($_REQUEST['isStudio'])) {
                        $id = Yii::app()->request->getParam('id', 0);
                        $type = Yii::app()->request->getParam('type', '');
                        $ssReturnUrl = $this->createUrl('site/subscriptions', array('id' => $id, 'type' => $type));
                    }
                    echo json_encode(array('error' => 0, 'redirect' => $ssReturnUrl));
                } else {
                    echo json_encode(array('error' => 'user not logged in'));
                    die();
                }
            } else {
                echo json_encode(array('error' => 'session id is not the same'));
                die();
            }
        }
    }

}