<?php

class SiteController extends FrontCoreController {
    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        $rules = array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('*'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('makePayment'),
//                'users' => array('@'),
//            ),
//            array('deny', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('*'),
//                'users' => array('*'),
//            ),
//        );
//        return $rules;
//    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * This is the action to render the blog.
     */
    public function actionBlog() {
        $this->render('blog');
    }

    /**
     * This is the action to samples ie free videos     * 
     */
    public function actionSamples() {
        $snVideoId = base64_decode(Yii::app()->getRequest()->getParam('id', 0));
        $omSampleVideos = Videos::getAllSampleVideos();

        $omSelectedVideo = array();
        if ($snVideoId > 0)
            $omSelectedVideo = Videos::getAllSampleVideos($snVideoId);

        $this->render('samples', array(
            'omSampleVideos' => $omSampleVideos,
            'omSelectedVideo' => $omSelectedVideo
        ));
    }

    /**
     * This is the action to display Packages/Subscriptions
     */
    public function actionSubscriptions() {
        $allData = $amSelectedPackageSubData = array();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $id = Yii::app()->request->getParam('id');
            $type = Yii::app()->request->getParam('type');
            $videoIds = implode(',', $_POST['selvideo']);
            $duration = Yii::app()->request->getParam('price');
            if (!Yii::app()->user->isGuest) {
                $userId = Yii::app()->admin->id;
                $bAdminApproved = ($duration == Yii::app()->params['amPaymentDuration']['monthly']) ? 0 : 1;
                Cart::addToCart($id, $duration, $userId, $videoIds, $bAdminApproved);

                // IF USER SELECT MONTHLY PAYMENT REDIRECT USER TO SECURE APPLICATION FORM //
                if ($duration == Yii::app()->params['amPaymentDuration']['monthly']) {
                    $this->redirect(array('monthlyPaymentApplication'));
                }
                $this->redirect(array('cart'));
            } else {
                $amSelectedPackageSubData = array(
                    'duration' => $duration,
                    'selvideo' => $videoIds,
                );
                Yii::app()->user->setState('amSelectedPackageSubData', $amSelectedPackageSubData);
                $this->redirect(CController::createUrl('index/login', array('isStudio' => 1, 'id' => $id, 'type' => $type)));
            }
        } else {
            $amSelectedPackageSubData = Yii::app()->user->hasState('amSelectedPackageSubData') ? Yii::app()->user->getState('amSelectedPackageSubData') : array();

            //Fetch data for package and subscriptions
            if (!Yii::app()->request->getParam('id')) {
                if (Yii::app()->user->hasState('amSelectedPackageSubData')) {
                    Yii::app()->user->setState('amSelectedPackageSubData', NULL);
                }
                $allData = PackageSubscription::getPSArray();
                $this->render('subscriptions', array('allData' => $allData));
            } else {
                $id = Yii::app()->request->getParam('id');

                // FOR REDIRECT USER IF HE / SHE ALREADY SELECT THE SUBSCRIPTION & VIDEOS //
                if (count($amSelectedPackageSubData) > 0) {
                    $userId = Yii::app()->admin->id;
                    $bAdminApproved = ($amSelectedPackageSubData['duration'] == Yii::app()->params['amPaymentDuration']['monthly']) ? 0 : 1;
                    Cart::addToCart($id, $amSelectedPackageSubData['duration'], $userId, $amSelectedPackageSubData['selvideo'], $bAdminApproved);

                    // IF USER SELECT MONTHLY PAYMENT REDIRECT USER TO SECURE APPLICATION FORM //
                    if ($amSelectedPackageSubData['duration'] == Yii::app()->params['amPaymentDuration']['monthly']) {
                        $this->redirect(array('monthlyPaymentApplication'));
                    }
                    $this->redirect(array('cart'));
                }
                $allData = PackageSubscription::getPSArray($id);
                $type = Yii::app()->request->getParam('type');
                $subscriptions = PackageSubscription::getPSArray($id, $type);

                $i = 0;
                //Creates data-array to be send to view                                     
                $arrImg = $subDetails = array();
                if (count($subscriptions) > 0) {
                    do {
                        $subDetails[$i]['id'] = $subscriptions[$i]['subscription_id'];
                        $subDetails[$i]['name'] = $subscriptions[$i]['name'];
                        $videos = PackageSubscription::getVideoArray($subDetails[$i]['id']);
                        $subDetails[$i]['videos'] = $videos;
                        $i++;
                    } while ($i < count($subscriptions));
                }
                $this->render('one_subscription', array(
                    'allData' => $allData,
                    'subDetails' => $subDetails,
                    'amSelectedPackageSubData' => $amSelectedPackageSubData
                ));
            }
            //render view page
        }
    }

    /**
     * This is the action to display Shopping Cart
     */
    public function actionCart() {

        if (Yii::app()->user->hasState('amSelectedPackageSubData')) {
            Yii::app()->user->setState('amSelectedPackageSubData', NULL);
        }
        $userid = Yii::app()->admin->id;
        $cartItems = Cart::getCartItems($userid);
        // FOR DELETE SELECTED ORDERS //
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // FOR REMOVE ITEMS FROM THE CART //
            if (in_array("Delete", $_POST)) {
                $anDeletedIds = isset($_POST['itemids']) ? $_POST['itemids'] : array();
                if (count($anDeletedIds) > 0) {
                    $bDeleted = Cart::removeSelectedItems($anDeletedIds, $userid);
                    if ($bDeleted) {
                        Yii::app()->user->setFlash('success', "Record has been successfully deleted");
                        $this->redirect(array('cart'));
                    }
                }
            }
            // FOR ADD USER (STUDIO) ORDER WITH PENDING PEYMENT STATUS //
            if (in_array("Checkout", $_POST)) {
                $this->redirect(CController::createUrl('site/makePayment'));
            }
        }
        $this->render('cart', array('cartItems' => $cartItems));
    }

    public function actionMakePayment() {
        if (!Yii::app()->admin->id)
            $this->redirect(array('index/login'));

        $oMakePaymentForm = new MakePaymentForm();
        $snUserId = Yii::app()->admin->id;
        $amUserCart = Cart::getAllowedCartItems($snUserId);

        $ssView = 'monthlyPayment';
        if (count($amUserCart) > 0) {

            $ssView = ($amUserCart[0]['cart_duration'] == 1) ? 'monthlyPayment' : 'yearlyPayment';
            $oMakePaymentForm->payment_views = $amUserCart[0]['cart_duration'];
        }

        /* if (isset($_POST['MakePaymentForm']['payment_views'])) {
          $ssView = ($_POST['MakePaymentForm']['payment_views'] == 1) ? 'monthlyPayment' : 'yearlyPayment';
          $oMakePaymentForm->payment_views = $_POST['MakePaymentForm']['payment_views'];
          } */
        // FOR CONFIRM ORDER REDIRECTION //
        if (isset($_POST['Paypal'])) {
            $amPostData = $_POST;
            // FOR CASH / CHEQUE PAYMENT //
            if ($amPostData['MakePaymentForm']['payment_method'] != Yii::app()->params['comparePaymentMethods']['online']) {

                // SAVE STUDIO ORDER WITH PENDING STATUS //
                $snOrderId = $this->saveStudioOrderInfo($amUserCart, $amPostData);

                // REMOVE CHECKOUT ITEM FROM CART //                
                if ($snOrderId > 0 && count($amPostData['cartIds']) > 0) {
                    $anCartIds = $amPostData['cartIds'];
                    Cart::model()->deleteAll('id IN(' . implode(',', $anCartIds) . ')');

                    // REDIRECT WHEN STUDIO MAKE PAYMENT THORUGH CASH / CHEQUE //
                    Yii::app()->user->setFlash('order_info', $snOrderId);
                    $this->redirect(array('site/thankYou'));
                }
            } else {

                // FOR MONTHLY RECURRING PAYMENT //
                if ($amPostData['payment_views'] == 1 && $amPostData['MakePaymentForm']['payment_option'] == 1) {

                    // SAVE STUDIO ORDER WITH PENDING STATUS //
                    $snOrderId = $this->saveStudioOrderInfo($amUserCart, $amPostData);

                    if ($snOrderId > 0) {
                        // REMOVE CHECKOUT ITEM FROM CART //
                        if (count($amPostData['cartIds']) > 0) {
                            $anCartIds = $amPostData['cartIds'];
                            $snCartIds = base64_encode(json_encode($anCartIds));
                            //Cart::model()->deleteAll('id IN(' . implode(',', $anCartIds) . ')');
                        }
                        $this->redirect(Yii::app()->createUrl('site/recurringPayment', array('order_id' => $snOrderId, 'cart_ids' => $snCartIds)));
                    }
                } else { // FOR MONTHLY / YEARLY ONLIYE PAYMENT //
                    // SAVE STUDIO ORDER WITH PENDING STATUS //
                    $snOrderId = $this->saveStudioOrderInfo($amUserCart, $amPostData);

                    if ($snOrderId > 0) {
                        // REMOVE CHECKOUT ITEM FROM CART //
                        if (count($amPostData['cartIds']) > 0) {
                            $anCartIds = $amPostData['cartIds'];
                            $snCartIds = base64_encode(json_encode($anCartIds));
                            //Cart::model()->deleteAll('id IN(' . implode(',', $anCartIds) . ')');
                        }
                        $this->redirect(Yii::app()->createUrl('site/fullPayment', array('order_id' => $snOrderId, 'cart_ids' => $snCartIds)));
                    }
                }
            }
        }

        $this->render('makePayment', array(
            'cartItems' => $amUserCart,
            'oMakePaymentForm' => $oMakePaymentForm,
            'ssView' => $ssView,
        ));
    }

    public function actionRecurringPayment($order_id, $cart_ids) {
        if (!Yii::app()->admin->id)
            $this->redirect(array('index/login'));

        $PayFlowPaymentForm = new PayFlowPaymentForm();
        $PayFlowPaymentForm->scenario = 'recurring_payment';
        $PayFlowPaymentForm->payment_method = 'C';
        $PayFlowPaymentForm->account_type = 'S';
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
            $PayFlowPaymentForm->payment_method = $amPostData['payment_method'];
            if ($PayFlowPaymentForm->validate()) {

                $snTotRecurringAmt = $snTotYearlyAmt = 0;
                foreach ($omOrder->orderDetails as $omOrderDetails) {
                    if ($omOrderDetails->duration == 1)
                        $snTotRecurringAmt += $omOrderDetails->amount;
                    else
                        $snTotYearlyAmt += $omOrderDetails->amount;
                }
                $bAtleastOneSuccess = false;
                if ($snTotRecurringAmt > 0) {
                    // CREATE RECURRING PROFILE USING PAYFLOW PRO API //
                    $amResponse = $this->payFlowCreateRecurringProfile($PayFlowPaymentForm->attributes, $snTotRecurringAmt);
                    if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) {

                        $bAtleastOneSuccess = true;
                        // REMOVE CHECKOUT ITEM FROM CART //
                        $anCartItems = json_decode(base64_decode($cart_ids));
                        if (count($anCartItems) > 0) {
                            Cart::model()->deleteAll('id IN(' . implode(',', $anCartItems) . ')');
                        }
                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $omOrder->id);
                        Common::commonUpdateField("orders", "recurring_profile_id", $amResponse['PROFILEID'], "id", $omOrder->id);
                        Yii::app()->user->setFlash('success', "Thank you for your order.");
                        Yii::app()->user->setFlash('order_info', $omOrder->id);
                    } else {

                        $ssMessage = isset(Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']]) ? Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']] : "There are some error in payment. Try again later.";
                        $ssMessage = 'Error Code: ' . $amResponse['RESULT'] . ' Error Message: ' . $ssMessage;
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $omOrder->id);
                        Common::commonUpdateField("orders", "payment_error_message", $ssMessage, "id", $omOrder->id);
                        Yii::app()->user->setFlash('error', $ssMessage);
                    }
                }
                // MAKE FULL PAYMENT THROUGH PAYFLOW PRO API //
                if ($snTotYearlyAmt > 0) {
                    $amResponse = $this->payFlowExpressCheckout($PayFlowPaymentForm->attributes, $snTotYearlyAmt);
                    if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) {
                        $bAtleastOneSuccess = true;

                        // REMOVE CHECKOUT ITEM FROM CART //
                        $anCartItems = json_decode(base64_decode($cart_ids));
                        if (count($anCartItems) > 0) {
                            Cart::model()->deleteAll('id IN(' . implode(',', $anCartItems) . ')');
                        }
                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $omOrder->id);
                    } else {

                        $ssMessage = isset(Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']]) ? Yii::app()->params['paymentErrorResponse'][$amResponse['RESULT']] : "There are some error in payment. Try again later.";
                        $ssMessage = 'Error Code: ' . $amResponse['RESULT'] . ' Error Message: ' . $ssMessage;
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $omOrder->id);
                        Common::commonUpdateField("orders", "payment_error_message", $ssMessage, "id", $omOrder->id);
                        Yii::app()->user->setFlash('error', $ssMessage);
                    }
                }

                if ($bAtleastOneSuccess)
                    $this->redirect(Yii::app()->createUrl('admin/videos/index'));
            }
        }

        $omStates = StateMaster::getStatesAsPerCountry(Yii::app()->params['default_country']['US']);
        $amStates = CHtml::listData($omStates, 'state_abbv', 'state_name');
        $this->render('recurringPayment', array(
            'PayFlowPaymentForm' => $PayFlowPaymentForm,
            'snCheckoutPrice' => $omOrder->amount_paid,
            'omOrder' => $omOrder,
            'omUser' => $omUser,
            'amStates' => $amStates
        ));
    }

    public function actionFullPayment($order_id, $cart_ids) {
        if (!Yii::app()->admin->id)
            $this->redirect(array('index/login'));
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
                // MAKE DIRECTT PAYMENT THROUGH PAYFLOW PRO API //                
                $amResponse = $this->payFlowExpressCheckout($PayFlowPaymentForm->attributes, $omOrder->amount_paid);
                if (isset($amResponse['RESULT']) && $amResponse['RESULT'] == 0) {

                    // REMOVE CHECKOUT ITEM FROM CART //
                    $anCartItems = json_decode(base64_decode($cart_ids));
                    if (count($anCartItems) > 0) {
                        Cart::model()->deleteAll('id IN(' . implode(',', $anCartItems) . ')');
                    }
                    // UPDATE INTO ORDER DUE PAYMENT STATUS //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $omOrder->id);

                    Yii::app()->user->setFlash('success', "Thank you for your order.");
                    Yii::app()->user->setFlash('order_info', $omOrder->id);
                    $this->redirect(Yii::app()->createUrl('admin/videos/index'));
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
        $this->render('fullPayment', array(
            'PayFlowPaymentForm' => $PayFlowPaymentForm,
            'snCheckoutPrice' => $omOrder->amount_paid,
            'omUser' => $omUser,
            'amStates' => $amStates
        ));
    }

    public function saveStudioOrderInfo($amUserCart, $amPostData) {

        $snItemPrice = $snCheckoutPrice = $snFullOneItemPrice = 0;
        $anPackageSubIds = array();
        foreach ($amUserCart as $amData) {
            // 1-Monthly, 2- Yearly
            if ($amData['cart_duration'] == 1) {
                $snItemPrice = ($amData['cart_duration'] == Yii::app()->params['amPaymentDuration']['monthly']) ? $amData['price'] : $amData['price_one_time'];
                $snFullOneItemPrice = ($amPostData['MakePaymentForm']['payment_option'] == 2) ? ($snItemPrice * 24) : $snItemPrice;
                $snCheckoutPrice += $snFullOneItemPrice;
                $anPackageSubIds[] = array('package_sub_id' => $amData['id'],
                    'type' => $amData['type'],
                    'price' => $snItemPrice,
                    'cart_duration' => $amData['cart_duration'],
                    'video_id' => $amData['video_id']
                );
            }
            if ($amData['cart_duration'] == 2) {
                $snItemPrice = ($amData['cart_duration'] == Yii::app()->params['amPaymentDuration']['monthly']) ? $amData['price'] : $amData['price_one_time'];
                $snCheckoutPrice += $snItemPrice;
                $anPackageSubIds[] = array('package_sub_id' => $amData['id'],
                    'type' => $amData['type'],
                    'price' => $snItemPrice,
                    'cart_duration' => $amData['cart_duration'],
                    'video_id' => $amData['video_id']
                );
            }
        }
        // 1- Monthly Recurring Payment, 2- Yearly Payment, 3- Monthly Full Payment.
        $snPaymentType = ($amPostData['payment_views'] == 2 ) ? 2 : (($amPostData['payment_views'] == 1 && $amPostData['MakePaymentForm']['payment_option'] == 1) ? 1 : 3);
        // FOR ADD USER (STUDIO) ORDER WITH PENDING PAYMENT STATUS //                
        if (count($anPackageSubIds) > 0) {

            $amOrderInfo = array(
                'user_id' => Yii::app()->admin->id,
                'payment_status' => Yii::app()->params['amPaymentStatus']['pending'],
                'sub_total' => $snCheckoutPrice,
                'tax' => 0,
                'amount_paid' => $snCheckoutPrice,
                'shipping' => 0,
                'payment_date' => date('Y-m-d H:i:s'),
                'payment_type' => $snPaymentType
            );
            $omOrder = Orders::saveStudioOrderInfo($amOrderInfo);
            foreach ($anPackageSubIds as $amData) {
                // Phase-II: Change monthly user expiry date as per discuss with Aidan //
                $expiryDateTime = ($amData['cart_duration'] == 1) ? date('Y-m-d H:i:s', strtotime('+24 month')) : date('Y-m-d H:i:s', strtotime('+1 year'));
                $amOrderDetails = array(
                    'order_id' => $omOrder->id,
                    'package_subscription_id' => $amData['package_sub_id'],
                    'amount' => $amData['price'],
                    'shipping' => 0,
                    'start_date' => date('Y-m-d H:i:s'),
                    'expiry_date' => $expiryDateTime,
                    'duration' => $amData['cart_duration']
                );
                OrderDetails::saveStudioOrderDetails($amOrderDetails);
                // FOR ADD STUDIO PURCHASED VIDEOS INTO USER PURCHASED VIDEOS TABLE //
                $snPackageId = ($amData['type'] == "Package") ? $amData['package_sub_id'] : 0;
                UserPurchasedVideos::assignVideosToUser($amData['video_id'], $snPackageId);
            }
            return $omOrder->id;
        }
        return false;
    }

    /**
     * This is the action is to make RECURRING payment using Credit Card
     */
    /* public function callCreateRecurringPaymentsProfile($frmResponse) {
      // Initialize Values in payment Object by values from front-end //
      $objPaypal = new Paypal();
      $paymentType = urlencode('Sale');
      $amount = urlencode($frmResponse['totAmount']);    // or 'Sale'
      $creditCardType = urlencode($frmResponse['card_type']);
      $creditCardNumber = urlencode($frmResponse['card_number']);
      $expDateMonth = urlencode($frmResponse['expiration_month']);
      //Recurring Details
      $startDate = urlencode(date('Y-m-d H:i:s', strtotime('+1 month')));
      $billingPeriod = urlencode("Month");    // or "Day", "Month", "Week", "SemiMonth", "Year"
      $billingFreq = urlencode("1");
      $totalBillingCycle = urlencode("23");
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
      "&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID&";
      $nvpStr .= "PROFILESTARTDATE=$startDate&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFreq&TOTALBILLINGCYCLES=$totalBillingCycle&DESC=TwinkleStarDance";
      $responseCRPP = $objPaypal->CreateRecurringPaymentsProfile('CreateRecurringPaymentsProfile', $nvpStr);
      return $responseCRPP;
      } */

    /**
     * This is the action is to make payment using Credit Card
     */
    /* public function callDoDirectPayment($frmResponse) {
      // Initialize Values in payment Object by values from front-end //
      $objPaypal = new Paypal();
      $paymentType = urlencode('Sale');
      $amount = urlencode($frmResponse['totAmount']);    // or 'Sale'
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
      } */

    /**
     * This is the action to display Shopping Cart
     */
    public function actionContact() {
        $oModel = new ContactForm();

        // SET DEFAULT ATTRIBUTE //
        $oModel->contact_name = Yii::t('app', 'Name');
        $oModel->contact_email = Yii::t('app', 'Email');
        $oModel->contact_phone = Yii::t('app', 'Phone Number');
        $oModel->contact_subject = Yii::t('app', 'Subject');
        $oModel->contact_message = Yii::t('app', 'Message');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $amPostData = $_POST['ContactForm'];
            $amPostData['contact_name'] = ($amPostData['contact_name'] == "Name") ? "" : $amPostData['contact_name'];
            $amPostData['contact_email'] = ($amPostData['contact_email'] == "Email") ? "" : $amPostData['contact_email'];
            $amPostData['contact_phone'] = ($amPostData['contact_phone'] == "Phone Number") ? "" : $amPostData['contact_phone'];
            $amPostData['contact_subject'] = ($amPostData['contact_subject'] == "Subject") ? "" : $amPostData['contact_subject'];
            $amPostData['contact_message'] = ($amPostData['contact_message'] == "Message") ? "" : $amPostData['contact_message'];
            $oModel->setAttributes($amPostData);
            if ($oModel->validate()) {
                $omAdminInfo = Users::model()->findByPk(Yii::app()->params['admin_id']);
                // FOR SEND MAIL //                
                $bMailSent = Common::sendMail($omAdminInfo->contact_email, array($amPostData['contact_email'] => ucfirst($amPostData['contact_name'])), $amPostData['contact_subject'], $amPostData['contact_message']);
                if ($bMailSent)
                    Yii::app()->user->setFlash('success', Yii::t("messages", "Your request has been successfully sent to admin."));
                $this->redirect(array('contact'));
            }
        }
        $this->render('contact', array('model' => $oModel));
    }

    /**
     * This is the action to display postpayment results
     */
    public function actionPostpayment() {
        $this->render('postpayment', array());
    }

    public function actionAddToClass() {
        if (!Yii::app()->user->isGuest) {
            // FOR GET CLASS DETAILS AS PER CLASS TOKEN //
            $ssToken = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
            $omClassModel = Classes::model()->findByAttributes(array("token" => $ssToken));
            if ($omClassModel) {

                // FOR CHECK DANCER ALREADY EXISTS FOR THIS CLASS //
                $snUserId = Yii::app()->user->id;
                $omExists = ClassUsers::model()->findByAttributes(array("class_id" => $omClassModel->id, "user_id" => $snUserId));
                if (!$omExists) {
                    // FOR ADD USER UNDER CLASS //
                    $oModelUser = new ClassUsers();
                    $oModelUser->class_id = $omClassModel->id;
                    $oModelUser->user_id = $snUserId;
                    $oModelUser->save();
                }

                $ssClassVideosLink = CHtml::link(Yii::t('app', 'Click here'), CController::createUrl("admin/classes/listClassVideos", array("id" => $omClassModel->id)), array('target' => '_blank'));
                Yii::app()->user->setFlash('success', Yii::t("messages", "Thank you for registering for this class, $ssClassVideosLink to view class videos."));
                $this->render('addToClass');
            } else {
                Yii::app()->user->setFlash('error', Yii::t("messages", "Invalid class token!"));
                $this->render('addToClass');
            }
        } else {
            $this->redirect(Yii::app()->createUrl('index/login', array('isDancer' => 1, 'token' => $_REQUEST['token'])));
        }
    }

    /* public function callPayPalService($anPackageSubId, $snOrderId, $snTotalPrice, $anCartIds = array(), $anOrderDetailsIds = array()) {

      // Phase:II
      // SAVE USER SELECTED VIDEOS FROM USER PURCHASED VIDEO TABLE //
      $ssEncodeParams = base64_encode(json_encode(array('order_id' => $snOrderId,
      'amPackageSubDetails' => $anPackageSubId,
      'isStudio' => 1,
      'user_id' => Yii::app()->admin->id,
      'cart_id' => $anCartIds,
      'anOrderDetailsIds' => $anOrderDetailsIds
      )));
      $this->redirect(CController::createUrl('site/payflowPayment', array('reqData' => $ssEncodeParams,
      'snAmount' => $snTotalPrice)
      ));
      } */
    /*
      public function actionPayflowPayment($reqData, $snAmount) {

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
      } */

    public function actionUpdateStudioOrder() {

        if (isset($_REQUEST['CUSTID']) && isset($_REQUEST['RESULT'])) {
            $amDecodeParams = (array) json_decode(base64_decode($_REQUEST['CUSTID']));
            $snOrderId = $amDecodeParams['order_id'];
            $snUserId = isset($amDecodeParams['user_id']) ? $amDecodeParams['user_id'] : 0;

            if (isset($amDecodeParams['studioDuePayment'])) {

                // FOR UPDATE SINGLE PAYMENT MODE //
                if ($amDecodeParams['mode'] == Yii::app()->params['comparePaymentMode']['single']) {
                    $snOrderDetailsId = $amDecodeParams['order_details_id'];
                    if ($_REQUEST['RESULT'] == 0) {

                        // UPDATE INTO ORDER DUE PAYMENT STATUS //
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderId);
                        // UPDATE SUB ORDER PAYMENT STATUS //
                        Common::commonUpdateField("order_details", "sub_payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderDetailsId);

                        Yii::app()->user->setFlash('success', "Thank you for order.");
                        $this->redirect(Yii::app()->createUrl('admin/users/myAccounts'));
                    } else {
                        // PAYMENT ERROR LOG //
                        $ssLog = file_get_contents(Yii::getPathOfAlias('webroot') . "/payment_error.log");
                        $ssLog .= "\n===================" . date('d-m-Y H:i:s') . "===================";
                        $ssLog .= print_R($_REQUEST, true);
                        $ssLog .= "************************************************************\n";
                        file_put_contents(Yii::getPathOfAlias('webroot') . "/payment_error.log", $ssLog);

                        // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                        Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $snOrderId);
                        Yii::app()->user->setFlash('error', "Error in payment process, please try again later.");
                        $this->redirect(Yii::app()->createUrl('admin/users/myAccounts'));
                    }
                } else { // FOR ALL DUE PEYMENT UPDATES //
                    $anOrderDetailsId = $amDecodeParams['order_details_id'];
                    // UPDATE INTO ORDER DUE PAYMENT STATUS //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderId);
                    // UPDATE SUB ORDER PAYMENT STATUS //
                    foreach ($anOrderDetailsId as $snOrderDetailsId) {
                        Common::commonUpdateField("order_details", "sub_payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderDetailsId);
                    }

                    Yii::app()->user->setFlash('success', "Thank you for order.");
                    $this->redirect(Yii::app()->createUrl('admin/users/myAccounts'));
                }
            } elseif ($amDecodeParams['isStudio']) {

                $anOrderDetailsIds = $amDecodeParams['anOrderDetailsIds'];
                $anCartIds = (array) $amDecodeParams['cart_id'];

                //$anVideoId = explode(',', $amDecodeParams['amPackageSubDetails'][0]->video_id);
                if ($_REQUEST['RESULT'] == 0) {

                    // UPDATE MAIN ORDER PAYMENT STATUS //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderId);
                    // UPDATE SUB ORDER PAYMENT STATUS //
                    foreach ($anOrderDetailsIds as $snOrderDetailsId) {
                        Common::commonUpdateField("order_details", "sub_payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderDetailsId);
                    }
                    // FOR EMPTY USER CART /
                    if (count($anCartIds) > 0) {
                        // Phase-II REMOVE ITEMS FROM CART WHICH ARE SUCCESSFULLY CHECKOUT  //
                        Cart::model()->deleteAll('id IN(' . implode(',', $anCartIds) . ')');
                    }

                    Yii::app()->user->setFlash('success', "Thank you for order.");
                    $this->redirect(CController::createUrl('admin/videos/index'));
                } else {
                    // PAYMENT ERROR LOG //
                    $ssLog = file_get_contents(Yii::getPathOfAlias('webroot') . "/payment_error.log");
                    $ssLog .= "\n===================" . date('d-m-Y H:i:s') . "===================";
                    $ssLog .= print_R($_REQUEST, true);
                    $ssLog .= "************************************************************\n";
                    file_put_contents(Yii::getPathOfAlias('webroot') . "/payment_error.log", $ssLog);

                    // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $snOrderId);
                    Yii::app()->user->setFlash('error', "Error in payment process, please try again later.");
                    $this->redirect(CController::createUrl('admin/videos/index'));
                }
            } else { // FOR DANCER UPDATE ORDER //
                $snClassId = $amDecodeParams['class_id'];
                if ($_REQUEST['RESULT'] == 0) {

                    // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['paid'], "id", $snOrderId);

                    // ADD DANCER PURCHASED VIDEOS INTO ORDER TRANSACTION TABLE //
                    $anVideoIds = $amDecodeParams['videoids'];
                    UserVideosTransaction::saveUserVideos($snClassId, $anVideoIds, $snOrderId);

                    Yii::app()->user->setFlash('success', "Thank you for purchasing the videos.");
                    $this->redirect(CController::createUrl('admin/classes/listClassVideos', array("id" => $snClassId)));
                } else {
                    // UPDATE ORDER PAYMENT STATUS FOR DANCER //
                    Common::commonUpdateField("orders", "payment_status", Yii::app()->params['amPaymentStatus']['failed'], "id", $snOrderId);
                    Yii::app()->user->setFlash('error', "Error in payment.");
                    $this->redirect(CController::createUrl('admin/classes/listClassVideos', array("id" => $snClassId)));
                }
            }
        } else {
            Yii::app()->user->setFlash('error', "Your payment was not successfully, Please try again later.");
            $this->redirect(array('index/index'));
        }
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

    /*
      public function actionCreateRecurringProfile() {

      $oPayFlow = new PayPalPayflowPro();

      //these are provided by your payflow reseller
      $oPayFlow->PARTNER = 'PayPal';
      $oPayFlow->USER = 'Twinklestardance';
      $oPayFlow->PWD = 'brande192';
      $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name
      // CREDIT/DEBIT CARD TRANSACTION //
      //$oPayFlow->ACCT = '4111111111111111';
      //$oPayFlow->EXPDATE = '1218';
      $oPayFlow->AMT = '69.99';

      // CUSTOMER BANK INFO //
      $oPayFlow->ABA = '111111118';   // Target Bank's transit ABA routing number
      $oPayFlow->ACCT = '1111111111';  // Bank account number / Credit Card Number
      $oPayFlow->ACCTTYPE = 'C';  // Bank account type: Savings (S) or Checking (C)

      $oPayFlow->FIRSTNAME = 'Karl-C';
      $oPayFlow->LASTNAME = 'Marks-C';
      $oPayFlow->STREET = '123 mystreet';
      $oPayFlow->CITY = 'Modesto';
      $oPayFlow->STATE = 'CA';
      $oPayFlow->ZIP = '95397';
      $oPayFlow->COUNTRY = 'US';

      $oPayFlow->START = '11282013';
      $oPayFlow->PAYPERIOD = 'MONT';
      $oPayFlow->TERM = '24';
      $oPayFlow->ACTION = 'A';
      $oPayFlow->PROFILENAME = 'Karl-C Marks-C';
      $oPayFlow->COMMENT1 = 'Recurring-Profile';
      $oPayFlow->CURRENCY = 'USD';

      //https://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/transaction_type_codes.htm
      $oPayFlow->TRXTYPE = 'R';   // R stands for recurring profile
      $oPayFlow->TENDER = 'C';    // 'C' (through credit card), 'A' (through bank account)
      //$this->environment = 'live';
      //$oPayFlow->debug = true; //uncomment to see debugging information
      //$oPayFlow->avs_addr_required = 1; //set to 1 to enable AVS address checking, 2 to force "Y" response
      //$oPayFlow->avs_zip_required = 1; //set to 1 to enable AVS zip code checking, 2 to force "Y" response
      //$oPayFlow->cvv2_required = 1; //set to 1 to enable cvv2 checking, 2 to force "Y" response
      //$oPayFlow->fraud_protection = true; //uncomment to enable fraud protection

      $oPayFlow->createRecurringProfile();

      p($oPayFlow->amResponse);
      }

      public function actionCheckRecurringPaymentStatus() {
      $oPayFlow = new PayPalPayflowPro();

      //these are provided by your payflow reseller
      $oPayFlow->PARTNER = 'PayPal';
      $oPayFlow->USER = 'Twinklestardance';
      $oPayFlow->PWD = 'brande192';
      $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name

      $oPayFlow->ACTION = 'I';  // If (P) then PAYMENTNUMBER required
      $oPayFlow->TRXTYPE = 'R';
      //$oPayFlow->TENDER = 'C';

      $oPayFlow->ORIGPROFILEID = 'RT0000000001';
      //$oPayFlow->PAYMENTNUM = '1';
      $oPayFlow->PAYMENTHISTORY = 'Y';

      //$oPayFlow->AMT = '1.99';


      $oPayFlow->callRequest();

      p($oPayFlow->amResponse);
      } */

    public function actionTestExpressCheckout() {

        $oPayFlow = new PayPalPayflowPro();

        //these are provided by your payflow reseller
        $oPayFlow->PARTNER = (Configurations::getValue('paypal_partner') != '') ? Configurations::getValue('paypal_partner') : Yii::app()->params['PARTNER'];
        $oPayFlow->USER = (Configurations::getValue('paypal_merchant_login') != '') ? Configurations::getValue('paypal_merchant_login') : Yii::app()->params['LOGIN'];
        $oPayFlow->PWD = (Configurations::getValue('paypal_password') != '') ? Configurations::getValue('paypal_password') : Yii::app()->params['PASSWORD'];
        $oPayFlow->VENDOR = $oPayFlow->USER; //or your vendor name

        $oPayFlow->AMT = '9.99';

        // CUSTOMER BANK INFO //
        $oPayFlow->ABA = '111111118';   // Target Bank's transit ABA routing number
        $oPayFlow->ACCT = '1111111111';  // Bank account number / Credit Card Number
        $oPayFlow->ACCTTYPE = 'C';  // Bank account type: Savings (S) or Checking (C)

        $oPayFlow->FIRSTNAME = 'Karl-C-Test';
        $oPayFlow->LASTNAME = 'Marks-C-Test';
        $oPayFlow->EMAIL = 'testsample@gmail.com';
        $oPayFlow->STREET = '123 mystreet';
        $oPayFlow->CITY = 'Modesto';
        $oPayFlow->STATE = 'CA';
        $oPayFlow->ZIP = '95397';
        $oPayFlow->COUNTRY = 'US';
        $oPayFlow->CURRENCY = 'USD';

        $oPayFlow->TRXTYPE = 'S';   // R stands for recurring profile
        $oPayFlow->TENDER = 'A';    // 'C' (through credit card), 'A' (through bank account)        
        $oPayFlow->ACTION = 'S';
        $oPayFlow->sendRequest();

        return $oPayFlow->amResponse;
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
    public function actionWatchVideoPublisFb() {
        
        $this->layout = false;
        $omVideo = Videos::model()->findByPk($_REQUEST['id']);
        $this->render('watchVideoPublisFb', array(
            'omVideo' => $omVideo
        ));
    }

}
