<?php

class OrdersController extends AdminCoreController
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
            'model' => $this->loadModel($id, 'Orders'),
        ));
    }

    public function actionCreate()
    {
        $model = new Orders;


        if (isset($_POST['Orders'])) {
            $model->setAttributes($_POST['Orders']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id, 'Orders');
        $omOrderDetails = Orders::getUserPurchasedDetails($id);

        $omDancerOrderDetails = array();
        if (!$omOrderDetails)
            $omDancerOrderDetails = UserVideosTransaction::getDancerOrderDetails($model->id);

        if (isset($_POST['Orders'])) {
            $model->setAttributes($_POST['Orders']);

            // FOR CHANGE EXPIRY DATE //
            if (isset($_POST['expiry_date']) && count($_POST['expiry_date']) > 0) {
                foreach ($_POST['expiry_date'] as $snIds => $ssExpiryDate) {
                    if (trim($ssExpiryDate) != "") {

                        list($snOrderId, $snPackageSubId) = explode('_', $snIds);
                        $ssExpiryDate = date('Y-m-d', strtotime($ssExpiryDate));
                        // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                        Yii::app()->db->createCommand('update order_details set expiry_date=:ssExpiryDate WHERE order_id=:snOrderID AND package_subscription_id=:snPackageSubId')
                            ->bindValues(array(
                                ':ssExpiryDate' => $ssExpiryDate,
                                ':snOrderID' => $snOrderId,
                                ':snPackageSubId' => $snPackageSubId
                            ))
                            ->execute();
                    }
                }
            }

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Order has been successfully updated.");
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'omOrderDetails' => $omOrderDetails,
            'omDancerOrderDetails' => $omDancerOrderDetails
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'Orders')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Orders');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = Orders::getUserOrdersDetails();

        // FOR DELETE SELECTED ORDERS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $anDeletedIds = isset($_POST['orderids']) ? $_POST['orderids'] : array();
            if (count($anDeletedIds) > 0) {
                $bDeleted = Orders::removeSelectedOrders($anDeletedIds);
                if ($bDeleted) {
                    Yii::app()->user->setFlash('success', "Record has been successfully deleted");
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionEmailOrderInfo()
    {
        if (Yii::app()->request->isPostRequest) {
            $this->layout = '..//layouts/mail_layout';
            $snOrderId = $_POST['order_id'];
            $model = $this->loadModel($snOrderId, 'Orders');

            $omOrderDetails = Orders::getUserPurchasedDetails($snOrderId);

            $omDancerOrderDetails = array();
            if (!$omOrderDetails)
                $omDancerOrderDetails = UserVideosTransaction::getDancerOrderDetails($model->id);

            // FOR GET PARENT INFO //
            $amAdminInfo = AdminModule::getUserData();

            $ssSubject = "Your Order number #$model->id details";
            $ssBody = $this->renderPartial("order_details_mail", array('model' => $model, 'omOrderDetails' => $omOrderDetails, 'omDancerOrderDetails' => $omDancerOrderDetails), true, false);

            // FOR SEND MAIL //
            Common::sendMail($model->user->email, array($amAdminInfo['email'] => ucfirst($amAdminInfo['first_name'] . ' ' . $amAdminInfo['last_name'])), $ssSubject, $ssBody);
            Yii::app()->user->setFlash('success', "Order details has been sent successfully.");
            Yii::app()->end();
        }
    }

    public function actionPaymentHistory($id)
    {

        $this->layout = '..//layouts/create_admin';

        $oPayFlow = new PayPalPayflowPro();
        $oPayFlow->PARTNER = (Configurations::getValue('paypal_partner') != '') ? Configurations::getValue('paypal_partner') : Yii::app()->params['PARTNER'];
        $oPayFlow->USER = (Configurations::getValue('paypal_merchant_login') != '') ? Configurations::getValue('paypal_merchant_login') : Yii::app()->params['LOGIN'];
        $oPayFlow->PWD = (Configurations::getValue('paypal_password') != '') ? Configurations::getValue('paypal_password') : Yii::app()->params['PASSWORD'];
        $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name

        $oPayFlow->ACTION = 'I'; // If (P) then PAYMENTNUMBER required
        $oPayFlow->TRXTYPE = 'R';
        $oPayFlow->ORIGPROFILEID = $id;

        $oPayFlow->PAYMENTHISTORY = 'Y';
        $oPayFlow->sendRequest();
        $amResponse = $oPayFlow->amResponse;


        $amPaymentHistory = array();
        if (isset($amResponse['history']) && count($amResponse['history']) > 0) {
            $oOrderInfo = Orders::model()->findByAttributes(array('recurring_profile_id' => $id));
            foreach ($amResponse['history'] as $snKey => $amResults) {
                $amSubNames = array();
                foreach ($oOrderInfo->orderDetails as $omOrderDetails) {
                    $amSubNames[] = $omOrderDetails->packageSubscription->name;
                }
                $smSubNames = implode(',', $amSubNames);
                $amResults[$snKey] = array_merge($amResults, array('SUBSCRIPTION' => $smSubNames));
                $amPaymentHistory[] = $amResults[$snKey];
            }
        }


//        $result = "RESULT=0&RPREF=RKM500141021&PROFILEID=RT0000000100&P_PNREF1=VWYA06156256&P_TRANSTIME1=21-May-04 04:47PM&P_RESULT1=0&P_TENDER1=C&P_AMT1=1.00&P_TRANSTATE1=8&P_PNREF2=VWYA06156269&P_TRANSTIME2=27-May-04 01:19PM&P_RESULT2=0&P_TENDER2=C&P_AMT2=1.00&P_TRANSTATE2=8&P_PNREF3=VWYA06157650&P_TRANSTIME3=03-Jun-04 04:47PM&P_RESULT3=0&P_TENDER3=C&P_AMT3=1.00&P_TRANSTATE3=8&P_PNREF4=VWYA06157668&P_TRANSTIME4=10-Jun-04 04:47PM&P_RESULT4=0&P_TENDER4=C&P_AMT4=1.00&P_TRANSTATE4=8&P_PNREF5=VWYA06158795&P_TRANSTIME5=17-Jun-04 04:47PM&P_RESULT5=0&P_TENDER5=C&P_AMT5=1.00&P_TRANSTATE5=8&P_PNREF6=VJLA00000060&P_TRANSTIME6=05-Aug-04 05:54PM&P_RESULT6=0&P_TENDER6=C&P_AMT6=1.00&P_TRANSTATE6=1";
//
//        $ret = array();
//
//        $snI = 1;
//        while (strlen($result) > 0) {
//
//            $keypos = strpos($result, '=');
//            $keyval = substr($result, 0, $keypos);
//
//
//            if (strstr($keyval, 'P_PNREF')) {
//                $snArrayPos = $keyval[strlen($keyval) - 1];
//            }
//            // value
//            $valuepos = strpos($result, '&') ? strpos($result, '&') : strlen($result);
//            $valval = substr($result, $keypos + 1, $valuepos - $keypos - 1);
//
//            // decoding the respose
//            if (isset($snArrayPos))
//                $ret[$snArrayPos][$keyval] = $valval;
//            else
//                $ret[$keyval] = $valval;
//
//            $result = substr($result, $valuepos + 1, strlen($result));
//        }
//        p($ret);


        $this->render('paymentHistory', array(
            'amPaymentHistory' => $amPaymentHistory
        ));
    }

}