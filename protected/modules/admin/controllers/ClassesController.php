<?php

class ClassesController extends AdminCoreController
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
           'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Classes'),
        ));
    }

    public function actionCreate()
    {
        $model = new Classes;

        if (isset($_POST['Classes'])) {
            $amPostData = $_POST['Classes'];
            unset($amPostData['image_url']);
            $ssOldImage = $model->image_url;
            if (isset($amPostData['days_of_week'])) {
                $amPostData['days_of_week'] = implode(",", $amPostData['days_of_week']);
            }
            $model->setAttributes($amPostData);
            $model->token = Common::generateToken(16);

            // IMAGE SAVE HERE
            if ($_FILES['Classes']['name']['image_url'] != "") {
                $oImage = CUploadedFile::getInstance($model, 'image_url');
                $model->image_url = $oImage;
                if (is_object($oImage)) {

                    // CREATE PACKAGE/SUBSCRIPTION ID DIRECTORY IF NOT EXISTS //
                    $snStudioId = Yii::app()->admin->id;
                    $ssDirectoryPath = Yii::getPathOfAlias('webroot') . '/uploads/users/classes/';
                    Common::createDirectory($snStudioId, $ssDirectoryPath);

                    // CREATE CLASS THUMBNAIL DIRECTORY IF NOT EXISTS //
                    $ssThumbDirectoryName = "thumb";
                    $ssDirectoryPath = Yii::getPathOfAlias('webroot') . "/uploads/users/classes/$snStudioId/";
                    Common::createDirectory($ssThumbDirectoryName, $ssDirectoryPath);

                    // FOR UPLOAD ORGINAL IMAGE //
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $amImageInfo = explode(".", $model->image_url);
                    $ssImageName = Yii::app()->params['classes_prefix'] . time() . '.' . $amImageInfo[1];
                    $ssSaveImageFile = $ssUploadPath . "/uploads/users/classes/$snStudioId/$ssImageName";
                    $model->image_url->saveAs($ssSaveImageFile);
                    $model->image_url = $ssImageName;

                    // GENERATE THUMBNAIL //
                    $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                    $ssImgThumbWidth = Yii::app()->params['class_thumb_width'];
                    $ssImgThumbHeight = Yii::app()->params['class_thumb_height'];
                    $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                    $ssStoreThumbImage = $ssUploadPath . "/uploads/users/classes/$snStudioId/thumb/$ssImageName";
                    $oThumb->save($ssStoreThumbImage);

                    // FOR REMOVE OLD IMAGE //
                    $ssOrigPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/";
                    $ssThumbPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/thumb/";
                    Common::removeOldImage($ssOldImage, $ssOrigPath, $ssThumbPath);
                }
            } else {
                $model->image_url = ($model->static_image_url) ? $model->static_image_url : '';
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id, 'Classes');

        if (isset($_POST['Classes'])) {

            $amPostData = $_POST['Classes'];
            unset($amPostData['image_url']);
            $ssOldImage = $model->image_url;
            if (isset($amPostData['days_of_week'])) {
                $amPostData['days_of_week'] = implode(",", $amPostData['days_of_week']);
            }
            $model->setAttributes($amPostData);
            $snStudioId = Yii::app()->admin->id;
            // IMAGE SAVE HERE
            if ($_FILES['Classes']['name']['image_url'] != "") {
                $oImage = CUploadedFile::getInstance($model, 'image_url');
                $model->image_url = $oImage;
                if (is_object($oImage)) {

                    // CREATE PACKAGE/SUBSCRIPTION ID DIRECTORY IF NOT EXISTS //                    
                    $ssDirectoryPath = Yii::getPathOfAlias('webroot') . '/uploads/users/classes/';
                    Common::createDirectory($snStudioId, $ssDirectoryPath);

                    // CREATE CLASS THUMBNAIL DIRECTORY IF NOT EXISTS //
                    $ssThumbDirectoryName = "thumb";
                    $ssDirectoryPath = Yii::getPathOfAlias('webroot') . "/uploads/users/classes/$snStudioId/";
                    Common::createDirectory($ssThumbDirectoryName, $ssDirectoryPath);

                    // FOR UPLOAD ORGINAL IMAGE //
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $amImageInfo = explode(".", $model->image_url);
                    $ssImageName = Yii::app()->params['classes_prefix'] . time() . '.' . $amImageInfo[1];
                    $ssSaveImageFile = $ssUploadPath . "/uploads/users/classes/$snStudioId/$ssImageName";
                    $model->image_url->saveAs($ssSaveImageFile);
                    $model->image_url = $ssImageName;

                    // GENERATE THUMBNAIL //
                    $oThumb = Yii::app()->phpThumb->create($ssSaveImageFile);
                    $ssImgThumbWidth = Yii::app()->params['class_thumb_width'];
                    $ssImgThumbHeight = Yii::app()->params['class_thumb_height'];
                    $oThumb->resize($ssImgThumbWidth, $ssImgThumbHeight);
                    $ssStoreThumbImage = $ssUploadPath . "/uploads/users/classes/$snStudioId/thumb/$ssImageName";
                    $oThumb->save($ssStoreThumbImage);

                    // FOR REMOVE OLD IMAGE //
                    $ssOrigPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/";
                    $ssThumbPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/thumb/";
                    Common::removeOldImage($ssOldImage, $ssOrigPath, $ssThumbPath);
                }
            } else {
                if ($model->static_image_url != "") {
                    $ssUploadPath = Yii::getPathOfAlias('webroot');
                    $ssOrigPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/";
                    $ssThumbPath = $ssUploadPath . "/uploads/users/classes/$snStudioId/thumb/";
                    Common::removeOldImage($ssOldImage, $ssOrigPath, $ssThumbPath);
                    $model->image_url = $model->static_image_url;
                }
                //$model->image_url = ($model->static_image_url) ? $model->static_image_url : $ssOldImage;
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $amResult = $amSelected = array();

        // FOR GET ALL INSTRUCTOR OR STUDENTS AS PER PARENT ID //
        $oModel = Users::getAllInstructorsOrStudents(Yii::app()->admin->id);
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET CLASS USERS //
        $omModelTrans = ClassUsers::getClassUsers($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'user_id', 'class_id');

        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }

        // FOR GET ALL VIDEOS OF CLASSE //
        $omClassVideos = ClassVideos::model()->findAll("class_id =:classID", array(":classID" => $model->id));

        // FOR GET ALL DOCUMENTS OF PACKAGE/SUBSCRIPTION //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "class_id =:snClassID";
        $omCriteria->params = array(':snClassID' => $id);
        $omDocuments = ClassDocuments::model()->findAll($omCriteria);

        $this->render('update', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected,
            'omModelTrans' => $omModelTrans,
            'omClassVideos' => $omClassVideos,
            'omDocuments' => $omDocuments
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'Classes')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex()
    {
        // FOR GET DATA AS PER USER ROLE WISE //
        $snLoggedInUserId = Yii::app()->admin->id; // (studio,instructor,dancer)
        $oCriteria = Classes::getAllClassesCreateByUser($snLoggedInUserId, true);

        //$dataProvider = new CActiveDataProvider('Classes', array('criteria' => $oCriteria));
        $dataProvider = new CActiveDataProvider('Classes', array(
                'criteria' => $oCriteria,
                'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
            )
        );
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {        
        $this->layout = '..//layouts/admin';
        $model = new Classes('search');
        $model->unsetAttributes();

        $to_start_date="";
        $to_end_date="";
        $from_start_date="";
        $from_end_date="";
        if(isset($_GET['to_start_date']))
        {                        
            $to_start_date=$_GET['to_start_date'];
            $to_end_date=$_GET['to_end_date'];
            $from_start_date=$_GET['from_start_date'];
            $from_end_date=$_GET['from_end_date'];
        }
        $name="";
        if (isset($_GET['Classes'])){
            $model->setAttributes($_GET['Classes']);
            $name=$_GET['Classes']['name'];
        }
        $snLoggedInUserId = Yii::app()->admin->id; // (studio,instructor,dancer)
        $oCriteria = Classes::getAllClassesCreateByUser($snLoggedInUserId, true,$to_start_date,$to_end_date,$from_start_date,$from_end_date,$name);

        //$dataProvider = new CActiveDataProvider('Classes', array('criteria' => $oCriteria));
        $dataProvider = new CActiveDataProvider('Classes', array(
                'criteria' => $oCriteria,
                'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
            )
        );
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAddUsers($id, $user_type)
    {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'Classes');

        // SAVE USER's (INSTRUCTOR/DANCERS) AS PER CLASS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            //p($_REQUEST);
            $anUserIds = isset($_POST['user_ids']) ? $_POST['user_ids'] : array();
            if (count($anUserIds) > 0) {
                ClassUsers::addUsers($model->id, $anUserIds, $user_type);
            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();

        // FOR GET ALL INSTRUCTOR OR STUDENTS AS PER PARENT ID //
        $oModel = Users::getAllInstructorsOrStudents(Yii::app()->admin->id, $user_type);
        $amResult = CHtml::listData($oModel, 'id', 'name');

        // FOR GET CLASS USERS //
        $omModelTrans = ClassUsers::getClassUsers($model->id);
        $amSelectedResult = CHtml::listData($omModelTrans, 'user_id', 'class_id');

        foreach ($amSelectedResult as $snSubId => $ssValue) {
            $amSelected[] = $snSubId;
        }
        $this->render('addUsers', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected
        ));
    }

    public function actionRemoveUsers($id)
    {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $snClassId = Yii::app()->getRequest()->getParam('class_id', '');
            $bResponse = ClassUsers::removeClasUsers($snClassId, $id);
            echo $bResponse;
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
        Yii::app()->end();
    }

    public function actionListClassVideos($id)
    {
        $model = $this->loadModel($id, 'Classes');

        // FOR CHECK CLASS IS TO BE FINISHED OR NOT FOR DANCER & INSTRUCTOR //
        $omResultData = Classes::checkIsClassEnd($model->id);
        if (!$omResultData)
            throw new CHttpException(400, Yii::t('app', 'Class duration has been expired!'));

        if (Yii::app()->getRequest()->getIsPostRequest() && AdminModule::isDancer()) {
            $anVideoIds = isset($_POST['videoids']) ? $_POST['videoids'] : array();
            if (count($anVideoIds) > 0) {
                $this->redirect(CController::createUrl('classes/makePayment', array('id' => $model->id, 'videoids' => base64_encode(implode(',', $anVideoIds)))));
            }
        }
        // FOR GET CRITERIA OF CLASS VIDEOS //
        $oCriteria = Classes::getClassVideos($id, true);
        $dataProvider = new CActiveDataProvider("Classes", array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['listPerPageLimit'])
        ));

        // FOR GET ORDER INFO WHEN USER PURCHASED ANY SUBSCRIPTION FOR E-COMMERCE TRACKING //
        $omOrderInfo = false;
        if (Yii::app()->user->hasFlash('order_info')) {
            $omOrderInfo = Orders::model()->findByPk(Yii::app()->user->getFlash('order_info'));
        }

        $this->render('listClassVideos', array(
            'dataProvider' => $dataProvider,
            'oModelClass' => $model,
            'omOrderInfo' => $omOrderInfo,
            'classId' =>$id
        ));
    }
    
    public function actionListClassVideosTable($id)
    {
        $model = $this->loadModel($id, 'Classes');

        // FOR CHECK CLASS IS TO BE FINISHED OR NOT FOR DANCER & INSTRUCTOR //
        $omResultData = Classes::checkIsClassEnd($model->id);
        if (!$omResultData)
            throw new CHttpException(400, Yii::t('app', 'Class duration has been expired!'));

        if (Yii::app()->getRequest()->getIsPostRequest() && AdminModule::isDancer()) {
            $anVideoIds = isset($_POST['videoids']) ? $_POST['videoids'] : array();
            if (count($anVideoIds) > 0) {
                $this->redirect(CController::createUrl('classes/makePayment', array('id' => $model->id, 'videoids' => base64_encode(implode(',', $anVideoIds)))));
            }
        }
        // FOR GET CRITERIA OF CLASS VIDEOS //
        $vid_arr=Yii::app()->getRequest()->getParam('Videos');
        $oCriteria = Classes::getClassVideos($id, true,$vid_arr['title'],$vid_arr['genre'],$vid_arr['category'],$vid_arr['age']);
        $dataProvider = new CActiveDataProvider("Classes", array(
            'criteria' => $oCriteria,
            'pagination' => array('pageSize' => Yii::app()->params['listPerPageLimit'])
        ));

        // FOR GET ORDER INFO WHEN USER PURCHASED ANY SUBSCRIPTION FOR E-COMMERCE TRACKING //
        $omOrderInfo = false;
        if (Yii::app()->user->hasFlash('order_info')) {
            $omOrderInfo = Orders::model()->findByPk(Yii::app()->user->getFlash('order_info'));
        }

        $this->render('listClassVideosTable', array(
            'dataProvider' => $dataProvider,
            'oModelClass' => $model,
            'omOrderInfo' => $omOrderInfo,
            'classId' =>$id
        ));
    }

    public function actionMakePayment()
    {
        // FOR PURCHASE VIDEO BY DANCER
        $snClassId = Yii::app()->getRequest()->getParam('id', 0);
        $anVideoIds = base64_decode(Yii::app()->getRequest()->getParam('videoids', array()));
        $model = $this->loadModel($snClassId, 'Classes');
        $oCreditCardForm = new CreditCardForm();
        if (Yii::app()->getRequest()->getIsPostRequest() && AdminModule::isDancer()) {
            $snTotalPrice = $_POST['totamount'];
            if (count(explode(',', $anVideoIds)) > 0) {
                if ($snTotalPrice > 0) {
                    // FOR ADD USER (DANCER) ORDER WITH PENDING PAYMENT STATUS //
                    $amPaymentInfo = array(
                        'user_id' => Yii::app()->admin->id,
                        'payment_status' => Yii::app()->params['amPaymentStatus']['pending'],
                        'sub_total' => $snTotalPrice,
                        'tax' => 0,
                        'amount_paid' => $snTotalPrice,
                        'shipping' => 0,
                        'payment_date' => date('Y-m-d H:i:s'),
                        'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 year'))
                    );
                    //$omOrder = OrdersDancers::saveDancerOrder($amPaymentInfo);
                    $omOrder = Orders::saveDancerOrder($amPaymentInfo);

                    // ADD DANCER PURCHASED VIDEOS INTO ORDER TRANSACTION TABLE //
                    UserVideosTransaction::saveUserVideos($model->id, explode(',', $anVideoIds), $omOrder->id);

                    $this->redirect(Yii::app()->createUrl('admin/classes/payflowFullPayment', array('order_id' => $omOrder->id, 'class_id' => $model->id)));

                    // FOR MAKE PAYMENT THROUGH PAYPAL ACCOUNT //
                    //$this->callPayPalService($model->id, explode(',', $anVideoIds), $omOrder->id, $snTotalPrice);
                }
                //Yii::app()->user->setFlash('success', "Thank you for purchasing the videos.");
                //$this->redirect(CController::createUrl("classes/listClassVideos", array("id" => $model->id)));
            }

        }
        $listCountry = Common::getListCountry();
        $purchaseDetails = Common::getPurchaseDetails($anVideoIds);
        $this->render('makePayment', array(
            'oModelClass' => $model,
            'smSelectedVideos' => base64_encode($anVideoIds),
            'oCreditCardForm' => $oCreditCardForm,
            'listCountry' => $listCountry,
            'purchaseDetails' => $purchaseDetails
        ));
    }

    public function actionPayflowFullPayment($order_id, $class_id)
    {
        if (!Yii::app()->admin->id)
            $this->redirect(array('/index/login'));
        $PayFlowPaymentForm = new PayFlowPaymentForm();
        $PayFlowPaymentForm->scenario = 'full_payment';
        $omUser = Users::model()->findByPk(Yii::app()->admin->id);
        $omOrder = Orders::model()->findByPk($order_id);
        if ($omUser) {
            $PayFlowPaymentForm->first_name = $omUser->first_name;
            $PayFlowPaymentForm->last_name = $omUser->last_name;
            $PayFlowPaymentForm->email = $omUser->email;
            $PayFlowPaymentForm->address_1 = $omUser->address_1;
            $PayFlowPaymentForm->city = $omUser->city;
            $PayFlowPaymentForm->zip = $omUser->zip;
            $PayFlowPaymentForm->phone_number = $omUser->phone;
        }

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $amPostData = $_POST['PayFlowPaymentForm'];

            $PayFlowPaymentForm->setAttributes($amPostData);

            if ($PayFlowPaymentForm->validate()) {
                // MAKE DIRECT PAYMENT THROUGH PAYFLOW PRO API //
                $amResponse = $this->payFlowExpressCheckout($PayFlowPaymentForm->attributes, $omOrder->amount_paid);
                if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) {

                    // UPDATE INTO ORDER DUE PAYMENT STATUS //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $omOrder->id);

                    Yii::app()->user->setFlash('order_info', $omOrder->id);
                    Yii::app()->user->setFlash('success', "Thank you for purchasing the videos.");
                    $this->redirect(CController::createUrl("classes/listClassVideos", array("id" => $class_id)));
                } else {
                    $ssMessage = isset(Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']]) ? Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']] : "There are some error in payment. Try again later.";
                    $ssMessage = 'Error Code: ' . $amResponse['RESULT'] . ' Error Message: ' . $ssMessage;
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $omOrder->id);
                    Common::commonUpdateField("orders", "payment_error_message", $ssMessage, "id", $omOrder->id);
                    Yii::app()->user->setFlash('error', $ssMessage);
                }
            }
        }

        $omStates = StateMaster::getStatesAsPerCountry(Yii::app()->params['default_country']['US']);
        $amStates = CHtml::listData($omStates, 'state_abbv', 'state_name');
        $this->render('payflowFullPayment', array(
            'PayFlowPaymentForm' => $PayFlowPaymentForm,
            'snCheckoutPrice' => $omOrder->amount_paid,
            'omUser' => $omUser,
            'amStates' => $amStates
        ));
    }

    public function payFlowExpressCheckout($amPaymentData, $snAmount)
    {

        $oPayFlow = new PayPalPayflowPro();

        //these are provided by your payflow reseller
        $oPayFlow->PARTNER = (Configurations::getValue('paypal_partner') != '') ? Configurations::getValue('paypal_partner') : Yii::app()->params['PARTNER'];
        $oPayFlow->USER = (Configurations::getValue('paypal_merchant_login') != '') ? Configurations::getValue('paypal_merchant_login') : Yii::app()->params['LOGIN'];
        $oPayFlow->PWD = (Configurations::getValue('paypal_password') != '') ? Configurations::getValue('paypal_password') : Yii::app()->params['PASSWORD'];
        $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name
        // CREDIT/DEBIT CARD TRANSACTION //
        $oPayFlow->ACCT = $amPaymentData['card_number'];
        $oPayFlow->EXPDATE = $amPaymentData['expiration_month'] . $amPaymentData['expiration_year'];
        $oPayFlow->AMT = $snAmount;

        $oPayFlow->FIRSTNAME = $amPaymentData['first_name'];
        $oPayFlow->LASTNAME = $amPaymentData['last_name'];
        $oPayFlow->EMAIL = $amPaymentData['email'];
        $oPayFlow->STREET = $amPaymentData['address_1'];
        $oPayFlow->CITY = $amPaymentData['city'];
        $oPayFlow->STATE = $amPaymentData['state_code'];
        $oPayFlow->ZIP = $amPaymentData['zip'];
        $oPayFlow->COUNTRY = 'US';
        $oPayFlow->CURRENCY = 'USD';

        $oPayFlow->TRXTYPE = 'S'; // R stands for recurring profile
        $oPayFlow->TENDER = 'C'; // 'C' (through credit card), 'A' (through bank account)
        $oPayFlow->ACTION = 'S';
        $oPayFlow->sendRequest();

        return $oPayFlow->amResponse;
    }
    /*
    public function callDoDirectPayment($frmResponse)
    {
        // Initialize Values in payment Object by values from front-end //
        $objPaypal = new Paypal();
        $paymentType = urlencode('Sale');
        $amount = urlencode($frmResponse['totAmount']); // or 'Sale'
        $creditCardType = urlencode($frmResponse['card_type']);
        $creditCardNumber = urlencode($frmResponse['card_number']);
        $expDateMonth = urlencode($frmResponse['expiration_month']);
        // Month must be padded with leading zero
        $padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
        $expDateYear = urlencode($frmResponse['expiration_year']);
        $cvv2Number = urlencode($frmResponse['cvv']);
        $firstName = urlencode($frmResponse['firstname']);
        $lastName = urlencode($frmResponse['lastname']);
        $address1 = urlencode($frmResponse['address1']);
        $city = urlencode($frmResponse['city']);
        $state = urlencode($frmResponse['state']);
        $zip = urlencode($frmResponse['zipcode']);
        $country = urlencode($frmResponse['country']);
        //Default Values From Paypal Class
        $currencyID = urlencode($objPaypal->currencyID);
        //String with required parameters
        $nvpStr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber" .
            "&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName" .
            "&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
        $responseDDP = $objPaypal->DoDirectPayment('DoDirectPayment', $nvpStr);
        return $responseDDP;
    }*/
    /* OLD CHEKCOUT COMMENTED ON 9-Jan-14
    public function callPayPalService($snClassId, $anVideoIds, $snOrderId, $snTotalPrice)
    {

        $ssEncodeParams = base64_encode(json_encode(array('class_id' => $snClassId, 'order_id' => $snOrderId, 'videoids' => $anVideoIds, 'isStudio' => 0)));
        $this->redirect(CController::createUrl('classes/payflowPayment', array('reqData' => $ssEncodeParams,
                'snAmount' => $snTotalPrice)
        ));

        /* OLD CODE 
          if (Yii::app()->getRequest()->getIsPostRequest() || array_key_exists('token', $_REQUEST)) {
          // FOR REDIRECT TO PAYPAL FOR GET PAYMENT //
          $objPaypal = new Paypal();
          $objPaypal->paymentAmount = ($objPaypal->paymentAmount > 0) ? $objPaypal->paymentAmount : $snTotalPrice;
          if (!array_key_exists('token', $_REQUEST)) {

          $ssEncodeParams = base64_encode(json_encode(array('class_id' => $snClassId, 'order_id' => $snOrderId, 'videoids' => $anVideoIds)));
          $objPaypal->returnURL = urlencode('http://' . $_SERVER["HTTP_HOST"] . CController::createUrl('site/updateOrder', array('reqData' => $ssEncodeParams)));
          $objPaypal->cancelURL = urlencode('http://' . $_SERVER["HTTP_HOST"] . CController::createUrl('site/updateOrder', array('reqData' => $ssEncodeParams)));
          $ssDescription = urlencode("Twinkle Star Dance Payment");
          $nvpStr = "&Amt=$objPaypal->paymentAmount&ReturnUrl=$objPaypal->returnURL&CANCELURL=$objPaypal->cancelURL&PAYMENTACTION=$objPaypal->paymentType&CURRENCYCODE=$objPaypal->currencyID";
          $nvpStr .= "&L_BILLINGTYPE0=RecurringPayments&L_BILLINGAGREEMENTDESCRIPTION0=$ssDescription&DESC=$ssDescription";
          $responseSEC = $objPaypal->SetExpressCheckout('SetExpressCheckout', $nvpStr);
          }
          $responseGECD = $objPaypal->GetExpressCheckoutDetails('GetExpressCheckoutDetails');
          $responseDECP = $objPaypal->DoExpressCheckoutPayment('DoExpressCheckoutPayment', $responseGECD);
          } */
    /*}*/
    /* OLD CHEKCOUT COMMENTED ON 9-Jan-14
    public function actionPayflowPayment($reqData, $snAmount)
    {

        $this->layout = false;
        $amUserInfo = AdminModule::getUserData();
        $omUser = Users::model()->findByPk($amUserInfo['id']);
        $this->render("payflowPayment", array("ssRequestData" => $reqData,
            "snTotalPrice" => $snAmount,
            'ssEmail' => $omUser->email,
            'ssName' => $omUser->first_name,
            'ssAddress' => $omUser->address_1,
            'ssCity' => $omUser->city,
            'ssState' => ($omUser->state) ? $omUser->state->state_abbv : "",
            'ssCounty' => ($omUser->country) ? $omUser->country->country_code : "",
            'ssZip' => $omUser->zip,
            'ssPhoneNumber' => $omUser->phone
        ));
    }*/

    public function actionAssignVideos($id)
    {

        $model = $this->loadModel($id, 'Classes');
        if ($model) {
            if (Yii::app()->getRequest()->getIsPostRequest()) {
                $anVideoIds = isset($_POST['videoids']) ? $_POST['videoids'] : array();
                if (count($anVideoIds) > 0) {
                    ClassVideos::addVideos($id, $anVideoIds);

                    Yii::app()->user->setFlash('success', "Videos has been successfully added.");
                    $this->redirect(CController::createUrl("classes/update", array("id" => $model->id)));
                }
            }
            $omResults = Orders::getUserVideos(true);
            $amVideos = $amClassVideos = array();
            if ($omResults) {
                foreach ($omResults as $omDataSet) {

                    // FOR GET VIDEOS FROM PACKAGE //
                    if ($omDataSet->type == "Package") {
                        //$omPackageVideoResults = PackageSubscription::getAllVideosAsPerPackageId($omDataSet->package_subscription_id);
                        $omPackageVideoResults = Videos::getUserPurchasedVideosFromSub(0, $omDataSet->package_subscription_id);
                        if ($omPackageVideoResults) {
                            foreach ($omPackageVideoResults as $omPackageVideoData) {
                                // Phase-II: Commented as per Aidan Note: 2nd Oct, '13
                                //if ($omPackageVideoData->additional_status == 0) {
                                $amVideos[$omPackageVideoData->id] = array('title' => $omPackageVideoData->title,
                                    'image_url' => $omPackageVideoData->image_url
                                );
                                //}
                            }
                        }
                    } elseif ($omDataSet->type == "Subscription") {
                        // Phase-II: For user can see the videos still if admin remove it from subscription. //
                        //$omSubVideos = Videos::getVideosAsPerSubscription($omDataSet->package_subscription_id);                        
                        $omSubVideos = Videos::getUserPurchasedVideosFromSub($omDataSet->package_subscription_id);
                        if ($omSubVideos) 
                        {
                            foreach ($omSubVideos as $omSubVideoData) 
                            {
                                // Phase-II: Commented as per Aidan Note: 2nd Oct, '13
                                //if ($omSubVideoData->additional_status == 0) {
                                $amVideos[$omSubVideoData->id] = 
                                array(
                                    'id' => $omSubVideoData->id, 
                                    'title' => $omSubVideoData->title,
                                    'image_url' => $omSubVideoData->image_url
                                );
                                //}
                            }
                        }
                    } else {
                        $amVideos[$omDataSet->video_id] = array('id' => $omDataSet->video_id,'title' => $omDataSet->v_title, 'image_url' => $omDataSet->v_image_url);
                    }
                }
                // FOR GET ALL VIDEOS OF CLASSE //
                $amClassVideos = array();
                $omClassVideos = ClassVideos::model()->findAll("class_id =:classID", array(":classID" => $model->id));
                if ($omClassVideos) {
                    foreach ($omClassVideos as $omData) {
                        $amClassVideos[] = $omData->video_id;
                    }
                }
            }
           /* $this->render('assignVideos', array(
                'amVideos' => $amVideos,
                'amClassVideos' => $amClassVideos
            ));*/

            //print_r($amVideos);exit();
            $snI = 1;
            foreach ($amVideos as $snVideoId => $amResultSet)
            {
                if (!in_array($snVideoId, $amClassVideos))
                {
                    $ssClass = ($snI % 3 == 0) ? 'block last' : 'block';
                    $amVideos[$snVideoId]['class'] = $ssClass;
                    $snI++;
                }
                else
                {
                    unset($amVideos[$snVideoId]);
                }
              
            }
               
            $dataProvider = new CArrayDataProvider($amVideos);  
            $this->render('assignVideos', array(
                'dataProvider' => $dataProvider,
            ));
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionViewDetailsTable($id)
    {

      // p($_POST);

        $video_title = (isset($_GET['Videos']) && isset($_GET['Videos']['title']) && !empty($_GET['Videos']['title'])) ? $_GET['Videos']['title'] : '';
        $video_genre = (isset($_GET['Videos']) && isset($_GET['Videos']['genre']) && !empty($_GET['Videos']['genre'])) ? $_GET['Videos']['genre'] : '';
        $video_category = (isset($_GET['Videos']) && isset($_GET['Videos']['category']) && !empty($_GET['Videos']['category'])) ? $_GET['Videos']['category'] : '';
        $video_age = (isset($_GET['Videos']) && isset($_GET['Videos']['age']) && !empty($_GET['Videos']['age'])) ? $_GET['Videos']['age'] : '';


        //p($_GET,2);
        $model = $this->loadModel($id, 'Classes');
        if ($model) 
        {
            if (Yii::app()->getRequest()->getIsPostRequest()) 
            {
                $anVideoIds = isset($_POST['videos-grid_ccheckboxes']) ? $_POST['videos-grid_ccheckboxes'] : array();

                if (count($anVideoIds) > 0) {
                    ClassVideos::addVideos($id, $anVideoIds);

                    Yii::app()->user->setFlash('success', "Videos has been successfully added.");
                    $this->redirect(CController::createUrl("classes/update", array("id" => $model->id)));
                }
            }
            $omResults = Orders::getUserVideos(true);

          
            $amVideos = $amClassVideos = array();
            if ($omResults) {
                foreach ($omResults as $omDataSet) {

                    // FOR GET VIDEOS FROM PACKAGE //
                    if ($omDataSet->type == "Package") {
                        //$omPackageVideoResults = PackageSubscription::getAllVideosAsPerPackageId($omDataSet->package_subscription_id);
                        $omPackageVideoResults = Videos::getUserPurchasedVideosFromSub(0, $omDataSet->package_subscription_id);
                        if ($omPackageVideoResults) 
                        {
                            foreach ($omPackageVideoResults as $omPackageVideoData) 
                            {
                                // Phase-II: Commented as per Aidan Note: 2nd Oct, '13
                                //if ($omPackageVideoData->additional_status == 0) {
                                $amVideos[$omPackageVideoData->id] = array('title' => $omPackageVideoData->title,
                                    'image_url' => $omPackageVideoData->image_url
                                );
                                //}
                            }
                        }
                    } 
                    elseif ($omDataSet->type == "Subscription") 
                    {
                        // Phase-II: For user can see the videos still if admin remove it from subscription. //
                        //$omSubVideos = Videos::getVideosAsPerSubscription($omDataSet->package_subscription_id);                        
                        $omSubVideos = Videos::getUserPurchasedVideosFromSub($omDataSet->package_subscription_id,0,false,$video_title,$video_genre,$video_category,$video_age);

                        if ($omSubVideos) 
                        {
                            

                            foreach ($omSubVideos as $omSubVideoData) 
                            {
                                // Phase-II: Commented as per Aidan Note: 2nd Oct, '13
                                //if ($omSubVideoData->additional_status == 0) {
                                $amVideos[$omSubVideoData->id] = 
                                array(
                                    'id' => $omSubVideoData->id, 
                                    'title' => isset($omSubVideoData->title) ? $omSubVideoData->title : '',
                                    'image_url' => isset($omSubVideoData->image_url) ? $omSubVideoData->image_url : '',
                                    'genre' => isset($omSubVideoData->genre) ? $omSubVideoData->genre : '',
                                    'age_range' => isset($omSubVideoData->age_range) ? $omSubVideoData->age_range : '',
                                    'category' => isset($omSubVideoData->category) ? $omSubVideoData->category : '', 
                                    'category_name' => isset($omSubVideoData->categoryRel->name) ? $omSubVideoData->categoryRel->name : '',
                                    'genre_name' => isset($omSubVideoData->genreRel->name) ? $omSubVideoData->genreRel->name : '',
                                    'age_range' => isset($omSubVideoData->agerangeRel->range) ? $omSubVideoData->agerangeRel->range : ''
                                );
                                //}
                            }
                        }
                    } 
                    else
                    {
                        $amVideos[$omDataSet->video_id] = array('id' => $omDataSet->video_id,'title' => $omDataSet->v_title, 'image_url' => $omDataSet->v_image_url);
                    }
                }


               /// p($amVideos);

                // FOR GET ALL VIDEOS OF CLASSE //
                $amClassVideos = array();
                $omClassVideos = ClassVideos::model()->findAll("class_id =:classID", array(":classID" => $model->id));
                if ($omClassVideos) {
                    foreach ($omClassVideos as $omData) {
                        $amClassVideos[] = $omData->video_id;
                    }
                }
            }
           /* $this->render('assignVideos', array(
                'amVideos' => $amVideos,
                'amClassVideos' => $amClassVideos
            ));*/

            $snI = 1;
            foreach ($amVideos as $snVideoId => $amResultSet)
            {
                if (!in_array($snVideoId, $amClassVideos))
                {
                    $ssClass = ($snI % 3 == 0) ? 'block last' : 'block';
                    $amVideos[$snVideoId]['class'] = $ssClass;
                    $snI++;
                }
                else
                {
                    unset($amVideos[$snVideoId]);
                }
              
            }


               
            $dataProvider = new CArrayDataProvider($amVideos);  

           //p($dataProvider);

            $this->render('viewDetailsTable', array(
                'dataProvider' => $dataProvider,
            ));
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionRemoveVideos($id)
    {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $snClassId = Yii::app()->getRequest()->getParam('class_id', '');
            $bResponse = ClassVideos::removeClassVideos($snClassId, $id);
            echo $bResponse;
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
        Yii::app()->end();
    }

    /**
     * function: performAjaxValidation()
     * For perform Yii Ajax validation
     */
    protected function performAjaxValidation($model, $form = NULL)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * function: getListState()
     * get list of states based on country selected
     */
    public function actionGetListState()
    {
        $data = StateMaster::model()->findAll('country_id=:countryid', array(':countryid' => (int)$_POST['countryid']));

        $data = CHtml::listData($data, 'id', 'state_name');

        echo "<option value=''>--Select State--</option>";
        foreach ($data as $value => $state_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($state_name), true);
    }

    public function actionWatchVideo($iframe_code, $description)
    {
        //echo $iframe_code = '<iframe frameborder="0" scrolling="no" width="425" height="266" src="http://api.smugmug.com/services/embed/1482349172_HpTNjR3?width=425&amp;height=266"></iframe>';                                
        //echo base64_decode($iframe_code);
        echo "<div style='background-color:#DCDCDC;'>";
        echo "<div class='video'>" . base64_decode($iframe_code) . "<div />";

        // STRIP WIDTH FROM IFRAME //
        $ssHTML = base64_decode($iframe_code);
        $amResults = array();
        preg_match('/width="([^"]*)"/i', $ssHTML, $amResults);
        $ssDefaultWidth = (count($amResults) > 0 && isset($amResults[1]) && $amResults[1] > 0) ? 'width:' . $amResults[1] . 'px;' : 'width:' . Yii::app()->params['defaultIframeWidth'] . 'px;';
        echo "<div class='video_description' style='$ssDefaultWidth'>" . base64_decode($description) . '<div />';
        echo "<div />";
        exit;
    }

    public function actionAddDocumentsToClass($id)
    {
        $this->layout = '..//layouts/create_admin';
        $model = $this->loadModel($id, 'Classes');

        // SAVE USER's (INSTRUCTOR/DANCERS) AS PER CLASS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            //p($_REQUEST);
            $anDocsIds = isset($_POST['document_ids']) ? $_POST['document_ids'] : array();
            if (count($anDocsIds) > 0) {
                ClassDocuments::addDocumentsInClass($model->id, $anDocsIds);
            }
//            else{                
//                ClassDocuments::removeUnselectedDocuments($model->id);
//            }
            echo Common::closeColorBox();
            Yii::app()->end();
        }

        $amResult = $amSelected = array();
        // FOR GET ALL SUBSCRIPTIONS //
        $omResult = Orders::getAndCheckUserPurchasedSubscriptions(true);
        $anSubIds = $anPackageSubIds = array();
        if ($omResult) {
            foreach ($omResult as $omDataSet) {
                foreach ($omDataSet->orderDetails as $omOrderDetails) {
                    if ($omOrderDetails->packageSubscription->type == "Package") {
                        $anPackageSubIds = PackageSubscription::getSubscriptionsIdsAsPerPackage($omOrderDetails->packageSubscription->id);
                    } else {
                        $anSubIds[] = $omOrderDetails->packageSubscription->id;
                    }
                }
            }
        }
        $anSubIds = (count($anPackageSubIds) > 0) ? array_merge($anPackageSubIds, $anSubIds) : $anSubIds;
        $anSubIds = array_unique($anSubIds);
        if (count($anSubIds) > 0) {
            $oCriteria = new CDbCriteria();
            $oCriteria->alias = 'psdt';
            $oCriteria->condition = 'psdt.subscription_id IN (' . implode(',', $anSubIds) . ')';
            $omDocuments = PackageSubscriptionDocumentsTransaction::model()->findAll($oCriteria);
            if ($omDocuments) {
                foreach ($omDocuments as $omDataSet) {
                    $amResult[$omDataSet->document->id] = $omDataSet->document->document_title;
                }
            }
        }

        // FOR GET SELECTED SUBSCRIPTION AS PER DOCUMENT //
        $omCriteria = new CDbCriteria();
        $omCriteria->condition = "class_id =:snClassID";
        $omCriteria->params = array(':snClassID' => $id);
        $omDocuments = ClassDocuments::model()->findAll($omCriteria);

        if ($omDocuments) {
            foreach ($omDocuments as $omData) {
                $amSelected[] = $omData->document_id;
            }
        }
        $this->render('addDocumentsToClass', array(
            'model' => $model,
            'amResult' => $amResult,
            'amSelected' => $amSelected
        ));
    }

    public function actionRemoveDocumentToClass($id)
    {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $snClassId = Yii::app()->getRequest()->getParam('class_id', '');
            $bResponse = ClassDocuments::removeDocumentFromClass($snClassId, $id);
            echo $bResponse;
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
        Yii::app()->end();
    }

    public function actionGetClassesReport()
    {     
        $this->layout = '..//layouts/admin';
        $model = new Classes('search');
        $model->unsetAttributes();

        $to_start_date="";
        $to_end_date="";
        $from_start_date="";
        $from_end_date="";

        if(isset($_GET['to_start_date']))
        {                        
            $to_start_date=$_GET['to_start_date'];
            $to_end_date=$_GET['to_end_date'];
            $from_start_date=$_GET['from_start_date'];
            $from_end_date=$_GET['from_end_date'];
        }

        $from_end_date   = date('Y-m-d');
        $to_end_date = date('Y-m-d', strtotime('+7 days'));
       
        $name="";

        if (isset($_GET['Classes']))
        {
            $model->setAttributes($_GET['Classes']);
            $name=$_GET['Classes']['name'];
        }
        
        $snLoggedInUserId = Yii::app()->admin->id; // (studio,instructor,dancer)
        $oCriteria = Classes::getAllClassesCreateByUser($snLoggedInUserId, true,$to_start_date,$to_end_date,$from_start_date,$from_end_date,$name);

        //$dataProvider = new CActiveDataProvider('Classes', array('criteria' => $oCriteria));
        $dataProvider = new CActiveDataProvider('Classes', array(
                'criteria' => $oCriteria,
                'pagination' => array('pageSize' => Yii::app()->params['perPageLimit'])
            )
        );

        if(isset($_GET['colorbox']))
        {
            $this->layout = false;
        }
        if(isset($_GET['classReportResult']))
        {
            echo count($dataProvider->getData());exit();
        }
       
        $this->render('classes_report', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

}
