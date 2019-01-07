<?php

class SystemConfigController extends AdminCoreController {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function defaultAccessRules() {
        return array(
            array('deny', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('admin'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'admin', 'minicreate'),
                'users' => array('admin'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'SystemConfig'),
        ));
    }

    public function actionCreate() {
        $model = new SystemConfig;

        $this->performAjaxValidation($model, 'system-config-form');

        if (isset($_POST['SystemConfig'])) {
            $model->setAttributes($_POST['SystemConfig']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('admin'));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'SystemConfig');

        $this->performAjaxValidation($model, 'system-config-form');

        if (isset($_POST['SystemConfig'])) {
            $model->setAttributes($_POST['SystemConfig']);

            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->redirect(array('admin'));
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'SystemConfig')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SystemConfig');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new SystemConfig('search');
        $model->unsetAttributes();

        if (isset($_GET['SystemConfig']))
            $model->setAttributes($_GET['SystemConfig']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}