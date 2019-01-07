<?php

class PagesController extends AdminCoreController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionCreate() {
        $model = new Pages;

        if (isset($_POST['Pages'])) {
            $model->setAttributes($_POST['Pages']);

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
        $model = $this->loadModel($id, 'Pages');


        if (isset($_POST['Pages'])) {
            $model->setAttributes($_POST['Pages']);

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
            //only update status to deleted.
            //$this->loadModel($id, 'Pages')->update(array('status' => 2));
            $model = $this->loadModel($id, 'Pages');
            $model->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionAdmin() {
        $model = new Pages('search');
        $model->unsetAttributes();

        if (isset($_GET['Pages']))
            $model->setAttributes($_GET['Pages']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}