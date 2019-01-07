<?php

Yii::import('application.models._base.BasePackageSubscription');

class PackageSubscription extends BasePackageSubscription {

    public $subscriptions_videos;
    public $additional_status;
    public $num;
    public $video_id;
    public $subscription_id;
    public $title;
    public $image_url;
    public $static_image_url;
    public $total_update_count;
    public $total_used_count;

    public function rules() {
        return array(
            array('name,description,price_one_time,price,base_video_limit', 'required'),
            array('available_update', 'required', 'on' => 'add_package_subscription'),
            array('first_name, username, password', 'safe', 'on' => 'edit_package_subscription'),
            array('status', 'numerical', 'integerOnly' => true),
            array('price_one_time, price, base_video_limit, available_update', 'numerical'),
            array('name, image_url,static_image_url', 'length', 'max' => 255),
            array('type', 'length', 'max' => 12),
            array('created_at, updated_at, description', 'safe'),
            array('name, description, price_one_time, price, discount, duration, image_url, type, status, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, name, description, price_one_time, price, discount, duration, image_url, type, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price_one_time' => Yii::t('app', 'Charge yearly'),
            'price' => Yii::t('app', 'Charge monthly'),
            'image_url' => Yii::t('app', 'Upload Image'),
            'duration' => Yii::t('app', 'Term'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'packageSubscriptionTransactions' => null,
            'packageSubscriptionTransactions1' => null,
            'subscriptionVideoTransactions' => null,
            'userVideoses' => null,
            'static_image_url' => 'Image URL',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function getTerms() 
     * for get terms of package/subscription.
     * return  array
     */
    public static function getTerms() {

        return array('1' => 'Yearly', '2' => 'Monthly', '3' => 'Both');
    }

    /** function getTerms() 
     * for get terms of package/subscription.
     * return  array
     */
    public static function getTermsValue($snKey) {

        $amTerms = self::getTerms();
        return $amTerms[$snKey];
    }

    /** function getAllPackageSubscription() 
     * for get all subscription.
     * return  object $omSubscriptionResult
     */
    public static function getAllPackageSubscription($ssType = "Subscription") {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 's.id,s.name';
        $oCriteria->alias = 's';
        $oCriteria->condition = 's.type = :ssType AND s.status = :bStatus';
        $oCriteria->params = array(':ssType' => $ssType, ":bStatus" => 1);

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omSubscriptionResult = self::model()->findAll();

        return $omSubscriptionResult;
    }

    /** function getSubscriptionsAsPerPackage() 
     * for get subscription as per package.
     * @param  int     $snPackageId
     * return  object  $omSubscriptionResult
     */
    public static function getSubscriptionsAsPerPackage($snPackageId, $bCriteria = false) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'ps.*, pst.additional_status as additional_status';
        $oCriteria->alias = 'ps';
        $oCriteria->join = 'INNER JOIN package_subscription_transaction pst ON ps.id=pst.subscription_id';
        $oCriteria->condition = 'pst.package_id = :packageId';
        $oCriteria->params = array(':packageId' => $snPackageId);

        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }

        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omSubscriptionsResult = self::model()->findAll();

        return $omSubscriptionsResult;
    }

    /** function getAllPackageSubscriptionCriteria() 
     * for get all package/subscription as per type with active status.
     * return  object $omSubscriptionResult
     */
    public static function getAllPackageSubscriptionCriteria($ssType = "Subscription") {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 's.*,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 's';
        $oCriteria->condition = 's.type = :ssType AND s.status != :bStatus ORDER BY s.id DESC';
        $oCriteria->params = array(':ssType' => $ssType, ":bStatus" => 2);

        return $oCriteria;
    }

    /** function getAllVideosAsPerPackageId() 
     * for get all videos as per package id
     * return  object $omPackageVideoResults
     */
    public static function getAllVideosAsPerPackageId($snPackageId, $bCriteria = false) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'ps.id,ps.name,pss.name,pst.subscription_id,svt.video_id,svt.additional_status,v.title,v.image_url';
        $oCriteria->alias = 'ps';
        $oCriteria->join = 'INNER JOIN package_subscription_transaction as pst on ps.id=pst.package_id  ';
        $oCriteria->join .= ' INNER JOIN package_subscription as pss on pst.subscription_id=pss.id';
        $oCriteria->join .= ' INNER JOIN subscription_video_transaction as svt on svt.subscription_id=pst.subscription_id';
        $oCriteria->join .= ' INNER JOIN videos as v on v.id = svt.video_id';
        $oCriteria->condition = 'ps.id = :packageID';
        $oCriteria->params = array(':packageID' => $snPackageId);


        if ($bCriteria) {
            $oCriteria->select .= ',(select @n := @n + 1 from (select @n:=0) initvar) as num';
            return $oCriteria;
        }

        $omPackageVideoResults = self::model()->findAll($oCriteria);

        return $omPackageVideoResults;
    }

    /** function getAllUpdateVideosAsPerPackage() 
     * for get all videos updated as per package id
     * return  object $omUpdatedPackageVideoResults
     */
    public static function getAllUpdateVideosAsPerPackage($snPackageId, $bCriteria = false) {
        $snUserId = Yii::app()->admin->id;
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'ps.id,pst.subscription_id,svt.video_id';
        $oCriteria->alias = 'ps';
        $oCriteria->join = 'INNER JOIN package_subscription_transaction as pst on ps.id=pst.package_id';
        $oCriteria->join .= ' INNER JOIN subscription_video_transaction as svt On pst.subscription_id=svt.subscription_id';
        $oCriteria->condition = 'ps.id = :packageID AND svt.additional_status = 1';
        $oCriteria->addCondition("svt.video_id NOT IN(SELECT video_id FROM user_purchased_videos WHERE user_id = $snUserId AND subscription_id = svt.subscription_id)");
        $oCriteria->params = array(':packageID' => $snPackageId);

        if ($bCriteria) {
            return $oCriteria;
        }

        $omPackageVideoResults = self::model()->findAll($oCriteria);

        return $omPackageVideoResults;
    }

    /** function getAvailableUpdateAsPerPackageSub() (CR)
     * for user available video count
     * return  object $snAvailableUpdateCount
     */
    public static function getAvailableUpdateAsPerPackageSub($snPackageSubId, $snPackageId = 0) {
        $snUserId = Yii::app()->admin->id;
        $snSubId = $snPackageSubId;
        $snPackageSubId = ($snPackageId > 0) ? $snPackageId : $snSubId;
        $ssPackageCriteria = ($snPackageId > 0) ? "package_id = $snPackageId" : "subscription_id = $snSubId AND package_id IS NULL";

        //$ssSelectTotalUpdateCriteria = "(ps.base_video_limit + (IF(od.duration = 1,ps.monthly_update_limit,ps.yearly_update_limit))) - (SELECT count(*) FROM user_purchased_videos upv WHERE is_updated = 0 AND user_id = $snUserId AND $ssPackageCriteria ) AS total_update_count";
        //$ssSelectAvailableUpdateCriteria = "(SELECT count(*) FROM user_purchased_videos WHERE is_updated = 1 AND user_id = $snUserId AND $ssPackageCriteria AND (IF(od.duration = 1, (updated_on <= NOW() AND updated_on >= DATE_SUB(NOW(), INTERVAL MOD(DATEDIFF(NOW(),od.start_date), DAY(LAST_DAY(NOW())) ) DAY)), (updated_on >= od.start_date AND updated_on <= od.expiry_date)  )) ) as total_used_count";
        $ssSelectTotalUpdateCriteria = "(ps.base_video_limit + ps.available_update) - (SELECT count(*) FROM user_purchased_videos upv WHERE is_updated = 0 AND user_id = $snUserId AND $ssPackageCriteria ) AS total_update_count";
        $ssSelectAvailableUpdateCriteria = "(SELECT count(*) FROM user_purchased_videos WHERE is_updated = 1 AND user_id = $snUserId AND $ssPackageCriteria) as total_used_count";

        $oCriteria = new CDbCriteria;
        $oCriteria->select = "$ssSelectTotalUpdateCriteria,$ssSelectAvailableUpdateCriteria";
        $oCriteria->alias = 'ps';
        $oCriteria->join = 'INNER JOIN order_details od ON ps.id = od.package_subscription_id';
        $oCriteria->join .= ' INNER JOIN orders o ON o.id = od.order_id';
        $oCriteria->condition = 'ps.id = :packageSubID AND o.user_id = :userID AND od.expiry_date >= NOW()';
        $oCriteria->params = array(':packageSubID' => $snPackageSubId, ':userID' => $snUserId);
        $omResultSet = self::model()->find($oCriteria);

        $snAvailableUpdateCount = ($omResultSet) ? $omResultSet->total_update_count - $omResultSet->total_used_count : 0;
        return $snAvailableUpdateCount;
    }

    /** function getPSArray() 
     * for get all Package-Subscription Information 
     * return  array
     */
    public static function getPSArray($id = 0, $ps = '') {

        if ($id == 0) {
            return Yii::app()->db->createCommand('select * from package_subscription WHERE status=:status order by type')->bindValue(':status', 1)->queryAll();
        } else if ($ps == '') {
            return Yii::app()->db->createCommand('select * from package_subscription as ps WHERE ps.id=:id')->bindValue(':id', $id)->queryAll();
        } else if ($ps == 'Package') {
            return Yii::app()->db->createCommand('select pss.name,pst.subscription_id,ps.name as sub,ps.description,ps.image_url,ps.type,ps.price_one_time,ps.price from package_subscription as ps 
INNER JOIN package_subscription_transaction as pst on ps.id=pst.package_id  
INNER JOIN package_subscription as pss on pst.subscription_id=pss.id 
WHERE ps.id=:id')->bindValue(':id', $id)->queryAll();
        } else if ($ps == 'Subscription') {
            return Yii::app()->db->createCommand('select ps.id as subscription_id,ps.name ,ps.description,ps.image_url,ps.type,ps.price_one_time,ps.price from package_subscription as ps WHERE ps.id=:id')->bindValue(':id', $id)->queryAll();
        }
    }

    /** function getVideoArray() 
     * for get all Video Information
     * return  array
     */
    public static function getVideoArray($id) {
        // Phase-II: Get only base videos from subscription //
        //return Yii::app()->db->createCommand('select v.id,v.title,v.image_url from subscription_video_transaction as svt INNER JOIN videos as v on svt.video_id = v.id WHERE svt.subscription_id=:id')->bindValue(':id', $id)->queryAll();
        return Yii::app()->db->createCommand('select v.id,v.title,v.image_url,svt.additional_status from subscription_video_transaction as svt INNER JOIN videos as v on svt.video_id = v.id WHERE svt.subscription_id=:id AND svt.additional_status = 0')->bindValue(':id', $id)->queryAll();
    }

    /** function getSubscriptionsIdsAsPerPackage() 
     * for get all subscription ids as per package id
     * @param  int     $snPackageId
     * return  array
     */
    public static function getSubscriptionsIdsAsPerPackage($snPackageId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'pst';
        $oCriteria->condition = 'pst.package_id = :packageID';
        $oCriteria->params = array(':packageID' => $snPackageId);
        $omResultSet = PackageSubscriptionTransaction::model()->findAll($oCriteria);

        $anSubscriptionIds = array();
        if ($omResultSet) {
            foreach ($omResultSet as $omDataSet) {
                $anSubscriptionIds[] = $omDataSet->subscription_id;
            }
        }
        return $anSubscriptionIds;
    }

}
