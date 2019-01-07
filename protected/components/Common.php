<?php

/**
 * This is the Common model class for declared general functions/methods.
 */
class Common {

    /**
     * function: objectToArray()
     * For Convert Object To Array 
     * @param $object
     * @return array $amConverted
     */
    public static function objectToArray($object) {
        $amConverted = array();
        foreach ($object as $member => $data) {
            $amConverted[$member] = (array) $data;
        }
        return $amConverted;
    }

    /**
     * function: base64UrlDecode()
     * For decode data into base64 method
     * @param $input
     * @return string decoded data
     */
    public static function base64UrlDecode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * function: createDirectory()
     * @param string $ssName 
     * @param string $ssDirectoryPath
     * For create a directory
     */
    public static function createDirectory($ssName, $ssDirectoryPath) {
        //$ssDirectoryPath = Yii::getPathOfAlias('webroot') . '/uploads/packagesubscription/documents/';
        $ssDirectoryName = $ssDirectoryPath . $ssName;
        if (!file_exists($ssDirectoryName) && !is_dir($ssDirectoryName)) {
            mkdir($ssDirectoryName, 0777);
        }
    }

    /**
     * function: removePackageSubscriptionImage()        
     * @param string $ssName 
     * For remove image.
     */
    public static function removePackageSubscriptionImage($ssName) {
        if (!empty($ssName)) {
            $ssDirectoryPath = Yii::getPathOfAlias('webroot');
            $amImageInfo = pathinfo($ssName);
            $ssImageName = $ssDirectoryPath . '/uploads/packagesubscription/' . $amImageInfo['basename'];
            $ssThumbPhotoPath = $ssDirectoryPath . '/uploads/packagesubscription/thumb/' . $amImageInfo['basename'];
            if ($ssName != "" && file_exists($ssImageName)) {
                unlink($ssImageName);
            }
            if ($ssName != "" && file_exists($ssThumbPhotoPath)) {
                unlink($ssThumbPhotoPath);
            }
        }
    }

    /**
     * function: removePackageSubscriptionDocs()                
     * For remove document.
     * @param int $snPackageSubId
     * @param string $ssDocumentName
     * 
     */
    public static function removePackageSubscriptionDocs($snPackageSubId, $ssDocumentName) {
        if (!empty($ssDocumentName)) {
            $ssDirectoryPath = Yii::getPathOfAlias('webroot');
            $amDocInfo = pathinfo($ssDocumentName);
            $ssDocName = $ssDirectoryPath . '/uploads/packagesubscription/documents/' . $snPackageSubId . '/' . $amDocInfo['basename'];
            if ($ssDocumentName != "" && file_exists($ssDocName)) {
                unlink($ssDocName);
            }
        }
    }

    /**
     * function: removeSubscriptionDocs()                
     * For remove document.
     * @param string $ssDocumentName
     * 
     */
    public static function removeSubscriptionDocs($ssDocumentName) {
        if (!empty($ssDocumentName)) {
            $ssDirectoryPath = Yii::getPathOfAlias('webroot');
            $amDocInfo = pathinfo($ssDocumentName);
            $ssDocName = $ssDirectoryPath . '/uploads/packagesubscription/documents/' . $amDocInfo['basename'];
            if ($ssDocumentName != "" && file_exists($ssDocName)) {
                unlink($ssDocName);
            }
        }
    }

    /**
     * function: removePhoto()
     * @param int $snUserId 
     * @param string $ssName 
     * For remove image.
     */
    public static function removePhoto($snUserId, $ssName) {
        $ssDirectoryPath = Yii::app()->params['uploadDirBasePath'];
        $amImageInfo = pathinfo($ssName);
        $ssPhotoPath = $ssDirectoryPath . $snUserId . '/photos/' . $amImageInfo['basename'];
        $ssThumbPhotoPath = $ssDirectoryPath . $snUserId . '/photos/thumb/' . $amImageInfo['basename'];
        if ($ssName != "" && file_exists($ssPhotoPath)) {
            unlink($ssPhotoPath);
        }
        if ($ssName != "" && file_exists($ssThumbPhotoPath)) {
            unlink($ssThumbPhotoPath);
        }
    }

    /**
     * function commonUpdateField
     * for Update a single field for any table.
     *
     * @param $ssTableName Table Name
     * @param $ssFieldName Field Name
     * @param $smFieldValue Field Value
     * @param $ssCompareField Comapare Field Name
     * @param $smCompareValue Compare Filed Value
     *
     * return boolean
     */
    public static function commonUpdateField($ssTableName, $ssFieldName, $smFieldValue, $ssCompareField, $smCompareValue) {
        $bUpdated = Yii::app()->db->createCommand()
                ->update($ssTableName, array($ssFieldName => $smFieldValue,
                ), $ssCompareField . '=:compare_value', array(':compare_value' => $smCompareValue));

        return $bUpdated;
    }

    /**
     * function commonDeleteRecord
     * for delete the records from table of matched criteria.
     *
     * @param $ssTableName Table Name
     * @param $ssCompareField Comapare Field Name
     * @param $smCompareValue Compare Filed Value
     *
     * return boolean
     */
    public static function commonDeleteRecord($ssTableName, $ssCompareField, $smCompareValue) {
        Yii::app()->db->createCommand()
                ->delete($ssTableName, $ssCompareField . '=:compare_value', array(':compare_value' => $smCompareValue));

        return true;
    }

    /**
     * function: generateToken()
     * For generate random token
     * @param integer $snLength 
     * @return array $smCode
     */
    public static function generateToken($snLength) {
        $smCode = "";
        $smData = "AbcDE123IJKLMN67QRSTUVWXYZaBCdefghijklmn123opq45rs67tuv89wxyz0FGH45OP89";
        for ($snI = 0; $snI < $snLength; $snI++)
            $smCode .= substr($smData, (rand() % (strlen($smData))), 1);

        return strtolower($smCode);
    }

    /**
     * function: createImageURL()
     * For generate random number
     * @param integer $snLength 
     * @return array $smCode
     */
    public static function createImageURL($ssImageName) {
        $ssProfileImageURL = Yii::app()->params['image_upload_url'] . Yii::app()->request->baseUrl . '/uploads/' . $ssImageName;
        return $ssProfileImageURL;
    }

    /**
     * Function replaceMailContent  Replace  Dynamic Mail Content
     * @param $omContent = object of old content
     * @param $asDynamicContent = array of dynamic content
     * return $ssBodyContent = string of replaced old content 
     */
    static public function replaceMailContent($ssBodyContent, $asDynamicContent) {
        if (trim($ssBodyContent) != '') {
            foreach ($asDynamicContent as $key => $value)
                $ssBodyContent = str_replace($key, $value, $ssBodyContent);

            return $ssBodyContent;
        }
        return false;
    }

    /**
     * function: sendMail()
     * For send apple push notification.
     * @param string $ssToEmail
     * @param string $asFromEmail 
     * @param string $ssSubject
     * @param string $ssBody
     */
    public static function sendMail($ssToEmail, $asFromEmail, $ssSubject, $ssBody, $ssCC = "") {
        $omMessage = new YiiMailMessage;

        $omMessage->setTo($ssToEmail);
        $omMessage->setFrom($asFromEmail);
        $omMessage->setSubject($ssSubject);
        $omMessage->setBody($ssBody, 'text/html', 'utf-8');

        if ($ssCC != "") {
            $omMessage->addCC($ssCC);
        }

        $bMailStatus = Yii::app()->mail->send($omMessage);

        return $bMailStatus;
    }

    /**
     * function: closeColorBox()
     * For close color box popup window.
     * @param string $ssCloseScript
     */
    public static function closeColorBox() {
        $ssCloseScript = "<script src='" . Yii::app()->request->baseUrl . "/js/jquery.js'></script>";
        $ssCloseScript .= "<script src='" . Yii::app()->request->baseUrl . "/js/colorbox/jquery.colorbox.js'></script>";
        $ssCloseScript .= "<script type='text/javascript'>parent.jQuery.colorbox.close(); parent.window.location.reload(true);</script>";
        return $ssCloseScript;
    }

    /**
     * function: removeOldImage()        
     * @param string $ssName 
     * @param string $ssOrigPath 
     * @param string $ssThumbPath 
     * For remove image.
     */
    public static function removeOldImage($ssName, $ssOrigPath, $ssThumbPath) {

        $amImageInfo = pathinfo($ssName);
        $ssImageName = $ssOrigPath . $amImageInfo['basename'];
        $ssThumbPhotoPath = $ssThumbPath . $amImageInfo['basename'];

        if ($ssName != "" && file_exists($ssImageName))
            unlink($ssImageName);
        if ($ssName != "" && file_exists($ssThumbPhotoPath))
            unlink($ssThumbPhotoPath);
    }

    /**
     * function: setSeoData()        
     * @param string $curr 
     * @param string $page 
     * @return none.
     */
    public static function setSeoData($curr, $page) {
        $seoData = Common::getSeoData($page);
        $curr->pageTitle = $seoData[0] ? $seoData[0] : '';
        Yii::app()->clientScript->registerMetaTag($seoData[1] ? $seoData[1] : '', 'Title');
        Yii::app()->clientScript->registerMetaTag($seoData[2] ? $seoData[2] : '', 'Description');
        Yii::app()->clientScript->registerMetaTag($seoData[3] ? $seoData[3] : '', 'Keywords');
    }

    /**
     * function: getSeoData()        
     * @param string $page 
     * @return array.
     */
    public static function getSeoData($page) {
        switch ($page) {
            case 'subscriptions': return array('Subscription', 'Subscription Title', 'Subscription Description', 'Subscription Keywords');
            default:return array('Twinkle Star Dance', 'Twinkle Star Dance', 'Twinkle Star Dance', 'Twinkle Star Dance');
        }
    }

    /**
     * function: removeDirectory()        
     * @param string $ssDireName 
     * @param string $ssPath 
     * @return boolean.
     */
    public static function removeDirectory($ssDireName, $ssPath) {
        $bRemoved = false;
        if (is_dir($ssPath . $ssDireName)) {
            exec("rm -fR " . $ssPath . $ssDireName);
            $bRemoved = true;
        }
        return $bRemoved;
    }

    /**
     * function: priceFormat()        
     * @param float $snAmount 
     * @return alphanumeric
     */
    public static function priceFormat($snAmount) {
        $snAmount = strstr($snAmount, '.') ? $snAmount : $snAmount . '.00';
        return Yii::app()->params['price_symbol'] . $snAmount;
    }

    /**
     * function: getUserTypeAsPerValue()        
     * @return string $ssUserType
     */
    public static function getUserTypeAsPerValue($snUserTypeID, $bIsRole = false) {

        switch ($snUserTypeID) {
            case '1':
                return ($bIsRole) ? 'admin' : 'Administrator';
                //return 'Administrator';
                break;
            case '2':
                return ($bIsRole) ? 'studio' : 'Studios';
                //return 'Studios';
                break;
            case '3':
                return ($bIsRole) ? 'dancer' : 'Dancers';
                //return 'Dancers';
                break;
            case '4':
                return ($bIsRole) ? 'instructor' : 'Instructors';
                //return 'Instructors';
                break;
            case '5':
                return ($bIsRole) ? '' : 'Students';
                //return 'Students';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * function: getDashboadMenusAsPerRole()        
     * @return array $amDashboardMenu
     */
    public static function getDashboadMenusAsPerRole() {

        $amDashboardMenu = array();
        switch (Yii::app()->admin->name) {
            case 'admin':
                $amDashboardMenu = array(
                    '1' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/video.png',
                        'name' => "<font>Videos</font>",
                        'url' => array('videos/index'),
                        'class' => 'block'
                    ),
                    '2' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/subscriptions.png',
                        'name' => "<font>Subscriptions</font>",
                        'url' => Yii::app()->createUrl("admin/packageSubscription/index", array("type" => "Subscription")),
                        'class' => 'block'
                    ),
                    '3' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Packages</font>",
                        'url' => Yii::app()->createUrl("admin/packageSubscription/index", array("type" => "Package")),
                        'class' => 'block last'
                    ),
                    '4' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/orders.png',
                        'name' => "<font>Orders</font>",
                        'url' => array('orders/admin'),
                        'class' => 'block'
                    ),
                    '5' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/studios.png',
                        'name' => "<font>Studios</font>",
                        'url' => array('users/index'),
                        'class' => 'block'
                    ),
                    '6' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/settings.png',
                        'name' => "<font>Settings</font>",
                        'url' => array('users/settings'),
                        'class' => 'block last'
                    ),
                    '7' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/cms_icon.png',
                        'name' => "<font>CMS pages</font>",
                        'url' => array('pages/admin'),
                        'class' => 'block'
                    ),
                    '8' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/email_te.png',
                        'name' => "<font>Email Templates</font>",
                        'url' => array('emailformat/admin'),
                        'class' => 'block'
                    ),
                    '9' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Documents</font>",
                        'url' => array('packageSubscriptionDocuments/admin'),
                        'class' => 'block last'
                    ),
                    '10' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/email_te.png',
                        'name' => "<font>Send Newsletters</font>",
                        'url' => array('index/sendNewsletter'),
                        'class' => 'block'
                    ),
                    '11' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/settings.png',
                        'name' => "<font>PayPal / Facebook Configuration</font>",
                        'url' => array('configurations/update','id' => base64_encode(1)),
                        'class' => 'block'
                    ),
                    '12' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Genres</font>",
                        'url' => array('genre/admin'),
                        'class' => 'block last'
                    ),
                    '13' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Categories</font>",
                        'url' => array('category/admin'),
                        'class' => 'block'
                    ),
                    '14' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Age Ranges</font>",
                        'url' => array('agerange/admin'),
                        'class' => 'block'
                    ),
                    '15' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/cms_icon.png',
                        'name' => "<font>Home page gallery</font>",
                        'url' => array('image/admin'),
                        'class' => 'block last'
                    ),
                    '16' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/cms_icon.png',
                        'name' => "<font>Testimonials</font>",
                        'url' => array('testimonial/admin'),
                        'class' => 'block'
                    ),
                );
                return $amDashboardMenu;
                break;
            case 'studio':
                $amDashboardMenu = array(
                    '1' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/video.png',
                        'name' => "<font>Videos</font>",
                        'url' => array('videos/index'),
                        'class' => 'block'
                    ),
                    '2' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/instructors.png',
                        'name' => "<font>Instructors</font>",
                        'url' => Yii::app()->createUrl("admin/users/listInstructorsDancers", array('user_type' => Yii::app()->params['user_type']['instructor'])),
                        'class' => 'block'
                    ),
                    '3' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/dancers.png',
                        'name' => "<font>Dancers</font>",
                        'url' => Yii::app()->createUrl("admin/users/listInstructorsDancers", array('user_type' => Yii::app()->params['user_type']['dancer'])),
                        'class' => 'block last'
                    ),
                    '4' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/classes.png',
                        'name' => "<font>Classes</font>",
                        'url' => array('classes/index'),
                        'class' => 'block'
                    ),
                    '5' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/settings.png',
                        'name' => "<font>Settings</font>",
                        'url' => array('users/settings'),
                        'class' => 'block'
                    ),
                    '6' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>My Assigned Documents</font>",
                        'url' => array('packageSubscriptionDocuments/admin'),
                        'class' => 'block last'
                    ),
                    '7' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Documents</font>",
                        'url' => array('packageSubscriptionAllDocuments/admin'),
                        'class' => 'block'
                    ),
                    '9' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>My Accounts</font>",
                        'url' => array('users/myAccounts'),
                        'class' => 'block'
                    ),
                    '10' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/classes.png',
                        'name' => "<font>Classes Report</font>",
                        'url' => array('classes/getClassesReport'),
                        'class' => 'block last'
                    ),
                );
                return $amDashboardMenu;
                break;
            case 'instructor':
                $amDashboardMenu = array(
                    '1' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/video.png',
                        'name' => "<font>Classes</font>",
                        'url' => array('classes/index'),
                        'class' => 'block'
                    ),
                    '2' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/settings.png',
                        'name' => "<font>Settings</font>",
                        'url' => array('users/settings'),
                        'class' => 'block'
                    ),
                    '3' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/packages.png',
                        'name' => "<font>Documents</font>",
                        'url' => array('packageSubscriptionDocuments/admin'),
                        'class' => 'block last'
                    ),
                );
                return $amDashboardMenu;
                break;
            case 'dancer':
                $amDashboardMenu = array(
                    '1' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/video.png',
                        'name' => "<font>Classes</font>",
                        'url' => array('classes/index'),
                        'class' => 'block'
                    ),
                    '2' => array(
                        'icon' => Yii::app()->baseUrl . '/images/icon/settings.png',
                        'name' => "<font>Settings</font>",
                        'url' => array('users/settings'),
                        'class' => 'block'
                    )
                );
                return $amDashboardMenu;
                break;
        }
    }

    /**
     * function: getListCountry()        
     * @param none
     * @return array.
     */
    public static function getListCountry() {
        $model = CountryMaster::model()->findAll();
        return CHtml::listData($model, 'id', 'country');
    }

    /**
     * function: getPurchaseDetails()        
     * @param none
     * @return array.
     */
    public static function getPurchaseDetails($videoIds) {
        $oVideo = Videos::model()->findAll("id IN($videoIds)");

        $amVideoDetails = array();
        if ($oVideo) {
            foreach ($oVideo as $oDataSet) {
                $amVideoDetails[$oDataSet->id]['title'] = $oDataSet->title;
                $amVideoDetails[$oDataSet->id]['price'] = $oDataSet->price;
            }
        }
        return $amVideoDetails;
    }

    public static function displayApprovalImage($snStatus) {

        $ssImage = CHtml::image(Yii::app()->baseUrl . "/images/pending.gif");
        if ($snStatus == 2) {
            $ssImage = CHtml::image(Yii::app()->baseUrl . "/images/reject.png");
        }
        return $ssImage;
    }

    public static function getSampleVideosMenu() {
        $omSampleVideos = Videos::getAllSampleVideos();
        $amVideosMenu = array();
        if ($omSampleVideos) {
            $snI = 1;
            foreach ($omSampleVideos as $oDataSet) {
                $amVideosMenu[] = array(
                    'label' => "Sample Video $snI",
                    'url' => Yii::app()->createUrl('/site/samples', array('id' => base64_encode($oDataSet->id))),
                    'itemOptions' => array('class' => ''),
                );
                $snI++;
            }
        }
        return $amVideosMenu;
    }

    /**
     * function: encode()
     * @param string/int $string
     * @param mix string $key
     * @return mix string $hash.
     */
    public static function encode($string, $key) {
        $key = sha1($key);

        $strLen = strlen($string);

        $keyLen = strlen($key);

        for ($i = 0; $i < $strLen; $i+=2) {

            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));

            if ($j == $keyLen) {
                $j = 0;
            }

            $ordKey = ord(substr($key, $j, 1));

            $j++;

            $hash .= chr($ordStr - $ordKey);
        }

        return $hash;
    }

    /**
     * function: decode()
     * @param string/int $string
     * @param mix string $key
     * @return mix string $hash.
     */
    public static function decode($string, $key) {
        $key = sha1($key);

        $strLen = strlen($string);

        $keyLen = strlen($key);

        for ($i = 0; $i < $strLen; $i+=2) {

            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));

            if ($j == $keyLen) {
                $j = 0;
            }

            $ordKey = ord(substr($key, $j, 1));

            $j++;

            $hash .= chr($ordStr - $ordKey);
        }

        return $hash;
    }
    public static function isActiveItem($uri) {
        if ($uri == 'index/index')
            return true;
        return (strpos($_SERVER['REQUEST_URI'], $uri)) ? true : false;
    }
    
    public static function getFacebookID(){

        return (Configurations::getValue('facebook_appid') != '') ? Configurations::getValue('facebook_appid') : Yii::app()->params['FACEBOOK_APPID'];
    }
}

