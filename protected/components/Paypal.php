<?php

class Paypal {

    public $environment = 'sandbox';    // Replace with "live" into production server 
//    public $API_UserName = 'sdk-three_api1.sdk.com';
//    public $API_Password = 'QFZCWN5HZM8VBG7Q';
//    public $API_Signature =  'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI';
    public $API_UserName = 'seller_1361962509_biz_api1.inheritx.com';
    public $API_Password = '1361962570';
    public $API_Signature = 'A4H6VwvmsQXvpnxv0AsEhVxgBivRARz5f3930EVxImyL3yWebenwjlfJ';
    public $API_Endpoint = "https://api-3t.paypal.com/nvp";
    public $paymentAmount = '5.00';
    public $currencyID = 'USD';  // or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
    public $paymentType = 'Authorization'; // or 'Sale' or 'Order'
    public $returnURL = 'http://localhost/twinklestardance/admin/CreditCard/index';
    public $cancelURL = 'http://localhost/twinklestardance/admin/CreditCard/index';
    public $version = '93.0';
//    public $startDate;
//    public $billingPeriod = "Month";  // or "Day", "Week", "SemiMonth", "Year","Month"
//    public $billingFreq = "1";
    public $USE_PROXY = false;
    public $PROXY_HOST = '127.0.0.1';
    public $PROXY_PORT = '808';
    public $sBNCode = "PP-ECWizard";

    public function __construct() {
        $this->API_UserName = urlencode($this->API_UserName);
        $this->API_Password = urlencode($this->API_Password);
        $this->API_Signature = urlencode($this->API_Signature);
        $this->paymentAmount = urlencode($this->paymentAmount);
        $this->currencyID = urlencode($this->currencyID);   // or other currency code ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
        $this->paymentType = urlencode($this->paymentType); // or 'Sale' or 'Order'
        $this->returnURL = urlencode('http://' . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . '/index.php/customer/CreditCard/index');
        $this->cancelURL = urlencode('http://' . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . '/index.php/customer/CreditCard/index');
        $this->version = urlencode($this->version);
//        $this->startDate = urlencode(date('Y-m-d h:m:s'));
//        $this->billingPeriod = urlencode($this->billingPeriod);
//        $this->billingFreq = urlencode($this->billingFreq);
    }

    public function __destruct() {
        
    }

    /**
     * Send HTTP POST Request
     *
     * @param	string	The API method name
     * @param	string	The POST Message fields in &name=value pair format
     * @return	array	Parsed HTTP Response body
     */
    function SetExpressCheckout($methodName_, $nvpStr_) {

        if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
        }

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $this->API_Endpoint.");
        }

        // Check the output and perform action accordingly
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
            // Redirect to paypal.com.
            $token = urldecode($httpParsedResponseAr["TOKEN"]);
            $payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=$token";
            if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
                $payPalURL = "https://www.$this->environment.paypal.com/webscr&cmd=_express-checkout&token=$token";
            }
            header("Location: $payPalURL");
            exit;
        } else {
            exit('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
        }
        return $httpParsedResponseAr;
    }

    /**
     * Send HTTP POST Request
     *
     * @param	string	The API method name
     * @param	string	The POST Message fields in &name=value pair format
     * @return	array	Parsed HTTP Response body
     */
    function GetExpressCheckoutDetails($methodName_) {

        // Obtain the token from PayPal.
        if (!array_key_exists('token', $_REQUEST)) {
            exit('Token is not received.');
        }
        // Set request-specific fields.
        $token = urlencode($_REQUEST['token']);
        // Add request-specific fields to the request string.
        $nvpStr_ = "&TOKEN=$token";

        // Execute the API operation; see the PPHttpPost function above.                             
        if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
        }

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.        
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit('$methodName_ failed: ' . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $this->API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

    function DoExpressCheckoutPayment($methodName_, $responseGECD) {

        $payerID = $responseGECD['PAYERID'];
        $token = $responseGECD['TOKEN'];
        $this->paymentType = urlencode('Sale');
        $this->paymentAmount = $responseGECD['AMT'];
        $this->currencyID = $responseGECD['CURRENCYCODE'];
        // Add request-specific fields to the request string.
        $nvpStr_ = "&TOKEN=$token&PAYERID=$payerID&PAYMENTACTION=$this->paymentType&AMT=$this->paymentAmount&CURRENCYCODE=$this->currencyID";
        if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
        }

        $ch = curl_init();
        // setting the curl parameters.
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Set the curl parameters.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit('$methodName_ failed: ' . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            return "Invalid HTTP Response for POST request($nvpreq) to $this->API_Endpoint.";
        }

        if ("SUCCESS" != strtoupper($httpParsedResponseAr["ACK"]) && "SUCCESSWITHWARNING" != strtoupper($httpParsedResponseAr["ACK"])) {
            return 'DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true);
        }
        return $httpParsedResponseAr;
    }

    function DoDirectPayment($methodName_, $nvpStr_) {

        // Add request-specific fields to the request string.        
        if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
        }

        $ch = curl_init();
        // setting the curl parameters.
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Set the curl parameters.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit('$methodName_ failed: ' . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            return "Invalid HTTP Response for POST request($nvpreq) to $this->API_Endpoint.";
        }

        if ("SUCCESS" != strtoupper($httpParsedResponseAr["ACK"]) && "SUCCESSWITHWARNING" != strtoupper($httpParsedResponseAr["ACK"])) {
            return 'DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true);
        }
        return $httpParsedResponseAr;
    }

    function CreateRecurringPaymentsProfile($methodName_, $nvpStr_) {


        if ("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
        }
        $this->version = urlencode('93.0');

        // setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // NVPRequest for submitting to server
        $nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature&$nvpStr_";

        // setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // getting response from server
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the RefundTransaction response details
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $this->API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

    /**
     * Performs an Express Checkout NVP API operation as passed in $action.
     *
     * Although the PayPal Standard API provides no facility for cancelling a subscription, the PayPal
     * Express Checkout  NVP API can be used.
     */
    function change_subscription_status($profile_id, $action, $date = false) {

        $this->API_Endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
        /* $api_request = 'USER=' . urlencode( 'parth_1354774819_biz_api1.inheritx.com' )
          .  '&PWD=' . urlencode( '1354774874' )
          .  '&SIGNATURE=' . urlencode('An5ns1Kso7MWUdW4ErQKJJJ4qi4-AMmXT5BxuY11EvZogQCnxweqLbnp')
          .  '&VERSION=76.0'
          .  '&METHOD=ManageRecurringPaymentsProfileStatus'
          .  '&PROFILEID=' . urlencode( $profile_id )
          .  '&ACTION=' . urlencode( $action )
          .  '&NOTE=' . urlencode( 'Profile cancelled at store' ); */
        $api_request = 'USER=' . $this->API_UserName
                . '&PWD=' . $this->API_Password
                . '&SIGNATURE=' . $this->API_Signature
                . '&VERSION=76.0'
                . '&METHOD=ManageRecurringPaymentsProfileStatus'
                . '&PROFILEID=' . urlencode($profile_id)
                . '&ACTION=' . urlencode($action)
                . '&BILLINGPERIOD=' . $this->billingPeriod;
        //		.  '&PROFILESTARTDATE='. $this->startdate;

        if (!empty($date)) {
            $api_request .= //'&NEXTBILLINGDATE='.$date
                    '&PROFILESTARTDATE=' . $date
                    . '&NOTE=' . urlencode('Profile Reactive at store');
        } else {
            $api_request .= '&NOTE=' . urlencode('Profile cancelled at store');
        }

        $curlOptions = array(
            CURLOPT_URL => $this->API_Endpoint,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => dirname(__FILE__) . '/../../cacert.pem', //CA cert file
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $api_request
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        //	curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
        //curl_setopt( $ch,  $curlOptions); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
        //curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
        // Uncomment these to turn off server and peer verification
        // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        //curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt( $ch, CURLOPT_POST, 1 );
        // Set the API parameters for this transaction
        //curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );
        // Request response from PayPal
        $response = curl_exec($ch);

        // If no response was received from PayPal there is no point parsing the response
        if (!$response)
            die('Calling PayPal to change_subscription_status failed: ' . curl_error($ch) . '(' . curl_errno($ch) . ')');

        curl_close($ch);

        // An associative array is more usable than a parameter string
        parse_str($response, $parsed_response);

        return $parsed_response;
    }

    public function hash_call($methodName, $nvpStr) {
        //declaring of global variables
        //p($nvpStr);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
        if ($USE_PROXY)
            curl_setopt($ch, CURLOPT_PROXY, $this->PROXY_HOST . ":" . $this->PROXY_PORT);

        //NVPRequest for submitting to server
        $nvpreq = "METHOD=" . urlencode($methodName) . "&VERSION=" . $this->version . "&PWD=" . $this->API_Password . "&USER=" . $this->API_UserName . "&SIGNATURE=" . $this->API_Signature . $nvpStr . "&BUTTONSOURCE=" . urlencode($this->sBNCode);

        // var_dump($nvpreq);
        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        //getting response from server
        $response = curl_exec($ch);
        p($response);
        //convrting NVPResponse to an Associative Array
        $nvpResArray = deformatNVP($response);
        $nvpReqArray = deformatNVP($nvpreq);
        $_SESSION['nvpReqArray'] = $nvpReqArray;

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
            $_SESSION['curl_error_no'] = curl_errno($ch);
            $_SESSION['curl_error_msg'] = curl_error($ch);

            //Execute the Error handling module to display errors. 
        } else {
            //closing the curl
            curl_close($ch);
        }

        return $nvpResArray;
    }

}
