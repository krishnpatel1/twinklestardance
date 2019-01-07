<?php

class ConfigurationsController extends AdminCoreController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Configurations'),
        ));
    }

    public function actionCreate() {
        $model = new Configurations;

        if (isset($_POST['Configurations'])) {
            $model->setAttributes($_POST['Configurations']);

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
        
        $id = base64_decode($id);
        $model = $this->loadModel($id, 'Configurations');

        if (isset($_POST['Configurations'])) {
            $model->setAttributes($_POST['Configurations']);

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Configuration has been success updasted successfully.");
                $this->redirect(array('update', 'id' => base64_encode($model->id)));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'Configurations')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Configurations');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Configurations('search');
        $model->unsetAttributes();

        if (isset($_GET['Configurations']))
            $model->setAttributes($_GET['Configurations']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}