<?php

Yii::import('application.models._base.BaseVideos');

class Videos extends BaseVideos {

    public $additional_status;
    public $num;
    public $subscription_id;
    public $subscription_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Videos', $n);
    }

    public function rules() {
        return array(
            array('title,image_url,iframe_code,price', 'required'),
            array('image_url', 'url', 'defaultScheme' => 'http'),
            array('status', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('title, image_url', 'length', 'max' => 255),
            array('description, iframe_code, created_at, updated_at, genre, age_range, category', 'safe'),
            array('title, description, price, image_url, iframe_code, status, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, title, description, price, image_url, iframe_code, status, created_at, updated_at, genre', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'image_url' => Yii::t('app', 'Video Thumbnail URL'),
            'iframe_code' => Yii::t('app', 'Video URL'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'classVideoses' => null,
            'subscriptionVideoTransactions' => null,
            'userVideoses' => null,
            'genre' => Yii::t('app', 'Genre'),
            
        );
    }

    /** function getAllActiveVideos() 
     * for get all videos.
     * return  object $omVideosResult
     */
    public static function getAllActiveVideos() {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.id,v.title';
        $oCriteria->alias = 'v';
        $oCriteria->condition = 'v.status != 2';

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omVideosResult = self::model()->findAll();

        return $omVideosResult;
    }

    /** function getVideosAsPerSubscription()
     * for get videos as per subscription
     * @param  int     $snSubscriptionId
     * return  boolean
     */
    public static function getVideosAsPerSubscription($snSubscriptionId, $bCriteria = false) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.*, svt.additional_status';
        $oCriteria->alias = 'v';
        $oCriteria->join = 'INNER JOIN subscription_video_transaction svt ON v.id=svt.video_id';
        $oCriteria->condition = 'svt.subscription_id = :subscriptionId';

        if (AdminModule::isStudioAdmin()) {
            $snUserID = Yii::app()->admin->id;
            $oCriteria->addCondition("v.id IN (SELECT video_id FROM user_purchased_videos WHERE subscription_id = :subscriptionId AND user_id = $snUserID)");
        }
        $oCriteria->params = array(':subscriptionId' => $snSubscriptionId);

        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omSubscriptionResult = self::model()->findAll();

        return $omSubscriptionResult;
    }

    /** function getUserPurchasedVideosFromSub() (CR)
     * for get videos as per subscription
     * @param  int     $snSubscriptionId
     * return  boolean
     */
    public static function getUserPurchasedVideosFromSub($snSubscriptionId = 0, $snPackageId = 0, $bCriteria = false, $title="",$genre="",$category="",$age="") {

        /* Phase-II:
          $oCriteria = new CDbCriteria;
          $oCriteria->select = 'v.*';
          $oCriteria->alias = 'v';
          $oCriteria->join = 'INNER JOIN user_purchased_videos upv ON v.id = upv.video_id AND upv.user_id = :snUserID AND upv.subscription_id = :subscriptionId';
          $oCriteria->params = array(':snUserID' => Yii::app()->admin->id, ':subscriptionId' => $snSubscriptionId);
         * 
         */

        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'DISTINCT v.id, v.title, v.image_url, v.iframe_code, v.description, v.genre, v.category, v.age_range';
        $oCriteria->alias = 'v';
        $oCriteria->join = 'INNER JOIN user_purchased_videos upv ON v.id = upv.video_id';
        $oCriteria->join .= ' INNER JOIN orders o ON o.user_id = upv.user_id';
        $oCriteria->join .= ' INNER JOIN order_details od ON o.id = od.order_id';
        $ssPackageSubCriteria = ($snSubscriptionId > 0) ? "upv.subscription_id = :subscriptionId" : "upv.package_id = :snPackageSubId";
        $oCriteria->condition = "upv.user_id = :snUserID AND $ssPackageSubCriteria";
        
        $snPackageSubId = ($snPackageId > 0) ? $snPackageId : $snSubscriptionId;
        $oCriteria->addCondition("o.payment_status = 1 AND od.package_subscription_id = :snPackageSubId AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')");
        // USING SUB QUERY //
        //$oCriteria->addCondition("upv.user_id IN (SELECT o.user_id FROM orders AS o INNER JOIN order_details od ON o.id = od.order_id WHERE o.payment_status = 1 AND od.package_subscription_id = :subscriptionId AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d'))");
        $oCriteria->group = 'v.id';
        $oCriteria->params = array(':snUserID' => Yii::app()->admin->id, ':subscriptionId' => $snSubscriptionId, ':snPackageSubId' => $snPackageSubId);
        if($title!=""){
            $oCriteria->addCondition("title LIKE :title");        
            $oCriteria->params[':title'] ="%$title%";
        }
        if($genre!=""){
            $oCriteria->addCondition("genre = :genre");        
            $oCriteria->params[':genre'] ="$genre";
        }
        if($category!=""){
            $oCriteria->addCondition("category = :category");        
            $oCriteria->params[':category'] ="$category";
        }
        if($age!=""){
            $oCriteria->addCondition("age_range = :age");        
            $oCriteria->params[':age'] ="$age";
        }

        ////////////////////////////////////////////////////////////////////////////////////////
        // FOR CHECK AND GET DECLIENED PAYMENT SUBSCRIPTION IDS //
        //$smPackageSubIds = Orders::getDeclinePaymentsSubscriptionIds();
        //if ($smPackageSubIds != "")
        //    $oCriteria->addCondition("od.package_subscription_id NOT IN ($smPackageSubIds)");
        ////////////////////////////////////////////////////////////////////////////////////////

        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omSubscriptionResult = self::model()->findAll();

        return $omSubscriptionResult;
    }

    /** function getUpdatedVideos()
     * for get videos as per subscription
     * @param  int     $snSubscriptionId
     * return  boolean
     */
    public static function getUpdatedVideos($snSubscriptionId, $bCriteria = false) {

        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.*, svt.additional_status';
        $oCriteria->alias = 'v';
        $oCriteria->join = 'INNER JOIN subscription_video_transaction svt ON v.id = svt.video_id';
        $oCriteria->condition = 'svt.subscription_id = :subscriptionId AND v.id NOT IN (SELECT video_id FROM user_purchased_videos WHERE user_id = :userID AND subscription_id = :subscriptionId)';
        $oCriteria->params = array(':subscriptionId' => $snSubscriptionId, ':userID' => Yii::app()->admin->id);                
        
        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omSubscriptionResult = self::model()->findAll();

        return $omSubscriptionResult;
    }
    
    public static function getUpdatedVideosAsCriteria($snSubscriptionId, $bCriteria = false,$title="",$genre="",$category="",$age="") 
    {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.*, svt.additional_status';
        $oCriteria->alias = 'v';
        $oCriteria->join = 'INNER JOIN subscription_video_transaction svt ON v.id = svt.video_id';
        $oCriteria->condition = 'svt.subscription_id = :subscriptionId AND v.id NOT IN (SELECT video_id FROM user_purchased_videos WHERE user_id = :userID AND subscription_id = :subscriptionId)';
        $oCriteria->params = array(':subscriptionId' => $snSubscriptionId, ':userID' => Yii::app()->admin->id);
        
        if($title!=""){
            $oCriteria->addCondition("title LIKE :title");        
            $oCriteria->params[':title'] ="%$title%";
        }
        if($genre!=""){
            $oCriteria->addCondition("genre = :genre");        
            $oCriteria->params[':genre'] ="$genre";
        }
        if($category!=""){
            $oCriteria->addCondition("category = :category");        
            $oCriteria->params[':category'] ="$category";
        }
        if($age!=""){
            $oCriteria->addCondition("age_range = :age");        
            $oCriteria->params[':age'] ="$age";
        }
        
        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        return $oCriteria;                
    }

    /** function getAllActiveVideosCriteria() 
     * for get all videos.
     * return  object $oCriteria
     */
    public static function getAllActiveVideosCriteria() {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.*,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 'v';
        $oCriteria->condition = 'v.status != 2';
        $oCriteria->order = 'v.title';

        return $oCriteria;
    }

    /** function getSubscriptionsAsPerVideo()
     * for get subscription as per videos
     * @param  int     $snVideoId
     * return  object
     */
    public static function getSubscriptionsAsPerVideo($snVideoId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.id, svt.video_id, svt.subscription_id as subscription_id, svt.additional_status, ps.name as subscription_name';
        $oCriteria->alias = 'v';
        $oCriteria->join = 'INNER JOIN subscription_video_transaction svt ON v.id=svt.video_id';
        $oCriteria->join .= ' INNER JOIN package_subscription ps ON svt.subscription_id=ps.id';
        $oCriteria->condition = 'v.id = :snVideoId';
        $oCriteria->params = array(':snVideoId' => $snVideoId);

        $omSubscriptionResult = self::model()->findAll($oCriteria);
        return $omSubscriptionResult;
    }

    /** function getAllActiveVideos() 
     * for get all videos.
     * return  object $omVideosResult
     */
    public static function getAllSampleVideos($snVideoId = 0) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'v.*';
        $oCriteria->alias = 'v';
        $oCriteria->condition = 'v.price <= 0';
        if($snVideoId > 0){
            $oCriteria->addCondition("v.id = $snVideoId");
        }

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omVideosResult = ($snVideoId > 0) ? self::model()->find() : self::model()->findAll();

        return $omVideosResult;
    }


    
    
}
