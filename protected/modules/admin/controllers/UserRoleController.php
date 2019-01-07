<?php

class UserRoleController extends AdminCoreController {

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
                'actions' => array('index', 'view'),
                'users' => array('admin'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete'),
                'users' => array('admin'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'UserRole'),
        ));
    }

    public function actionCreate() {
        $model = new UserRole;

        $this->performAjaxValidation($model, 'user-role-form');

        if (isset($_POST['UserRole'])) {
            $model->setAttributes($_POST['UserRole']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'UserRole');

        $this->performAjaxValidation($model, 'user-role-form');

        if (isset($_POST['UserRole'])) {
            $model->setAttributes($_POST['UserRole']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'UserRole')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('UserRole');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new UserRole('search');
        $model->unsetAttributes();

        if (isset($_GET['UserRole']))
            $model->setAttributes($_GET['UserRole']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxControl() {
        switch (Yii::app()->request->getParam()) {
            case '':

                break;
        }
    }

}