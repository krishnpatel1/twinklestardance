<?php

class RenewSubscriptionController extends FrontCoreController 
{
    public function actionError() 
    {
        if ($error = Yii::app()->errorHandler->error) 
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error', $error);
            }
        }
    }

    public function actionMakePayment() 
    {
        if (!Yii::app()->admin->id)
            $this->redirect(array('index/login'));

        $oMakePaymentForm = new MakePaymentForm();
        $snUserId = Yii::app()->admin->id;
        $orderID = $_GET['orderID'];
       
        $orderDetail = OrderDetails::model()->findByPk($orderID);

        if(empty($orderDetail) || !isset($_GET['orderID']))
        {
             $this->redirect(array('renewSubscription/error'));   
        }

        $package = PackageSubscription::model()->findByPk($orderDetail->package_subscription_id);

        $amUserCart[0]['cart_id'] =  0;
        $amUserCart[0]['is_admin_approved'] =  1;
        $amUserCart[0]['cart_duration'] =  $package->duration;
        $amUserCart[0]['video_id'] =  0;
        $amUserCart[0]['id'] =  $package->id;
        $amUserCart[0]['name'] =  $package->name;
        $amUserCart[0]['description'] =  $package->description;
        $amUserCart[0]['price_one_time'] =  $package->price_one_time;
        $amUserCart[0]['price'] =  $package->price;
        $amUserCart[0]['discount'] =  $package->discount;
        $amUserCart[0]['duration'] =  $package->duration;
        $amUserCart[0]['image_url'] =  $package->image_url;
        $amUserCart[0]['type'] =  'Subscription';
        $amUserCart[0]['base_video_limit'] =  $package->base_video_limit;
        $amUserCart[0]['available_update'] =  $package->available_update;
        $amUserCart[0]['status'] =  $package->status;
        $amUserCart[0]['created_at'] =  $package->created_at;
        $amUserCart[0]['updated_at'] =  $package->updated_at;

        $ssView = 'monthlyPayment';

        $ssView = ($package->duration == 1) ? 'monthlyPayment' : 'yearlyPayment';
        $oMakePaymentForm->payment_views = $package->duration;

        // FOR CONFIRM ORDER REDIRECTION //
        if (isset($_POST['Paypal']) && isset($_GET['orderID']) && !empty($package->id)) 
        {
            //p($_POST);
            $amPostData = $_POST;
            // FOR CASH / CHEQUE PAYMENT //
            if ($amPostData['MakePaymentForm']['payment_method'] != Yii::app()->params['comparePaymentMethods']['online']) 
            {
                // REDIRECT WHEN STUDIO MAKE PAYMENT THORUGH CASH / CHEQUE //
                Yii::app()->user->setFlash('order_info', $orderID);
                $this->redirect(array('renewSubscription/thankYou'));   
            } 
            else 
            {
                // FOR MONTHLY RECURRING PAYMENT //
                if ($amPostData['payment_views'] == 1 && $amPostData['MakePaymentForm']['payment_option'] == 1) 
                {
                    $this->redirect(Yii::app()->createUrl('renewSubscription/recurringPayment', array('order_id' => $orderID,'type' => 'recurring')));
                } 
                else 
                {
                    //$this->redirect(Yii::app()->createUrl('renewSubscription/fullPayment', array('order_id' => $orderID)));
                    $this->redirect(Yii::app()->createUrl('renewSubscription/recurringPayment', array('order_id' => $orderID,'type' => 'full')));
                }
            }
        }

        $this->render('makePayment', array(
            'cartItems' => $amUserCart,
            'oMakePaymentForm' => $oMakePaymentForm,
            'ssView' => $ssView,
        ));
    }

    public function actionRecurringPayment($order_id,$type) 
    {
        if (!Yii::app()->admin->id)
            $this->redirect(array('index/login'));

        $PayFlowPaymentForm = new PayFlowPaymentForm();
        $PayFlowPaymentForm->scenario = 'recurring_payment';
        $PayFlowPaymentForm->payment_method = 'C';
        $PayFlowPaymentForm->account_type = 'S';
        $omUser = Users::model()->findByPk(Yii::app()->admin->id);

        //$omOrder = Orders::model()->findByPk($order_id);
        $omOrder = OrderDetails::model()->findByPk($order_id);
        $package = PackageSubscription::model()->findByPk($omOrder->package_subscription_id);
   
        if ($omUser) 
        {
            $PayFlowPaymentForm->first_name = $omUser->first_name;
            $PayFlowPaymentForm->last_name = $omUser->last_name;
            $PayFlowPaymentForm->email = $omUser->email;
            $PayFlowPaymentForm->address_1 = $omUser->address_1;
            $PayFlowPaymentForm->city = $omUser->city;
            $PayFlowPaymentForm->zip = $omUser->zip;
            $PayFlowPaymentForm->phone_number = $omUser->phone;
        }

        if ($type == 'recurring') 
        {
            $checkoutPrice = $omOrder->amount;
        }
        else
        {
            $checkoutPrice = $package->price_one_time;
        }

        if (Yii::app()->getRequest()->getIsPostRequest()) 
        {
            $amPostData = $_POST['PayFlowPaymentForm'];
            $PayFlowPaymentForm->setAttributes($amPostData);
            $PayFlowPaymentForm->payment_method = $amPostData['payment_method'];

            if ($PayFlowPaymentForm->validate()) 
            {
                $snTotRecurringAmt = 0;
                $snTotYearlyAmt = 0;
                $snTotRecurringAmt = $omOrder->amount;
                   
                $bAtleastOneSuccess = false;

                if ($type == 'recurring') 
                {
                    // CREATE RECURRING PROFILE USING PAYFLOW PRO API //
                    $amResponse = $this->payFlowCreateRecurringProfile($PayFlowPaymentForm->attributes, $snTotRecurringAmt);

                    if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) 
                    {
                        $bAtleastOneSuccess = true;

                        $extended_date = date('Y-m-d H:i:s', strtotime('+2 years',strtotime($omOrder->expiry_date)));

                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        Common::commonUpdateField("order_details", "expiry_date", $extended_date, "id", $omOrder->id);
                        Common::commonUpdateField("order_details", "renew_date", date('Y-m-d H:i:s'), "id", $omOrder->id);
                        //Common::commonUpdateField("orders", "recurring_profile_id", $amResponse['PROFILEID'], "id", $omOrder->id);
                        Yii::app()->user->setFlash('success', "Thank you for your order.");
                        Yii::app()->user->setFlash('order_info', $omOrder->id);
                    } 
                    else 
                    {

                        $ssMessage = isset(Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']]) ? Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']] : "There are some error in payment. Try again later.";
                        $ssMessage = 'Error Code: ' . $amResponse['RESULT'] . ' Error Message: ' . $ssMessage;
                        //Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $omOrder->id);
                        //Common::commonUpdateField("orders", "payment_error_message", $ssMessage, "id", $omOrder->id);
                        Yii::app()->user->setFlash('error', $ssMessage);
                    }
                }

                // MAKE FULL PAYMENT THROUGH PAYFLOW PRO API //
                if ($type == 'full') 
                {
                    $snTotYearlyAmt = $package->price_one_time;

                    $amResponse = $this->payFlowExpressCheckout($PayFlowPaymentForm->attributes, $snTotYearlyAmt);
                  
                    if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) 
                    {
                        $bAtleastOneSuccess = true;

                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        //Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $omOrder->id);
                        $extended_date = date('Y-m-d H:i:s', strtotime('+1 years',strtotime($omOrder->expiry_date)));

                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        Common::commonUpdateField("order_details", "expiry_date", $extended_date, "id", $omOrder->id);
                        Common::commonUpdateField("order_details", "renew_date", date('Y-m-d H:i:s'), "id", $omOrder->id);
                        Common::commonUpdateField("order_details", "duration", 2, "id", $omOrder->id);
                        Yii::app()->user->setFlash('success', "Thank you for your order.");
                    } 
                    else 
                    {
                        $ssMessage = isset(Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']]) ? Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']] : "There are some error in payment. Try again later.";
                        $ssMessage = 'Error Code: ' . $amResponse['RESULT'] . ' Error Message: ' . $ssMessage;
                        //Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $omOrder->id);
                        //Common::commonUpdateField("orders", "payment_error_message", $ssMessage, "id", $omOrder->id);
                        Yii::app()->user->setFlash('error', $ssMessage);
                    }
                }

                if ($bAtleastOneSuccess)
                {
                    $this->redirect(Yii::app()->createUrl('admin/videos/index'));
                }
            }
        }

        $omStates = StateMaster::getStatesAsPerCountry(Yii::app()->params['default_country']['US']);
        $amStates = CHtml::listData($omStates, 'state_abbv', 'state_name');

        $this->render('recurringPayment', array(
            'PayFlowPaymentForm' => $PayFlowPaymentForm,
            'snCheckoutPrice' => $checkoutPrice,
            'omOrder' => $omOrder,
            'omUser' => $omUser,
            'amStates' => $amStates
        ));
    }

    /**
     * function: getListState()
     * get list of states based on country selected
     */
    public function actionGetListState() {
        $data = StateMaster::model()->findAll('country_id=:countryid', array(':countryid' => (int) $_POST['countryid']));

        $data = CHtml::listData($data, 'id', 'state_name');

        echo "<option value=''>--Select State--</option>";
        foreach ($data as $value => $state_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($state_name), true);
    }

    /**
     * function: actionMonthlyPaymentApplication()
     * for 
     */
    public function actionMonthlyPaymentApplication() {
        if (Yii::app()->user->hasState('amSelectedPackageSubData')) {
            Yii::app()->user->setState('amSelectedPackageSubData', NULL);
        }
        $oModel = new SecureApplicationForm();
        $amUserData = AdminModule::getUserData();
        if (count($amUserData) > 0) {
            $omUser = Users::model()->findByPk($amUserData['id']);

            $oModel->studio_name = $omUser->studio_name;
            $oModel->studio_owner_first_name = $omUser->first_name;
            $oModel->studio_owner_last_name = $omUser->last_name;
            $oModel->email_address = $omUser->email;
            $oModel->city = $omUser->city;
            $oModel->street_address = $omUser->address_1;
            $oModel->state_province = $omUser->state_id;
            $oModel->zip_postal = $omUser->zip;
            $oModel->business_phone = $omUser->phone;
            $oModel->mobile_phone = $omUser->mobile;
        }

        $omStates = StateMaster::getStatesAsPerCountry(Yii::app()->params['default_country']['US']);
        $amStates = CHtml::listData($omStates, 'id', 'state_name');
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $amPostData = $_POST['SecureApplicationForm'];
            $oModel->setAttributes($amPostData);
            if ($oModel->validate()) {

                // UPDATE USER INFO //
                if (count($amUserData) > 0) {
                    $omUser->last_name = $oModel->studio_owner_last_name;
                    $omUser->address_1 = $oModel->street_address;
                    $omUser->zip = $oModel->zip_postal;
                    $omUser->mobile = $oModel->mobile_phone;
                    $omUser->city = $oModel->city;
                    $omUser->state_id = $oModel->state_province;
                    $omUser->save(false);
                }

                // FOR GET ADMIN MAIL CONTENT TO SEND MONTHLY PAYMENT REQUEST //
                $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => "SSL_ADMIN"));

                // REPLACE SOME CONTENT TO PRINT //
                $amReplaceParams = array(
                    '{STUDIO_NAME}' => $oModel->studio_name,
                    '{FIRST_NAME}' => $oModel->studio_owner_first_name,
                    '{LAST_NAME}' => $oModel->studio_owner_last_name,
                    '{EMAIL}' => $oModel->email_address,
                    '{STREET_ADDRESS}' => $oModel->street_address,
                    '{CITY}' => $oModel->city,
                    '{STATE}' => $amStates[$oModel->state_province],
                    '{ZIP}' => $oModel->zip_postal,
                    '{BUSINESS_PHONE}' => $oModel->business_phone,
                    '{MOBILE}' => $oModel->mobile_phone,
                    '{SSN}' => $oModel->social_security_number,
                    '{DATE_OF_BIRTH}' => date(Yii::app()->params['defaultDateFormat'], strtotime($oModel->date_of_birth)),
                );
                $ssSubject = $omMailContent->subject;
                $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                // FOR GET PARENT INFO //
                $amAdminInfo = AdminModule::getUserData();
				
                // FOR SEND TO ADMIN MAIL //
                Common::sendMail('info@twinklestardance.com', array($oModel->email_address => ucfirst($oModel->studio_name)), $ssSubject, $ssBody, Yii::app()->params['adminEmail2']);

                // FOR SEND CONFIRMATION MAIL TO USER //
                $omMailContent = EmailFormat::model()->findByAttributes(array('file_name' => "SSL_STUDIO"));

                // REPLACE SOME CONTENT TO PRINT //
                $amReplaceParams = array(
                    '{USERNAME}' => $oModel->studio_name
                );
                $ssSubject = $omMailContent->subject;
                $ssBody = Common::replaceMailContent($omMailContent->body, $amReplaceParams);

                // FOR SEND TO ADMIN MAIL //
                Common::sendMail($oModel->email_address, array('info@twinklestardance.com' => 'TSD Team'), $ssSubject, $ssBody);

                $this->redirect(array('cart'));
            }
        }

        $this->render('monthlyPaymentApplication', array(
            'oModel' => $oModel,
            'amStates' => $amStates
        ));
    }

    public function actionThankYou() {

        // FOR GET ORDER INFO WHEN USER PURCHASED ANY SUBSCRIPTION FOR E-COMMERCE TRACKING //
        $omOrderInfo = false;
        if (Yii::app()->user->hasFlash('order_info')) {
            $omOrderInfo = Orders::model()->findByPk(Yii::app()->user->getFlash('order_info'));
        }
        $this->render('thankYou', array(
            'omOrderInfo' => $omOrderInfo
        ));
    }

    public function payFlowExpressCheckout($amPaymentData, $snAmount) {

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

        /*
          // CREDIT/DEBIT CARD TRANSACTION //
          if ($amPaymentData['payment_method'] == 'C') {
          $oPayFlow->ACCT = $amPaymentData['card_number'];
          $oPayFlow->EXPDATE = $amPaymentData['expiration_month'] . $amPaymentData['expiration_year'];
          $oPayFlow->TENDER = 'C';
          } elseif ($amPaymentData['payment_method'] == 'A') {
          // CUSTOMER BANK INFO //
          $oPayFlow->ABA = $amPaymentData['routing_number'];   // Target Bank's transit ABA routing number
          $oPayFlow->ACCT = $amPaymentData['account_number'];  // Bank account number / Credit Card Number
          $oPayFlow->ACCTTYPE = $amPaymentData['account_type'];  // Bank account type: Savings (S) or Checking (C)
          $oPayFlow->TENDER = 'A';
          }
          $oPayFlow->AMT = $snAmount;
         * 
         */

        $oPayFlow->FIRSTNAME = $amPaymentData['first_name'];
        $oPayFlow->LASTNAME = $amPaymentData['last_name'];
        $oPayFlow->EMAIL = $amPaymentData['email'];
        $oPayFlow->STREET = $amPaymentData['address_1'];
        $oPayFlow->CITY = $amPaymentData['city'];
        $oPayFlow->STATE = $amPaymentData['state_code'];
        $oPayFlow->ZIP = $amPaymentData['zip'];
        $oPayFlow->COUNTRY = 'US';
        $oPayFlow->CURRENCY = 'USD';

        $oPayFlow->TRXTYPE = 'S';   // R stands for recurring profile
        $oPayFlow->TENDER = 'C';    // 'C' (through credit card), 'A' (through bank account)        
        $oPayFlow->ACTION = 'S';
        $oPayFlow->sendRequest();

        return $oPayFlow->amResponse;
    }

    public function payFlowCreateRecurringProfile($amPaymentData, $snAmount) {

        $oPayFlow = new PayPalPayflowPro();

        //these are provided by your payflow reseller
        $oPayFlow->PARTNER = (Configurations::getValue('paypal_partner') != '') ? Configurations::getValue('paypal_partner') : Yii::app()->params['PARTNER'];
        $oPayFlow->USER = (Configurations::getValue('paypal_merchant_login') != '') ? Configurations::getValue('paypal_merchant_login') : Yii::app()->params['LOGIN'];
        $oPayFlow->PWD = (Configurations::getValue('paypal_password') != '') ? Configurations::getValue('paypal_password') : Yii::app()->params['PASSWORD'];
        $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name
        // CREDIT/DEBIT CARD TRANSACTION //
        if ($amPaymentData['payment_method'] == 'C') {
            $oPayFlow->ACCT = $amPaymentData['card_number'];
            $oPayFlow->EXPDATE = $amPaymentData['expiration_month'] . $amPaymentData['expiration_year'];
            $oPayFlow->TENDER = 'C';
        } elseif ($amPaymentData['payment_method'] == 'A') {
            // CUSTOMER BANK INFO //
            $oPayFlow->ABA = $amPaymentData['routing_number'];   // Target Bank's transit ABA routing number
            $oPayFlow->ACCT = $amPaymentData['account_number'];  // Bank account number / Credit Card Number
            $oPayFlow->ACCTTYPE = $amPaymentData['account_type'];  // Bank account type: Savings (S) or Checking (C)
            $oPayFlow->TENDER = 'A';
        }
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

        $oPayFlow->PROFILENAME = ucfirst($amPaymentData['first_name'] . ' ' . $amPaymentData['last_name']);
        $oPayFlow->START = date('mdY');
        $oPayFlow->START = date('mdY', strtotime('+1 day'));
        $oPayFlow->PAYPERIOD = 'MONT';
        $oPayFlow->TERM = '24';

        $oPayFlow->TRXTYPE = 'R';
        $oPayFlow->ACTION = 'A';
        //$oPayFlow->debug = true;
        $oPayFlow->sendRequest();

        return $oPayFlow->amResponse;
    }
   

}
