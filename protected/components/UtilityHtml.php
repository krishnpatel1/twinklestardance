<?php

class UtilityHtml extends CHtml {

    /**
     * Displays a summary of validation errors for one or several models.
     * @param mixed $model the models whose input errors are to be displayed. This can be either
     * a single model or an array of models.
     * @param string $header a piece of HTML code that appears in front of the errors
     * @param string $footer a piece of HTML code that appears at the end of the errors
     * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
     * This parameter has been available since version 1.0.7.
     * A special option named 'firstError' is recognized, which when set true, will
     * make the error summary to show only the first error message of each attribute.
     * If this is not set or is false, all error messages will be displayed.
     * This option has been available since version 1.1.3.
     * @return string the error summary. Empty if no errors are found.
     * @see CModel::getErrors
     * @see errorSummaryCss
     */
    public static function errorSummary($model, $header = null, $footer = null, $htmlOptions = array()) {
        $content = '';
        if (!is_array($model))
            $model = array($model);
        if (isset($htmlOptions['firstError'])) {
            $firstError = $htmlOptions['firstError'];
            unset($htmlOptions['firstError']);
        }
        else
            $firstError = false;
        foreach ($model as $m) {
            foreach ($m->getErrors() as $errors) {
                foreach ($errors as $error) {
                    if ($error != '')
                        $content.="<li>$error</li>\n";
                    if ($firstError)
                        break;
                }
            }
        }
        if ($content !== '') {
            if ($header === null)
                $header = '<p>We\'re sorry, we are not able to process your request because of following errors.<BR> Please rectify them:</p>';
            if (!isset($htmlOptions['class']))
                $htmlOptions['class'] = self::$errorSummaryCss;
            return parent::tag('div', $htmlOptions, $header . "\n<ul>\n$content</ul>" . $footer);
        }
        else
            return '';
    }

    public static function customErrorSummary($array = array(), $header = null, $footer = null, $htmlOptions = array()) {
        $content = '';

        foreach ($array as $errors) {
            if (is_array($errors)) {
                foreach ($errors as $error) {
                    if ($error != '')
                        $content.="<li>$error</li>\n";
                }
            }else {
                if ($errors != '')
                    $content.="<li>$errors</li>\n";
            }
        }
        if ($content !== '') {
            if ($header === null)
                $header = '<p>We\'re sorry, we are not able to process your request because of following errors.<BR> Please rectify them:</p>';
            if (!isset($htmlOptions['class']))
                $htmlOptions['class'] = self::$errorSummaryCss;
            return parent::tag('div', $htmlOptions, $header . "\n<ul>\n$content</ul>" . $footer);
        }
        else
            return '';
    }

    public static function activeTimeField($model, $attribute, $htmlOptions = array()) {
        // SET UP ARRAYS OF OPTIONS FOR DAY, MONTH, YEAR
        $x = 0;

        $hourOptions = array('0' => ' - ');
        while ($x < 24) {
            $hourOptions[$x] = (($x < 10) ? '0' : '') . $x;
            $x++;
        }

        $x = 0;
        $minuteOptions = array('0' => ' - ');
        while ($x < 61) {
            $minuteOptions[$x] = (($x < 10) ? '0' : '') . $x;
            $x++;
        }

        $x = 0;
        $secondOptions = array('0' => ' - ');
        while ($x < 61) {
            $secondOptions[$x] = (($x < 10) ? '0' : '') . $x;
            $x++;
        }

        $x = 1;
        $dayOptions = array('0' => ' - ');
        while ($x < 31) {
            $dayOptions[$x] = $x;
            $x++;
        }

        $monthOptions = array(
            '0' => ' - ',
            '1' => UserModule::t('January'),
            '2' => UserModule::t('February'),
            '3' => UserModule::t('March'),
            '4' => UserModule::t('April'),
            '5' => UserModule::t('May'),
            '6' => UserModule::t('June'),
            '7' => UserModule::t('July'),
            '8' => UserModule::t('August'),
            '9' => UserModule::t('September'),
            '10' => UserModule::t('October'),
            '11' => UserModule::t('November'),
            '12' => UserModule::t('December'),
        );

        $yearOptions = array('0' => ' - ');
        $x = 1901;
        while ($x < 2030) {
            $yearOptions[$x] = $x;
            $x++;
        }


        parent::resolveNameID($model, $attribute, $htmlOptions);

        if (is_array($model->$attribute)) {
            $arr = $model->$attribute;
            $model->$attribute = mktime($arr['hour'], $arr['minute'], $arr['second'], $arr['month'], $arr['day'], $arr['year']);
        }

        if ($model->$attribute != '0' && isset($model->$attribute)) {
            //echo "<pre>"; print_r(date('Y-m-d',$model->$attribute)); die();
            // intval removes leading zero
            $day = intval(date('j', $model->$attribute));
            $month = intval(date('m', $model->$attribute));
            $year = intval(date('Y', $model->$attribute));

            $hour = intval(date('H', $model->$attribute));
            $minute = intval(date('i', $model->$attribute));
            $second = intval(date('s', $model->$attribute));
        } else {
            // DEFAULT TO 0 IF THERE IS NO DATE SET
            $day = intval(date('j', time()));
            $month = intval(date('m', time()));
            $year = intval(date('Y', time()));

            $hour = intval(date('H', time()));
            $minute = intval(date('i', time()));
            $second = intval(date('s', time()));
            /*
              $day = 0;
              $month = 0;
              $year = 0;
              $hour = 0;
              $minute = 0;
              $second = 0;// */
        }


        $return = parent::dropDownList($htmlOptions['name'] . '[day]', $day, $dayOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[month]', $month, $monthOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[year]', $year, $yearOptions);
        $return .= ' Time:';
        $return .= parent::dropDownList($htmlOptions['name'] . '[hour]', $hour, $hourOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[minute]', $minute, $minuteOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[second]', $second, $secondOptions);
        return $return;
    }

    public static function activeDateField($model, $attribute, $htmlOptions = array()) {
        // SET UP ARRAYS OF OPTIONS FOR DAY, MONTH, YEAR
        $x = 1;
        $dayOptions = array('00' => ' - ');
        while ($x < 31) {
            $dayOptions[(($x < 10) ? '0' : '') . $x] = $x;
            $x++;
        }

        $monthOptions = array(
            '00' => ' - ',
            '01' => UserModule::t('January'),
            '02' => UserModule::t('February'),
            '03' => UserModule::t('March'),
            '04' => UserModule::t('April'),
            '05' => UserModule::t('May'),
            '06' => UserModule::t('June'),
            '07' => UserModule::t('July'),
            '08' => UserModule::t('August'),
            '09' => UserModule::t('September'),
            '10' => UserModule::t('October'),
            '11' => UserModule::t('November'),
            '12' => UserModule::t('December'),
        );

        $yearOptions = array('0000' => ' - ');
        $x = 1901;
        while ($x < 2030) {
            $yearOptions[$x] = $x;
            $x++;
        }


        parent::resolveNameID($model, $attribute, $htmlOptions);

        if ($model->$attribute != '0000-00-00' && isset($model->$attribute)) {
            if (is_array($model->$attribute)) {
                $new = $model->$attribute;

                $day = $new['day'];
                $month = $new['month'];
                $year = $new['year'];
            } else {
                $new = explode('-', $model->$attribute);
                // intval removes leading zero
                $day = $new[2];
                $month = $new[1];
                $year = $new[0];
            }
        } else {
            // DEFAULT TO 0 IF THERE IS NO DATE SET
            $day = '00';
            $month = '00';
            $year = '0000';
        }

        //echo "<pre>"; print_r(array($day,$month,$year)); die();

        $return = parent::dropDownList($htmlOptions['name'] . '[day]', $day, $dayOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[month]', $month, $monthOptions);
        $return .= parent::dropDownList($htmlOptions['name'] . '[year]', $year, $yearOptions);
        return $return;
    }

    public static function getCardTypes($htmlOptions = array(), $selected = '') {
        $collection = array(
            'visa' => 'Visa',
            'MasterCard' => 'Master card',
            'AmericanExpress' => 'American Express',
        );
        $htmlOptions['empty'] = 'Card Type';
        return $return = parent::dropDownList($htmlOptions['name'], $selected, $collection);
    }

    public static function getMonthField($htmlOptions = array(), $month = '00') {
        // SET UP ARRAYS OF OPTIONS FOR DAY, MONTH, YEAR
        $monthOptions = array(
            '01' => Yii::t('Shop', 'January'),
            '02' => Yii::t('Shop', 'February'),
            '03' => Yii::t('Shop', 'March'),
            '04' => Yii::t('Shop', 'April'),
            '05' => Yii::t('Shop', 'May'),
            '06' => Yii::t('Shop', 'June'),
            '07' => Yii::t('Shop', 'July'),
            '08' => Yii::t('Shop', 'August'),
            '09' => Yii::t('Shop', 'September'),
            '10' => Yii::t('Shop', 'October'),
            '11' => Yii::t('Shop', 'November'),
            '12' => Yii::t('Shop', 'December'),
        );
        $htmlOptions['empty'] = 'Month';
        if (!isset($htmlOptions['name'])) {
            $htmlOptions['name'] = 'month';
        }
        $return = parent::dropDownList($htmlOptions['name'], $month, $monthOptions, $htmlOptions);
        return $return;
    }

    public static function getYearField($minY, $maxY, $htmlOptions = array(), $year = '') {
        //$yearOptions = array('0'=>' Year ');
        $x = $minY;
        while ($x < $maxY) {
            $yearOptions[$x] = $x;
            $x++;
        }
        $htmlOptions['empty'] = 'Year';

        if (!isset($htmlOptions['name'])) {
            $htmlOptions['name'] = 'year';
        }
        $return = parent::dropDownList($htmlOptions['name'], $year, $yearOptions, $htmlOptions);
        return $return;
    }

    public static function getAsapField($htmlOptions = array(), $asap = 'ASAP') {
        $hList = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
        $mList = array("00", 15, 30, 45);

        $currentH = date('H');
        $currentM = date('i');

        $timeOptions = array();
        $flag = false;
        foreach ($hList as $h) {
            foreach ($mList as $m) {
                if ($h % 12 == 0)
                    $timeOptions[$h . $m] = (((float) $h >= 12) ? ('12:' . $m . 'PM') : ("12:" . $m . 'AM'));
                else
                    $timeOptions[$h . $m] = (((float) $h >= 12) ? (((float) $h - 12) . ':' . $m . 'PM') : ($h . ":" . $m . 'AM'));
                if (((float) $currentH <= (float) $h) && (round($currentM / 15) == ($m / 15)) && !$flag) {
                    $timeOptions['ASAP'] = 'ASAP';
                    //$asap = $currentH.$mList[round($currentM / 15)];
                    $flag = true;
                }
            }
        }
        if (!isset($htmlOptions['name'])) {
            $htmlOptions['name'] = 'asap';
        }

        $return = parent::dropDownList($htmlOptions['name'], $asap, $timeOptions, $htmlOptions);
        return $return;
    }

    public static function getDeliveryTimeDropdown($htmlOptions = array(), $select = '') {
        $timestamp = mktime();
        $day = date('Y/m/d', $timestamp);
        $dayStr = 'Today';

        $day1 = date('Y/m/d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
        $day1Str = 'Tomorrow'; //date('l', mktime(0,0,0,date("m"),date("d")+1,date("Y")));

        $day2 = date('Y/m/d', mktime(0, 0, 0, date("m"), date("d") + 2, date("Y")));
        $day2Str = date('l', mktime(0, 0, 0, date("m"), date("d") + 2, date("Y")));

        $day3 = date('Y/m/d', mktime(0, 0, 0, date("m"), date("d") + 3, date("Y")));
        $day3Str = date('l', mktime(0, 0, 0, date("m"), date("d") + 3, date("Y")));

        $dayOptions[$day] = $dayStr;
        $dayOptions[$day1] = $day1Str;
        $dayOptions[$day2] = $day2Str;
        $dayOptions[$day3] = $day3Str;

        $return = parent::dropDownList($htmlOptions['name'], $select = 0, $dayOptions, $htmlOptions);
        return $return;
    }

    public static function getTipDropdown($htmlOptions = array(), $select = 0) {
        if (!isset($htmlOptions['name'])) {
            $htmlOptions['name'] = 'tip';
        }
        $estimatedTip = Cart::model()->getEstimatedTipPrice();
        $totalPrice = Cart::model()->getTotalPrice();

        $freq = 0.25;
        $dataOptions = array();
        $i = 0;
        $flag = 0;
        while ($i <= $totalPrice) {
            $dataOptions['' . $i . ''] = '+ ' . Cart::model()->priceFormat($i, 1);
            if ($select == '') {
                if ($i >= $estimatedTip && $flag == 0) {
                    if ($select == '') {
                        $flag = 1;
                        //$rem =  round(($estimatedTip - floor($estimatedTip)) / ($freq));
                        //$select=floor($estimatedTip) + ($rem * $freq);
                        $select = 0;
                    }
                }
            }
            $i+=0.25;
        }
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getStateDropdown($htmlOptions = array(), $country = 'US', $select = '') {
        $stateData = StateMaster::model()->findAll("country_code = 'US'");
        $dataOptions = array('' => 'Select State');
        foreach ($stateData as $state) {
            $dataOptions[$state->state_code] = $state->state_code . ' - ' . $state->state;
        }
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getStateData($country = 'AU') {
        $stateData = StateMaster::model()->findAll("country_code = 'AU'");
        $dataOptions = array('' => 'Select State');
        foreach ($stateData as $state) {
            $dataOptions[$state->state_code] = $state->state;
        }
        return $dataOptions;
    }

    public static function formatStrToTime($time) {
        $str = $time;
        if (is_numeric($time)) {
            $array = str_split($time, 2);
            if ($array[0] >= 12)
                $str = ' PM'; else
                $str = ' AM';
            if ($array[0] == 0)
                $array[0] = 12;
            $str = implode(':', $array) . $str;
        }
        return $str;
    }

    public static function getSortByDropdown($htmlOptions = array(), $select = '') {
        $dataOptions = array(
            'OPEN_NOW' => 'OPEN NOW',
            //'OPEN_24_HOURS' => 'OPEN 24 HOURS',
            //'DISTANCE' => 'DISTANCE',
            'TOP_RATED' => 'TOP RATED',
                //'FREE_DELIVERY' => 'FREE DELIVERY'
        );
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getSpecialOfferDropdown($htmlOptions = array(), $select = '') {
        $dataOptions = array(
            'DISCOUNTS' => 'DISCOUNTS',
            'SPECIAL_OFFRES' => 'SPECIAL OFFRES',
            'STUDENT_DISCOUNTS' => 'STUDENT DISCOUNTS');
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getIdetificationQuestionDropDown($htmlOptions = array(), $select = '') {
        $dataOptions = array(
            '1' => 'What is your mother name?',
            '2' => 'What is your junior school name?',
            '3' => 'What is your favorite animal?');
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getHearAboutUsDropDown($htmlOptions = array(), $select = '') {
        $dataOptions = array(
            'search_engine' => 'Search engine',
            'blog' => 'Blog',
            'banner' => 'Banner',
            'linkedin_facebook' => 'Linkedin/facebook',
            'another_site' => 'Another site',
            'magazine' => 'Magazine/newspaper',
            'email' => 'Email',
            'word_of_mouth' => 'Word of mouth',
            'recruiter' => 'Recruiter',
            'career_consultant' => 'Career consultant',
            'other' => 'Other');
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getActionDropDown($htmlOptions = array(), $select = '') {
        $dataOptions = array(
            'applied' => 'Applied',
            'not_applied' => 'Not Applied');
        $return = parent::dropDownList($htmlOptions['name'], $select, $dataOptions, $htmlOptions);
        return $return;
    }

    public static function getDeliveryTypeControl($htmlOptions = array(), $type = 'radio') {
        $url = Yii::app()->request->baseUrl;
        $select = Cart::model()->getCartDataByKey('delivery_type');
        $data = array('Delivery' => '<span class="d-info" style="margin-left: 5px">Delivery</span>',
            'Pickup' => '<span class="d-info" style="margin-left: 5px">Pickup</span>');

        if ($type == 'radio') {
            $htmlOptions['onClick'] = "javascript:updateDeliveryType('$url/cart/UpdateCart', this);";
            return parent::radioButtonList('delivery_type', $select, $data, $htmlOptions);
        } elseif ($type == 'message') {
            if (Cart::model()->getDeliveryType() == 'Pickup') {
                return 'This order will be pickup.';
            } else {
                return 'This order will be delivered.';
            }
        } else if ($type == 'popup_link') {
            return parent::link('Click Here', '#', $htmlOptions);
        } else {
            if (Cart::model()->getDeliveryType() == 'Pickup') {
                $str = 'Change it to Delivery >>';
            } else {
                $str = 'Change it to Pickup >>';
            }
            return "<input type=\"hidden\" name=\"delivery_type\" id=\"delivery_type\" value=\"" . Cart::model()->getDeliveryType() . "\" />
			<!-- <a class=\"why\" id=\"change_delivery_type\" href=\"javascript:return false;\" 
				 style=\"cursor: pointer\" onclick=\"javascript:updateDeliveryType('$url/cart/UpdateCart')\">" . $str . "</a> -->
			<span class=\"why_span\" id=\"change_delivery_type\" onclick=\"javascript:updateDeliveryType('$url/cart/UpdateCart', this)\">" . $str . "</span>";
        }
    }

    public static function getStatusArray($type = 'general') {
        switch ($type) {
            case 'general':
                return array(1 => 'Active', 0 => 'InActive');
                break;
            default:
                return array(1 => 'Active', 0 => 'InActive');
                break;
        }
    }

    public static function getStatusImage($status) {
        if ($status == 1 || strtolower($status) == 'yes') {
            return Yii::app()->request->baseUrl . '/images/checked.png';
        } else {
            return Yii::app()->request->baseUrl . '/images/unchecked.png';
        }
    }

    public static function getImageDisplay($image) {
        if ($image != '' && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/packagesubscription/thumb/' . $image)) {
            return Yii::app()->request->baseUrl . '/uploads/packagesubscription/thumb/' . $image;
        } elseif(strstr($image,'http')){
            return $image;
        } else {
            return Yii::app()->request->baseUrl . '/uploads/packagesubscription/no-image.jpg';
        }
    }
    
    public static function getAbsoluteImageUrl($image){
        if ($image != '' && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/packagesubscription/thumb/' . $image)) {
            return Yii::app()->createAbsoluteUrl('/uploads/packagesubscription/thumb/' . $image);
        } elseif(strstr($image,'http')){
            return $image;
        } else {
            return Yii::app()->createAbsoluteUrl('/uploads/packagesubscription/no-image.jpg');
        }
    }

    public static function getImageStudio($image) {
        if ($image != '' && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/users/thumb/' . $image)) {
            return Yii::app()->request->baseUrl . '/uploads/users/thumb/' . $image;
        } else {
            return Yii::app()->request->baseUrl . '/images/no-img.jpg';
        }
    }

    public static function getClassImageDisplay($snIdUser,$ssImage) {
        if ($ssImage != '' && file_exists(YiiBase::getPathOfAlias('webroot') . "/uploads/users/classes/$snIdUser/thumb/$ssImage")) {
            return Yii::app()->request->baseUrl . "/uploads/users/classes/$snIdUser/thumb/$ssImage";
        } elseif(strstr($ssImage,'http')){
             return $ssImage;
        }else {
            return Yii::app()->request->baseUrl . '/images/no-img.jpg';
        }
    }
    public static function getVideoImage($ssImage) {
        if ($ssImage != "") {
            return $ssImage;
        } else {
            return Yii::app()->request->baseUrl . '/images/no-img.jpg';
        }
    }
    public static function getDurationText($status) {
        switch ($status) {
            case 1:
                return "Monthly";
                break;
            case 2:
                return "Yearly";
                break;
            case 3:
                return "Both";
                break;
            default:
                return "None";
                break;
        }
    }

    public static function getFileUnlink($file_path) {
        if (file_exists($file_path)) {
            unlink($file_path);
        } else {
            return false;
        }
    }

    public static function getStatusImageIcon($status, $htmloptions = '') {
        return CHTML::image(self::getStatusImage($status), $htmloptions);
    }

    /**
     * Enter description here ...
     * UtilityHtml::getDateTimeFormat();
     * @return string
     */
    public static function getDateTimeFormat() {
        return SystemConfig::getValue('date_long_format');
        //return 'yy-mm-dd';
    }

    public static function priceFormat($price, $symbol = false, $template = '{currancy}{price}') {
        $price = sprintf('%.2f', $price);
        if (Yii::app()->language == 'de') {
            $price = str_replace('.', ',', $price);
            $template = str_replace('{currancy}', self::getCurrency('symbol'), $template);
            $template = str_replace('{price}', $price, $template);
            return $template;
        }

        if ($symbol) {
            $template = str_replace('{currancy}', self::getCurrency('symbol'), $template);
            $template = str_replace('{price}', $price, $template);
            return $template;
        }
        return $price;
    }

    public static function getCurrency($type = 'code') {
        if ($type == 'code') {
            return SystemConfig::getValue('default_currency');
        } else {
            return SystemConfig::getValue('default_currency_symbol');
        }
    }

    /**
     * First arguement dataset
     * next arguement is sequence of n number variables
     */
    public static function getDataByKey() {
        $array = func_get_args(); //explode('.', $path);
        if (!empty($array)) {
            $data = array_shift($array);
            $str = '';
            $val = $data;
            foreach ($array as $data) {
                $str .= '[\'' . $data . '\']';
                if (!isset($val[$data]))
                    return false;
                $val = $val[$data];
            }
            return $val;
        }else {
            return false;
        }
    }

    public static function getAjaxAddUpdateGrid($formId, $gridId, $errId, $modelName, $ajaxUrl, $options = array()) {
        $strJs = '<script>
		$(\'#upload_press\').click( function() {
		$.ajax({
		    type: "POST",
		    dataType: "json",
		    data: $("#' . $formId . '").serialize(),
		    url: \'' . $ajaxUrl . '\', 
		    success: function(msg) {
		    	
			    if(msg.act==\'add\') {
				    if(msg.success==1) {
					    $(\'#' . $errId . '\').html(\'Added successfully!\');
					    $("#' . $formId . '")[0].reset();
					    $(\'#' . $modelName . '_id\').val(\'\');
				    }else {
				    	$(\'#' . $errId . '\').html(\'Fail to Add!\');
				    }
			    }
			    if(msg.act==\'update\') {
			    	if(msg.success==1) {
			    		$(\'#' . $errId . '\').html(\'Updated successfully!\');
					    $("#' . $formId . '")[0].reset();
					    $(\'#' . $modelName . '_id\').val(\'\');
				    }else {
				    	 $(\'#' . $errId . '\').html(\'Fail to Update!\');
				    }
			    }
			    $(\'#' . $gridId . '\').yiiGridView.update(\'' . $gridId . '\');
	     	}
	     });
	});
	</script>';
        return $strJs;
    }

    public static function getGridButtonAjax($formId, $gridId, $modelName, $options = array()) {
        $updateArray = array(
            'update' => array(
                'click' => 'js:function(){
	         		$.ajax({
					    type: "GET",
					    dataType: "json",
					    data: $("#' . $formId . '").serialize(),
					    url: $(this).attr(\'href\')+\'/ajax/' . $gridId . '\', 
					    success: function(jsondata) {
						    $.each(jsondata.attributes, function(key, value) {
							   // alert(key + value); 
							    $(\'#' . $modelName . '_\'+key).val(value);
							});
				     	}
				     });
	         		return false;
	         	}'
                ));
        return $updateArray;
    }

    public static function getSQLDateTimeFormat($dateStr, $formatTo = '', $formatFrom = '') {
        if ($formatTo == '') {
            $formatTo = SystemConfig::getValue('php_datetime_format_mysql');
        }
        if ($formatFrom == '') {
            $formatFrom = SystemConfig::getValue('datetime_format');
        }
        if ($dateStr == '' || $dateStr == '0000-00-00 00:00:00')
            return false;
        return date($formatTo, CDateTimeParser::parse($dateStr, $formatFrom));
    }

    /*  Returns the first $wordsreturned out of $string.  If string
      contains fewer words than $wordsreturned, the entire string
      is returned.
     */

    public static function shortString($string, $wordsreturned) {
        $retval = $string;      //  Just in case of a problem
        $array = explode(" ", $string);
        /*  Already short enough, return the whole thing */
        if (count($array) <= $wordsreturned) {
            $retval = $string;
        } else { /*  Need to chop of some words */
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array) . " ...";
        }
        return $retval;
    }

    /*  Returns the first $wordsreturned out of $string.  If string
      contains fewer words than $wordsreturned, the entire string
      is returned.
     */

    public static function shortStringByLength($string, $length = 50) {
        $retval = $string;      //  Just in case of a problem
        $array = explode(" ", $string);
        /*  Already short enough, return the whole thing */
        if (strlen($string) < $length) {
            $retval = $string;
        } else { /*  Need to chop of some words */
            $retval = substr($string, 0, $length) . " ...";
        }
        return $retval;
    }

    public static function getMessageCSV2Array($key = '', $seperator = ',') {
        $file = Yii::getPathOfAlias('webroot') . '/protected/messages/' . Yii::app()->language . '/' . $key . '.csv';
        $row = 0;
        $arr = array();
        if (file_exists($file)) {

            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, $seperator)) !== FALSE) {
                    $num = count($data);
                    $row++;
                    if (isset($data[0]) && isset($data[1])) {
                        $arr[$data[0]] = $data[1];
                    }
                }
                fclose($handle);
            }
        }

        return $arr;
    }

    public static function getUrlKey($text = '') {
        //$text = 'testa &@#$234><><>ASD#$@$242_^&*(^*&(';
        return $text = trim(strtolower(str_replace('__', '_', preg_replace('/[^a-zA-Z0-9]/s', '_', $text))));
    }

}

/*
 $('#upload_press').click( function() {
 $.ajax({
 type: "POST",
 dataType: "json",
 data: $("#<?php echo $form->getId()?>").serialize(),
 url: '<?php echo Controller::createUrl('/customer/venue/manager/press/ajax/1') ?>',
 success: function(msg) {

 if(msg.act=='add') {
 if(msg.success==1) {
 $('#err_info_msg').html('Added successfully!');
 $("#<?php echo $form->getId()?>")[0].reset();
 $('#<?php echo $modelName?>_id').val('');
 }else {
 $('#err_info_msg').html('Fail to Add!');
 }
 }
 if(msg.act=='update') {
 if(msg.success==1) {
 $('#err_info_msg').html('Updated successfully!');
 $("#<?php echo $form->getId()?>")[0].reset();
 $('#<?php echo $modelName?>_id').val('');
 }else {
 $('#err_info_msg').html('Fail to Update!');
 }
 }
 $('#press-grid').yiiGridView.update('press-grid');
 }
 });
 });
 */