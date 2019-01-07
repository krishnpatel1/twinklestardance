<?php

class UsersController extends AdminCoreController {

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
            'model' => $this->loadModel($id, 'Users'),
        ));
    }

    public function actionCreate() {
        $model = new Users;


        if (isset($_POST['Users'])) {
            $model->setAttributes($_POST['Users']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else {
                    Yii::app()->user->setFlash('success', "Studio is successfully saved !!!");
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {

        $model = $this->loadModel($id, 'Users');
        $model->scenario = 'update';
        $snCountryId = ($model->country_id > 0) ? $model->country_id : Yii::app()->params['default_country']['US'];
        $omStates = StateMaster::getStatesAsPerCountry($snCountryId);
        $amStates = CHtml::listData($omStates, 'id', 'state_name');

        if (isset($_POST['Users'])) {
            $amPostData = $_POST['Users'];
            unset($amPostData['picture']);
            $ssOldPicture = $model->picture;
            $ssOldPwd = $model->password;

            $model->setAttributes($amPostData);

            // IMAGE SAVE HERE
            if ($_FILES['Users']['name']['picture'] != "") {
                $oImage = CUploadedFile::getInstance($model, 'picture');
                $model->picture = $oImage;
                if (is_object($oImage)) {
                    // FOR UPLOAD ORGINAL IMAGE //
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $amImageInfo = explode(".", $model->picture);
                    $ssImageName = Yii::app()->params['user_prefix'] . time() . '.' . $amImageInfo[1];
                    $ssSaveImageFile = $ssUploadPath . '/uploads/users/' . $ssImageName;
                    $model->picture->saveAs($ssSaveImageFile);
                    $model->picture = $ssImageName;

                    // GENERATE THUMBNAIL //
                    $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                    $ssImgThumbWidth = SystemConfig::getValue('user_thumb_width');
                    $ssImgThumbHeight = SystemConfig::getValue('user_thumb_height');
                    $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                    $ssStoreThumbImage = $ssUploadPath . '/uploads/users/thumb/' . $ssImageName;
                    $oThumb->save($ssStoreThumbImage);

                    // FOR REMOVE OLD IMAGE //
                    $ssOrigPath = $ssUploadPath . '/uploads/users/';
                    $ssThumbPath = $ssUploadPath . '/uploads/users/thumb/';
                    Common::removeOldImage($ssOldPicture, $ssOrigPath, $ssThumbPath);
                }
            }
            if (empty($amPostData['password'])) {
                $model->password = $ssOldPwd;
            } else {
                $model->password = md5($model->password);
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Records has been successfully updated");
                $this->redirect(array('users/index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'amStates' => $amStates
        ));
    }

    public function actionDelete($id) {
        $oModel = $this->loadModel($id, 'Users');
        if ($oModel) {
            // FOR REMOVE OLD IMAGE //
            $ssOrigPath = $ssUploadPath . '/uploads/users/';
            $ssThumbPath = $ssUploadPath . '/uploads/users/thumb/';
            Common::removeOldImage($oModel->picture, $ssOrigPath, $ssThumbPath);
            $oModel->delete();
            Yii::app()->user->setFlash('success', "Record has been successfully deleted");
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $model = new Users($scenario = 'search');
        $model->unsetAttributes();
        if (Yii::app()->request->isPostRequest) {
            $model->q = $_POST['Users']['q'];
        }
        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionAdmin() {
        $model = new Users('search');
        $model->unsetAttributes();

        if (isset($_GET['Users']))
            $model->setAttributes($_GET['Users']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionListInstructorsDancers($user_type) {
        $oCriteria = Users::getInstructorsOrDancers(Yii::app()->admin->id, $user_type);
        //$dataProvider = new CActiveDataProvider("Users", array('criteria' => $oCriteria));
        $dataProvider = new CActiveDataProvider('Users', array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
                )
        );
        $this->render('instructors_dancers', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    public function actionListInstructorsDancersTable($user_type) {
        // FOR DELETE SELECTED INSTRUCTORS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anDeletedIds = isset($_POST['deleteids']) ? $_POST['deleteids'] : array();
            if (count($anDeletedIds) > 0) {
                $bDeleted = Users::removeSelectedItems($anDeletedIds);
                if ($bDeleted) {
                    Yii::app()->user->setFlash('success', "Record has been successfully deleted");
                    //$this->redirect(array('admin'));
                }
            }
        }
        
        $users_ar=Yii::app()->getRequest()->getParam('Users');
        $oCriteria = Users::getInstructorsOrDancers(Yii::app()->admin->id, $user_type,$users_ar['name'],$users_ar['last_name'],$users_ar['email']);
        
        //$dataProvider = new CActiveDataProvider("Users", array('criteria' => $oCriteria));
        $dataProvider = new CActiveDataProvider('Users', array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
                )
        );
        $this->render('instructors_dancers_table', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAddEditInstructorsDancers($user_type) {

        $snInstructorDancerId = Yii::app()->getRequest()->getParam('id', '');
        $model = ($snInstructorDancerId != '' && $snInstructorDancerId > 0) ? $this->loadModel($snInstructorDancerId, 'Users') : new Users;
        $bIsNewRecord = false;

        // FOR SET MODEL SCENARIO //
        if ($model->isNewRecord) {
            $bIsNewRecord = true;
            $model->scenario = 'add_instructor';
        }
        else
            $model->scenario = 'edit_instructor';

        if (isset($_POST['Users'])) {
            $amPostData = $_POST['Users'];
            unset($amPostData['picture']);
            $ssOldPicture = $model->picture;
            $ssBeforeEncodePwd = "";
            if (trim($amPostData['password']) == "")
                unset($amPostData['password']);
            else {
                $ssBeforeEncodePwd = $amPostData['password'];
                $amPostData['password'] = md5($amPostData['password']);
            }

            $model->setAttributes($amPostData);
            $model->parent_id = Yii::app()->admin->id;
            $model->user_type = $user_type;
            $model->role_id = UserRole::getRoleIdAsPerType(Common::getUserTypeAsPerValue($user_type, true));

            // IMAGE SAVE HERE
            if ($_FILES['Users']['name']['picture'] != "") {
                $oImage = CUploadedFile::getInstance($model, 'picture');
                $model->picture = $oImage;
                if (is_object($oImage)) {
                    // FOR UPLOAD ORGINAL IMAGE //
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $amImageInfo = explode(".", $model->picture);
                    $ssImageName = Yii::app()->params['inst_prefix'] . time() . '.' . $amImageInfo[1];
                    $ssSaveImageFile = $ssUploadPath . '/uploads/users/' . $ssImageName;
                    $model->picture->saveAs($ssSaveImageFile);
                    $model->picture = $ssImageName;

                    // GENERATE THUMBNAIL //
                    $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                    $ssImgThumbWidth = SystemConfig::getValue('user_thumb_width');
                    $ssImgThumbHeight = SystemConfig::getValue('user_thumb_height');
                    $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                    $ssStoreThumbImage = $ssUploadPath . '/uploads/users/thumb/' . $ssImageName;
                    $oThumb->save($ssStoreThumbImage);

                    // FOR REMOVE OLD IMAGE //
                    $ssOrigPath = $ssUploadPath . '/uploads/users/';
                    $ssThumbPath = $ssUploadPath . '/uploads/users/thumb/';
                    Common::removeOldImage($ssOldPicture, $ssOrigPath, $ssThumbPath);
                }
            }
            if ($model->save()) {

                if ($bIsNewRecord) {
                    // FOR GET INSTRUCTOR LOGIN DETAILS MAIL CONTENT FROM DB //
                    $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => "WELCOME_INSTRUCTOR"));

                    // REPLACE SOME CONTENT TO PRINT //
                    $amReplaceParams = array(
                        '{USERNAME}' => $model->username,
                        '{PASSWORD}' => $ssBeforeEncodePwd,
                    );
                    $ssSubject = $omMailContent->subject;
                    $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                    // FOR GET PARENT INFO //
                    $amAdminInfo = AdminModule::getUserData();

                    // FOR SEND MAIL //
                    Common::sendMail($model->email, array($amAdminInfo['email'] => ucfirst($amAdminInfo['studio_name'])), $ssSubject, $ssBody);
                }

                Yii::app()->user->setFlash('success', "Records has been successfully added");
                $this->redirect(CController::createUrl("users/listInstructorsDancers", array('user_type' => $user_type)));
            }
        }

        $amResult = $amSelected = array();

        // FOR GET ALL INSTRUCTOR OR STUDENTS AS PER PARENT ID //
        $oModel = Classes::getAllClassesCreateByUser(Yii::app()->admin->id);
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET CLASS USERS //
        $omModelTrans = ClassUsers::getUserClasses($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'class_id', 'user_id');

        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }

        $this->render('addEdit', array(
            'model' => $model,
            'user_type' => $user_type,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'omModelTrans' => $omModelTrans
        ));
    }

    public function actionAddToClass($id) {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'Users');

        // SAVE USER's (INSTRUCTOR/DANCERS) AS PER CLASS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            //p($_REQUEST);
            $anClassIds = isset($_POST['class_ids']) ? $_POST['class_ids'] : array();
            if (count($anClassIds) > 0) {
                ClassUsers::addClasses($model->id, $anClassIds);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();

        // FOR GET ALL INSTRUCTOR OR STUDENTS AS PER PARENT ID //
        $oModel = Classes::getAllClassesCreateByUser(Yii::app()->admin->id);
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET CLASS USERS //
        $omModelTrans = ClassUsers::getUserClasses($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'class_id', 'user_id');

        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }

        $this->render('addToClass', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected
        ));
    }

    public function actionRemoveFromClass($id) {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $snUserId = Yii::app()->getRequest()->getParam('user_id', '');
            $bResponse = ClassUsers::removeClasUsers($id, $snUserId);
            echo $bResponse;
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
        Yii::app()->end();
    }

    public function actionSettings() {
        $id = Yii::app()->admin->id;
        $model = $this->loadModel($id, 'Users');
        $model->scenario = 'settings';
        if (isset($_POST['Users'])) {
            //p($_POST);
            $ssOldPwd = $model->password;
            // p($_POST['Users']);
            $model->setAttributes($_POST['Users']);

            if (empty($_POST['Users']['password']) && empty($_POST['Users']['rpassword'])) {
                $model->password = $ssOldPwd;
                $model->rpassword = $ssOldPwd;
            } else {
                $model->password = md5($model->password);
                $model->rpassword = md5($_POST['Users']['rpassword']);
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t("messages", "Your settings has been successfully updated."));
                $this->redirect(array('users/settings'));
            }
        }
        $this->render('settings', array('model' => $model));
    }

    public function actionMyAccounts() {
        $snStudioId = Yii::app()->admin->id;
        $oCriteria = OrderDetails::getStudioOrders($snStudioId, true);

        $oDataprovider = new CActiveDataProvider("OrderDetails", array(
            'criteria' => $oCriteria,
        ));

        $this->render('studio_orders', array(
            'model' => $oDataprovider,
        ));
    }

    public function actionGetRequestForMonthlySub() {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $snCartId = Yii::app()->getRequest()->getParam('id', 0);
            $oCart = Cart::model()->findByPk($snCartId);
            if ($oCart) {
                // FOR UPDATE REQUEST //
                $snIsApproved = Yii::app()->getRequest()->getParam('is_approve', 0);
                $bIsUpdated = Common::commonUpdateField("cart", "is_admin_approved", $snIsApproved, "id", $snCartId);

                // FOR SEND APPROVAL MAIL TO USER //
                $amCriteria = ($snIsApproved == 1) ? array('file_name' => "STUDIO_REQUEST_APPROVE") : array('file_name' => "STUDIO_REQUEST_REJECT");
                $omMailContent = EmailFormat::model()->findByAttributes($amCriteria);
                // REPLACE SOME CONTENT TO PRINT //
                $amReplaceParams = array(
                    '{USERNAME}' => $oCart->user->studio_name,
                    '{SUBSCRIPTION}' => $oCart->packageSubscription->name,
                    '{CHECKOUT_URL}' => Yii::app()->params['site_url'] . Yii::app()->createUrl('/site/cart')
                );
                $ssSubject = $omMailContent->subject;
                $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                // FOR SEND TO ADMIN MAIL //
                Common::sendMail($oCart->user->email, array(Yii::app()->params['adminEmail'] => 'TSD Team'), $ssSubject, $ssBody);
                Yii::app()->user->setFlash('success', "Request has been successfully updated");
            } else {
                Yii::app()->user->setFlash('error', "Error in request!");
            }

            Yii::app()->end();
        }
        $oCriteria = new CDbCriteria();
        $oCriteria->condition = "(is_admin_approved  = 0 OR is_admin_approved  = 2) AND duration = 1";
        $oCriteria->order = "id DESC";

        $dataProvider = new CActiveDataProvider('Cart', array(
            'criteria' => $oCriteria
        ));
        $this->render('getRequestForMonthlySub', array(
            'model' => $dataProvider
        ));
    }

}