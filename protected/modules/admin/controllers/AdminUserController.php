<?php

Yii::import('application.models.AdminUser.*');

class AdminUserController extends AdminCoreController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function defaultAccessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('admin'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'change'),
                'users' => array('admin'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AdminUser();
        if (isset($_POST['AdminUser'])) {

            //$_POST['AdminUser']['created_at']	=	date("Y-m-d H:i:s");

            if (isset($_POST['AdminUser']['password'])) {
                $adminUserObj = new AdminUser();
                $MD5Pwd = $adminUserObj->makeMD5Password($_POST['AdminUser']['password']);
                $_POST['AdminUser']['password'] = $MD5Pwd;
            }

            $model->setAttributes($_POST['AdminUser']);

            if ($_POST['AdminUser']['email'] != '') {
                $Obj = $model->findByAttributes(array('email' => $_POST['AdminUser']['email']));
                if (isset($Obj->attributes)) {
                    $model->attributes = $_POST['AdminUser'];
                    Yii::app()->user->setFlash('error', Yii::t("messages", "There is already an account with this email address, please try again.!"));
                    $this->render('create', array('model' => $model,));
                    Yii::app()->end();
                }
            }

            if ($_POST['AdminUser']['username'] != '') {
                $Obj = $model->findByAttributes(array('username' => $_POST['AdminUser']['username']));

                if (isset($Obj->attributes)) {
                    $model->attributes = $_POST['AdminUser'];
                    Yii::app()->user->setFlash('error', Yii::t("messages", "There is already an account with this User Name, please try again.!"));
                    $this->render('create', array('model' => $model,));
                    Yii::app()->end();
                }
            }

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t("messages", "Thank you for your registration.!"));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $id = Yii::app()->admin->id;
        $model = $this->loadModel($id, 'AdminUser');
        if (isset($_POST['AdminUser'])) {
            $ssOldPwd = $model->password;
            $model->setAttributes($_POST['AdminUser']);

            if (empty($_POST['AdminUser']['password']) && empty($_POST['AdminUser']['rpassword'])) {
                $model->password = $ssOldPwd;
                $model->rpassword = $ssOldPwd;
            } else {
                $model->password = md5($model->password);
                $model->rpassword = md5($_POST['AdminUser']['rpassword']);
            }
            $model->contact_email = $_POST['AdminUser']['contact_email'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t("messages", "Admin settings has been successfully updated."));
                $this->redirect(array('adminUser/update'));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        try {
            if ($id == Yii::app()->admin->id) {
                Yii::app()->user->setFlash('error', 'You can not delete your account!');
                $this->redirect(array('admin'));
            }
            if (Yii::app()->getRequest()->getIsPostRequest() || $id != Yii::app()->admin->id) {
                $this->loadModel($id, 'User')->delete();
                if (!Yii::app()->getRequest()->getIsAjaxRequest())
                    $this->redirect(array('admin'));
            }
            else
                throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        } catch (Exception $e) {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AdminUser('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminUser']))
            $model->attributes = $_GET['AdminUser'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $form = NULL) {
        $model = AdminUser::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = NULL) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChange($id) {

        $model = AdminUser::model()->findByPk((int) $id);
        //$_POST['AdminUser']['password']="admin";

        $modelForm = new ChangePasswordForm();
        if (isset($_POST['ChangePasswordForm']['password'])) {

            if ((count(CJSON::decode(CActiveForm::validate($modelForm))) > 0)) {
                $this->render('change', array(
                    'model' => $modelForm,
                ));
                Yii::app()->end();
            }
            $modelForm->password_repeat = $_POST['ChangePasswordForm']['password_repeat'];
            //print_r($modelForm->password_repeat); die;
            $model->password = md5($modelForm->password_repeat);
            //p($model->password); die;
            $model->save();
            if (!$model->hasErrors()) {
                Yii::app()->user->setFlash('success', "Password change successfully!");
                $this->redirect(array('admin', 'id' => $id));
            } else {
                Yii::app()->user->setFlash('error', "Password change failure!");
                $this->redirect(array('admin', 'id' => $id));
            }
        }
        $this->render('change', array('model' => $modelForm,));
    }

}