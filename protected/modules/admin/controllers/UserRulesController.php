<?php

class UserRulesController extends AdminCoreController {

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
                'actions' => array('create', 'update', 'admin', 'delete'),
                'users' => array('admin'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'UserRules'),
        ));
    }

    public function actionCreate() {
        $model = new UserRules;

        $this->performAjaxValidation($model, 'user-rules-form');

        if (isset($_POST['UserRules'])) {
            //p($_POST['UserRules']);
            if (!isset($_POST['UserRules']['privileges_actions'])) {
                $model->addErrors(array('privileges action not defined!'));
            } else {
                $postData = $_POST['UserRules'];
                $postData['privileges_actions'] = implode(',', $postData['privileges_actions']);
                $model->setAttributes($postData);
                try {
                    if ($model->save()) {
                        if (Yii::app()->getRequest()->getIsAjaxRequest())
                            Yii::app()->end();
                        else
                            $this->redirect(array('view', 'id' => $model->id));
                    }
                } catch (Exception $e) {
                    if ($e->getCode() == 23000) {
                        $model->addErrors(array('Rule already Exists!'));
                    }
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'UserRules');

        $this->performAjaxValidation($model, 'user-rules-form');

        if (isset($_POST['UserRules'])) {
            $postData = $_POST['UserRules'];
            $postData['privileges_actions'] = implode(',', $postData['privileges_actions']);
            $model->setAttributes($postData);


            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        //if (Yii::app()->getRequest()->getIsPostRequest()) 
        try {
            $this->loadModel($id, 'UserRules')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } catch (Exception $e) {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('UserRules');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new UserRules('search');
        $model->unsetAttributes();

        if (isset($_GET['UserRules']))
            $model->setAttributes($_GET['UserRules']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionRevokeRules() {
        $accessModel = new UserAccessControll();
        $accessModel->buildByModule('admin');
        //$accessModel->buildByModule('customer');
        $this->redirect(array('admin'));
    }

}