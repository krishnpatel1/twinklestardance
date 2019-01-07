<?php

class AdminModule extends CWebModule {

    public $returnUrl = "/admin/index/index";
    public $homeUrl = "/admin/index/index";
    public $loginUrl = "/admin/index/login";
    public $logoutUrl = "/admin/index/logout";

    /**
     * @var string
     * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
     */
    public $hash = 'md5';

    /**
     * @var boolean
     * @desc use email for activation customer account
     */
    public $sendActivationMail = true;

    public function init() {
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'admin/index/error',
            ),
        ));
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            'application.models.User.*',
            'admin.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            $loginAction = TRUE;

            if ($controller->id == 'index' && $action->id == 'login') {
                $loginAction = FALSE;
            }

            if (Yii::app()->admin->id && $action->id == 'login') {
                Yii::app()->controller->redirect(AdminModule::getUrl('home'));
            }
            if ($controller->id != 'site' && $controller->id != 'repairersreg') {
                if (!Yii::app()->admin->id && $loginAction) {
                    Yii::app()->controller->redirect(AdminModule::getUrl('login'));
                }
            }
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

    public static function getUrl($type = 'home') {
        switch ($type) {
            case 'home':
                return Yii::app()->createUrl(Yii::app()->getModule('admin')->homeUrl);
                break;
            case 'return':
                return Yii::app()->createUrl(Yii::app()->getModule('admin')->returnUrl);
                break;
            case 'login':
                return Yii::app()->createUrl(Yii::app()->getModule('admin')->loginUrl);
                break;
            case 'logout':
                return Yii::app()->createUrl(Yii::app()->getModule('admin')->logoutUrl);
                break;
        }
    }

    public static function getUserData() {
        return Yii::app()->admin->getState('admin');
    }

    public static function getFullName() {
        $data = self::getUserData();
        if (isset($data['fullname']))
            return $data['fullname'];
        else
            return false;
    }

    public static function getUserRoles() {
        $roleId = AdminModule::getUserDataByKey();
        $role = UserRole::model()->findByPk($roleId);
        if ($role) {
            if ($role->parent_id != 0)
                return implode(',', array($role->id, $role->parent_id));
            else
                return $role->id;
        }
        else
            return -1;
    }

    public static function getUserDataByKey() {
        $array = func_get_args();
        $admin = Yii::app()->admin->getState('admin');
        if (isset($admin))
            return $admin['role_id'];
        else
            return true;
    }

    public static function encrypting($string = "") {

        $hash = Yii::app()->getModule('admin')->hash;
        if ($hash == "md5")
            return md5($string);
        if ($hash == "sha1")
            return sha1($string);
        else
            return hash($hash, $string);
    }

    public static function getLoginUrl() {
        if (!Yii::app()->admin->id) {
            return Yii::app()->createUrl('/admin/index/login');
        } else {
            return Yii::app()->createUrl('/admin/index/logout');
        }
    }

    public static function getLoginText() {
        if (!Yii::app()->admin->id) {
            return 'Login';
        } else {
            return 'Logout';
        }
    }

    public static function getWelcomeText() {
        if (Yii::app()->admin->id) {
            $model = Users::model()->findByPk(Yii::app()->admin->id);
            //$admin = Yii::app()->admin->getState('admin');
            $ssName = ($model->last_name != "") ? $model->first_name.' '.$model->last_name : $model->first_name;
            $ssName = ($ssName == "") ? $model->username : $ssName;
            $ssName = ($model->user_type == Yii::app()->params['user_type']['studio']) ? $model->studio_name : $ssName;
            return 'Welcome ' . ucwords($ssName);
        } else {
            return false;
        }
    }
    public static function isAdmin(){
        if (Yii::app()->admin->id) {
            $amUserData = Yii::app()->admin->getState('admin');            
            if($amUserData['role_id'] == UserRole::getRoleIdAsPerType('admin')){
                return true;
            }
            return false;
        }
    }
    public static function isStudioAdmin(){
        if (Yii::app()->admin->id) {
            $amUserData = Yii::app()->admin->getState('admin');            
            if($amUserData['role_id'] == UserRole::getRoleIdAsPerType('studio')){
                return true;
            }
            return false;
        }
    }
    public static function isDancer(){
        if (Yii::app()->admin->id) {
            $amUserData = Yii::app()->admin->getState('admin');            
            if($amUserData['role_id'] == UserRole::getRoleIdAsPerType('dancer')){
                return true;
            }
            return false;
        }
    }
    public static function isInstructor(){
        if (Yii::app()->admin->id) {
            $amUserData = Yii::app()->admin->getState('admin');            
            if($amUserData['role_id'] == UserRole::getRoleIdAsPerType('instructor')){
                return true;
            }
            return false;
        }
    }

}
