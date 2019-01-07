<?php

/**
 * https://cms.paypal.com/cms_content/US/en_US/files/developer/PP_PayflowPro_Guide.pdf
 *
 */
class PayPalPayflowPro {

    const HTTP_RESPONSE_OK = 200;
    const KEY_MAP_ARRAY = 'map';

    public $environment;
    public $data;
    public $headers = array();
    public $gateway_retries = 3;
    public $gateway_retry_wait = 5; //seconds    
    public $vps_timeout = 45;
    public $curl_timeout = 90;
    public $gateway_url_live = 'https://payflowpro.paypal.com:443';
    public $gateway_url_devel = 'https://pilot-payflowpro.paypal.com:443'; //test-payflow.verisign.com
    public $avs_addr_required = 0;
    public $avs_zip_required = 0;
    public $cvv2_required = 0;
    public $fraud_protection = false;
    public $raw_response;
    public $response_arr = array();
    public $txn_successful = null;
    public $raw_result;
    public $debug = false;
    public $amResponse = array();

    public function __construct() {
        
        $this->environment = (Configurations::getValue('paypal_payment_mode') != '') ? Configurations::getValue('paypal_payment_mode') : Yii::app()->params['MODE'];
        $this->load_config();
    }

    public function load_config() {

        if (defined('PAYFLOWPRO_USER')) {
            $this->data['USER'] = constant('PAYFLOWPRO_USER');
        }

        if (defined('PAYFLOWPRO_PWD')) {
            $this->data['PWD'] = constant('PAYFLOWPRO_PWD');
        }

        if (defined('PAYFLOWPRO_PARTNER')) {
            $this->data['PARTNER'] = constant('PAYFLOWPRO_PARTNER');
        }

        if (defined('PAYFLOWPRO_VENDOR')) {
            $this->data['VENDOR'] = constant('PAYFLOWPRO_VENDOR');
        } else {
            if (isset($this->data['USER'])) {
                $this->data['VENDOR'] = $this->data['USER'];
            } else {
                $this->data['VENDOR'] = null;
            }
        }
    }

    public function __set($key, $val) {

        $this->data[$key] = $val;
    }

    public function __get($key) {

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    public function get_gateway_url() {

        if (strtolower($this->environment) == 'live') {
            return $this->gateway_url_live;
        } else {
            return $this->gateway_url_devel;
        }
    }

    public function get_data_string() {

        $query = array();

        if (!isset($this->data['VENDOR']) || !$this->data['VENDOR']) {
            $this->data['VENDOR'] = $this->data['USER'];
        }
        foreach ($this->data as $key => $value) {

            if ($this->debug) {
                echo "{$key} = {$value}";
            }

            $query[] = strtoupper($key) . '[' . strlen($value) . ']=' . $value;
        }

        return implode('&', $query);
    }

    public function before_send_transaction() {

        $this->txn_successful = false;
        $this->raw_response = null; //reset raw result
        $this->response_arr = array();
    }

    public function reset() {

        $this->txn_successful = null;
        $this->raw_response = null; //reset raw result
        $this->response_arr = array();
        $this->data = array();
        $this->load_config();
    }

    public function createRecurringProfile() {

        try {
            $ssPostDataString = $this->get_data_string();

            return $this->request($ssPostDataString);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sendRequest() {
        try {
            $ssPostDataString = $this->get_data_string();
            //echo $ssPostDataString;exit;

            return $this->request($ssPostDataString);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function request($ssPostDataString) {

        try {

            $this->before_send_transaction();

            $headers[] = "Content-Type: text/namevalue"; //or text/xml if using XMLPay.
            $headers[] = "Content-Length: " . strlen($ssPostDataString);  // Length of data to be passed 
            $headers[] = "X-VPS-Timeout: {$this->vps_timeout}";
            $headers[] = "X-VPS-Request-ID:" . uniqid(rand(), true);
            $headers[] = "X-VPS-VIT-Client-Type: PHP/cURL";          // What you are using

            $headers = array_merge($headers, $this->headers);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->get_gateway_url());
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 1);                // tells curl to include headers in response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 90);              // times out after 90 secs
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        // this line makes it work under https
            curl_setopt($ch, CURLOPT_POSTFIELDS, $ssPostDataString);        //adding POST data
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);       //verifies ssl certificate
            curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);       //forces closure of connection when done
            curl_setopt($ch, CURLOPT_POST, 1);          //data sent as POST

            $i = 0;

            while ($i++ <= $this->gateway_retries) {

                $result = curl_exec($ch);
                $headers = curl_getinfo($ch);

                if (array_key_exists('http_code', $headers) && $headers['http_code'] != self::HTTP_RESPONSE_OK) {
                    sleep($this->gateway_retry_wait);  // Let's wait to see if its a temporary network issue.
                } else {
                    // we got a good response, drop out of loop.
                    break;
                }
            }

            $this->raw_response = $result;

            $result = strstr($result, "RESULT");
            //$result = "RESULT=0&RPREF=RKM500141021&PROFILEID=RT0000000100&P_PNREF1=VWYA06156256&P_TRANSTIME1=21-May-04 04:47PM&P_RESULT1=0&P_TENDER1=C&P_AMT1=1.00&P_TRANSTATE1=8&P_PNREF2=VWYA06156269&P_TRANSTIME2=27-May-04 01:19PM&P_RESULT2=0&P_TENDER2=C&P_AMT2=1.00&P_TRANSTATE2=8&P_PNREF3=VWYA06157650&P_TRANSTIME3=03-Jun-04 04:47PM&P_RESULT3=0&P_TENDER3=C&P_AMT3=1.00&P_TRANSTATE3=8&P_PNREF4=VWYA06157668&P_TRANSTIME4=10-Jun-04 04:47PM&P_RESULT4=0&P_TENDER4=C&P_AMT4=1.00&P_TRANSTATE4=8&P_PNREF5=VWYA06158795&P_TRANSTIME5=17-Jun-04 04:47PM&P_RESULT5=0&P_TENDER5=C&P_AMT5=1.00&P_TRANSTATE5=8&P_PNREF6=VJLA00000060&P_TRANSTIME6=05-Aug-04 05:54PM&P_RESULT6=0&P_TENDER6=C&P_AMT6=1.00&P_TRANSTATE6=1";
            $ret = array();

            while (strlen($result) > 0) {

                $keypos = strpos($result, '=');
                $keyval = substr($result, 0, $keypos);

                // value
                $valuepos = strpos($result, '&') ? strpos($result, '&') : strlen($result);
                $valval = substr($result, $keypos + 1, $valuepos - $keypos - 1);

                if (strstr($keyval, 'P_PNREF')) {
                    $snArrayPos = $keyval[strlen($keyval) - 1];
                }
                // decoding the respose
                if (isset($snArrayPos))
                    $ret['history'][$snArrayPos][$keyval] = $valval;
                else
                    $ret[$keyval] = $valval;

                $result = substr($result, $valuepos + 1, strlen($result));
            }
            $this->amResponse = $ret;
            return $ret;
        } catch (Exception $e) {
            @curl_close($ch);
            throw $e;
        }
    }

    public function apply_associative_array($arr, $options = array()) {

        try {

            $map_array = array();

            if (isset($options[self::KEY_MAP_ARRAY])) {
                $map_array = $options[self::KEY_MAP_ARRAY];
            }

            foreach ($arr as $cur_key => $val) {

                if (isset($map_array[$cur_key])) {
                    $cur_key = $map_array[$cur_key];
                } else {
                    if (isset($options['require_map']) && $options['require_map']) {
                        continue;
                    }
                }

                $this->data[strtoupper($cur_key)] = $val;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

}

class InvalidCredentialsException extends Exception {
    
}

class GatewayException extends Exception {
    
}

class InvalidResponseCodeException extends GatewayException {
    
}

class TransactionDataException extends Exception {
    
}

class AVSException extends TransactionDataException {
    
}

class CVV2Exception extends TransactionDataException {
    
}

class FraudProtectionException extends Exception {
    
}