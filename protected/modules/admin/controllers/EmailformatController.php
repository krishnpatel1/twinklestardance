<?php

class EmailformatController extends AdminCoreController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'EmailFormat'),
        ));
    }

    public function actionCreate() {
        $model = new EmailFormat;


        if (isset($_POST['EmailFormat'])) {
            $model->setAttributes($_POST['EmailFormat']);

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
        $model = $this->loadModel($id, 'EmailFormat');


        if (isset($_POST['EmailFormat'])) {
            $model->setAttributes($_POST['EmailFormat']);
            //echo '<pre>';
            //print_r($model->getAttributes());exit;
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'EmailFormat')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('EmailFormat');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new EmailFormat('search');
        $model->unsetAttributes();

        if (isset($_GET['EmailFormat']))
            $model->setAttributes($_GET['EmailFormat']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}