<?php

Yii::import('application.models._base.BaseOrders');

class Orders extends BaseOrders {

    public $num;
    public $type;
    public $v_title;
    public $v_image_url;
    public $subscription_id;
    public $package_subscription_id;
    public $name;
    public $image_url;
    public $tot_available_count;
    public $total_update_count;
    public $total_used_count;
    public $ps_ids;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function getPaymentStatusOptions() 
     * for get payment status array
     * return  array
     */
    public function getPaymentStatusOptions() {
//        return array(
//            '0' => "Pending",
//            '1' => "Paid",
//            '2' => "Failed",
//            '3' => "Free"
//        );
        return Yii::app()->params['displayamPaymentStatus'];
    }

    /** function getPaymentStatusText() 
     * for get payment status text
     * return  string
     */
    public function getPaymentStatusText() {
        $amStatusOptions = $this->getPaymentStatusOptions();
        return isset($amStatusOptions[$this->payment_status]) ? $amStatusOptions[$this->payment_status] : "unknown status ({$this->payment_status})";
    }

    /** function removeSelectedOrders() 
     * for remove selected orders 
     * @param  array     $anOrderIds
     * return  boolean
     */
    public static function removeSelectedOrders($anOrderIds) 
    {
        //$bDeleted = Orders::model()->deleteAll('id IN(' . implode(',', $anOrderIds) . ')');
        $criteria = new CDbCriteria;
        $criteria->addInCondition("order_id" , $anOrderIds );
        OrderDetails::model()->updateAll(array('is_deleted'=>'1'), $criteria);

        $criteria = new CDbCriteria;
        $criteria->addInCondition("id" , $anOrderIds );
        Orders::model()->updateAll(array('is_deleted'=>'1'), $criteria);

        return 1;
    }

    /** function getUserVideos()
     * for get user purchased packages/subscriptions/videos
     * return  object criteria/result
     */
    public static function getUserVideos($bCriteria = false) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'o.id,o.user_id,o.payment_status,od.package_subscription_id,od.start_date,od.expiry_date,ps.name,ps.image_url,ps.type,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 'o';
        $oCriteria->join = 'INNER JOIN order_details od ON o.id = od.order_id';
        $oCriteria->join .= ' INNER JOIN package_subscription ps ON od.package_subscription_id = ps.id';
        $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1 AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= CONCAT(DATE_FORMAT(NOW() -INTERVAL 1 DAY, '%Y-%m-%d'))";
        $oCriteria->order = "num";
        $oCriteria->group = "ps.id";
        $oCriteria->params = array(':snUserId' => Yii::app()->admin->id);

        /*
        ////////////////////////////////////////////////////////////////////////////////////////
        // FOR CHECK AND GET DECLIENED PAYMENT SUBSCRIPTION IDS //
        $smPackageSubIds = self::getDeclinePaymentsSubscriptionIds();
        if ($smPackageSubIds != "")
            $oCriteria->addCondition("od.package_subscription_id NOT IN ($smPackageSubIds)");
        ////////////////////////////////////////////////////////////////////////////////////////
        */
        if (!$bCriteria)
            return $oCriteria;

        $omResultSet = self::model()->findAll($oCriteria);

        return $omResultSet;
    }

    /** function getAndCheckUserPurchasedSubscriptions()
     * for get user purchased packages/subscriptions
     * return  object criteria/result
     */
    public static function getAndCheckUserPurchasedSubscriptions($bCriteria = false) {
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'o';
        $oCriteria->join = 'INNER JOIN order_details od ON o.id = od.order_id';
        $oCriteria->join .= ' INNER JOIN package_subscription ps ON od.package_subscription_id = ps.id';
        $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1 AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
        $oCriteria->params = array(':snUserId' => Yii::app()->admin->id);

        /*
        ////////////////////////////////////////////////////////////////////////////////////////
        // FOR CHECK AND GET DECLIENED PAYMENT SUBSCRIPTION IDS //
        $smPackageSubIds = self::getDeclinePaymentsSubscriptionIds();
        if ($smPackageSubIds != "")
            $oCriteria->addCondition("od.package_subscription_id NOT IN ($smPackageSubIds)");
        ////////////////////////////////////////////////////////////////////////////////////////
        */
        if (!$bCriteria)
            return $oCriteria;

        $omResultSet = self::model()->findAll($oCriteria);

        return $omResultSet;
    }

    /** function getTotalAvailableUpdateFromPurchasedPackageSub()  (CR)
     * for get user purchase package/subscription ids
     * return  array $anSubscriptionIDs
     */
    public static function getTotalAvailableUpdateFromPurchasedPackageSub($bCriteria = false) {

        // FOR GET USER PURCHASED PACKAGE/SUBSCRIPTION IDS //
        $oCriteria = new CDbCriteria;
        $oCriteria->select = "od.package_subscription_id,ps.type";
        $oCriteria->alias = "o";
        $oCriteria->join = "INNER JOIN order_details od ON o.id = od.order_id";
        $oCriteria->join .= " INNER JOIN package_subscription ps ON od.package_subscription_id = ps.id";
        $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1 AND od.expiry_date >= NOW()";
        $oCriteria->params = array(':snUserId' => Yii::app()->admin->id);

        /*
        ////////////////////////////////////////////////////////////////////////////////////////
        // FOR CHECK AND GET DECLIENED PAYMENT SUBSCRIPTION IDS //
        $smPackageSubIds = self::getDeclinePaymentsSubscriptionIds();
        if ($smPackageSubIds != "")
            $oCriteria->addCondition("od.package_subscription_id NOT IN ($smPackageSubIds)");
        ////////////////////////////////////////////////////////////////////////////////////////
        */
        
        $anPackageSubIds = array();
        $omResultSet = self::model()->findAll($oCriteria);
        // Phase-II: Changes to resolved bug - (minus) update value //
        $snTotalAvailableUpdateCount = 0;
        if ($omResultSet) {
            foreach ($omResultSet as $oDataSet) {
                if ($oDataSet->type == "Package") {
                    //$anPackageSubIds["package_ids"][] = $oDataSet->package_subscription_id;
                    $anPackageSubIds["package_ids"][] = PackageSubscription::getAvailableUpdateAsPerPackageSub($oDataSet->package_subscription_id, $oDataSet->package_subscription_id);
                } else {
                    //$anPackageSubIds['subscription_ids'][] = $oDataSet->package_subscription_id;
                    $anPackageSubIds["subscription_ids"][] = PackageSubscription::getAvailableUpdateAsPerPackageSub($oDataSet->package_subscription_id);
                }
            }
            $anPackageSubIds["package_ids"] = isset($anPackageSubIds["package_ids"]) ? array_map('unserialize', array_unique(array_map('serialize', $anPackageSubIds["package_ids"]))) : array();
            $anPackageSubIds["subscription_ids"] = isset($anPackageSubIds["subscription_ids"]) ? array_map('unserialize', array_unique(array_map('serialize', $anPackageSubIds["subscription_ids"]))) : array();

            $snTotalAvailableUpdateCount += count($anPackageSubIds["package_ids"]) > 0 ? array_sum($anPackageSubIds["package_ids"]) : 0;
            $snTotalAvailableUpdateCount += count($anPackageSubIds["subscription_ids"]) ? array_sum($anPackageSubIds["subscription_ids"]) : 0;


            /* Phase-II: 
              // FOR CALCULATE USER AVAILABLE UPDATE FROM PURCHASED PACKAGE/SUBSCRIPTION //
              $snUserId = Yii::app()->admin->id;
              $smPackageIds = (isset($anPackageSubIds["package_ids"]) && count($anPackageSubIds["package_ids"]) > 0 ) ? implode(',', $anPackageSubIds['package_ids']) : "";
              $smSubIds = (isset($anPackageSubIds["subscription_ids"]) && count($anPackageSubIds["subscription_ids"]) > 0 ) ? implode(',', $anPackageSubIds['subscription_ids']) : "";

              $ssPackageCriteria = ($smPackageIds != "" ) ? "upv.package_id IN($smPackageIds)" : 1;
              $ssSubscriptionCriteria = ($smSubIds != "") ? "upv.subscription_id IN($smSubIds)" : 1;

              //$ssSelectTotalUpdateCriteria = "SUM(ps.base_video_limit + (IF(od.duration = 1,ps.monthly_update_limit,ps.yearly_update_limit))) - (SELECT count(*) FROM user_purchased_videos upv WHERE is_updated = 0 AND user_id = $snUserId AND ($ssPackageCriteria OR $ssSubscriptionCriteria) ) AS total_update_count";
              //$ssSelectAvailableUpdateCriteria = "(SELECT COUNT(*) FROM user_purchased_videos upv WHERE upv.user_id = $snUserId AND upv.is_updated = 1 AND (IF(od.duration = 1, (upv.updated_on <= NOW() AND upv.updated_on >= DATE_SUB(NOW(), INTERVAL MOD(DATEDIFF(NOW(),od.start_date), DAY(LAST_DAY(NOW())) ) DAY)), (upv.updated_on >= od.start_date AND upv.updated_on <= od.expiry_date) )) AND ($ssPackageCriteria OR $ssSubscriptionCriteria) ) AS total_used_count";
              $ssSelectTotalUpdateCriteria = "SUM(ps.base_video_limit + ps.available_update) - (SELECT count(*) FROM user_purchased_videos upv WHERE is_updated = 0 AND user_id = $snUserId AND ($ssPackageCriteria OR $ssSubscriptionCriteria) ) AS total_update_count";
              $ssSelectAvailableUpdateCriteria = "(SELECT COUNT(*) FROM user_purchased_videos upv WHERE upv.user_id = $snUserId AND upv.is_updated = 1 AND ($ssPackageCriteria OR $ssSubscriptionCriteria) ) AS total_used_count";

              $oCriteria = new CDbCriteria;
              $oCriteria->select = "$ssSelectTotalUpdateCriteria,$ssSelectAvailableUpdateCriteria";
              $oCriteria->alias = "o";
              $oCriteria->join = "INNER JOIN order_details od ON o.id = od.order_id";
              $oCriteria->join .= " INNER JOIN package_subscription ps ON od.package_subscription_id = ps.id";
              $oCriteria->condition = "o.user_id = :snUserId AND o.payment_status = 1 AND od.expiry_date >= NOW()";
              $oCriteria->params = array(':snUserId' => Yii::app()->admin->id);
              $omResultSet = self::model()->find($oCriteria);

              $snUpdatedCount = ($omResultSet->total_update_count > 0) ? $omResultSet->total_update_count : 0;
              $snUsedCount = ($omResultSet->total_used_count > 0) ? $omResultSet->total_used_count : 0;

              $snTotalAvailableUpdateCount = ($omResultSet) ? $snUpdatedCount - $snUsedCount : 0;
             * 
             */
        }


        return $snTotalAvailableUpdateCount;
    }

    /** function saveStudioOrderInfo() 
     * for add studio order with pending payment status
     * @param  array     $amPaymentInfo
     * return  boolean
     */
    public static function saveStudioOrderInfo($amPaymentInfo) {

        $oModel = new Orders();
        $oModel->user_id = $amPaymentInfo['user_id'];
        //$oModel->package_subscription_id = $amPaymentInfo['package_subscription_id'];
        $oModel->payment_status = $amPaymentInfo['payment_status'];
        $oModel->sub_total = $amPaymentInfo['sub_total'];
        $oModel->tax = $amPaymentInfo['tax'];
        $oModel->amount_paid = $amPaymentInfo['amount_paid'];
        $oModel->shipping = $amPaymentInfo['shipping'];
        $oModel->payment_date = $amPaymentInfo['payment_date'];
        if (isset($amPaymentInfo['payment_method']))
            $oModel->payment_method = $amPaymentInfo['payment_method'];

        if(isset($amPaymentInfo['payment_type']))
            $oModel->payment_type = $amPaymentInfo['payment_type'];

        $oModel->save(false);

        return $oModel;
    }

    /** function saveDancerOrder()  (CR)
     * for add dancer (user) videos.
     * @param  array     $amPaymentInfo
     * return  boolean
     */
    public static function saveDancerOrder($amPaymentInfo) {

        $oModel = new Orders();
        $oModel->user_id = $amPaymentInfo['user_id'];
        $oModel->payment_status = $amPaymentInfo['payment_status'];
        $oModel->sub_total = $amPaymentInfo['sub_total'];
        $oModel->tax = $amPaymentInfo['tax'];
        $oModel->amount_paid = $amPaymentInfo['amount_paid'];
        $oModel->shipping = $amPaymentInfo['shipping'];
        $oModel->payment_date = $amPaymentInfo['payment_date'];
        $oModel->save(false);

        return $oModel;
    }

    /** function checkIsUserPackageSubHasBeenExpired() 
     * for check is package/subscription has been expired
     * @param  array     $snPackageSubId
     * return  boolean
     */
    public static function checkIsUserPackageSubHasBeenExpired($snPackageSubId, $snUserId = 0) {

        $snUserId = ($snUserId > 0) ? $snUserId : Yii::app()->admin->id;

        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'o';
        $oCriteria->join = 'INNER JOIN order_details od ON o.id = od.order_id';
        $oCriteria->condition = "od.package_subscription_id = :snPackageSubId AND o.user_id = :snUserId AND o.payment_status = 1 AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
        $oCriteria->params = array(':snPackageSubId' => $snPackageSubId, ':snUserId' => $snUserId);

        $omResultSet = self::model()->find($oCriteria);

        return $omResultSet;
    }

    /** function checkIsUserPackageSubHasBeenExpired() 
     * for check is package/subscription has been expired
     * @param  array     $snPackageSubId
     * return  boolean
     */
    public static function getUserOrdersDetails() {
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'o';
        $oCriteria->condition = "o.payment_status != 4 AND is_deleted = 0";
        $oCriteria->order = "o.payment_date desc";

        return new CActiveDataProvider("Orders", array(
            'criteria' => $oCriteria,
        ));
    }

    /** function getUserPurchasedDetails() 
     * for check is package/subscription has been expired
     * @param  array     $snPackageSubId
     * return  boolean
     */
    public static function getUserPurchasedDetails($snOrderId) {
        $oCriteria = new CDbCriteria;
        //$oCriteria->select = "o.user_id,od.*";
        $oCriteria->alias = 'o';
        //$oCriteria->join = 'INNER JOIN order_details od ON o.id = od.order_id';
        $oCriteria->condition = "o.id = :snOrderId";
        $oCriteria->params = array(':snOrderId' => $snOrderId);

        $omResultSet = self::model()->findAll($oCriteria);
//        return new CActiveDataProvider("Orders", array(
//                    'criteria' => $oCriteria,
//                ));

        return $omResultSet;
    }

    public function search() {

        $criteria = new CDbCriteria;
        $criteria->alias = 'o';
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('payment_status', $this->payment_status);
        $criteria->compare('sub_total', $this->sub_total);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('amount_paid', $this->amount_paid);
        $criteria->compare('shipping', $this->shipping);
        $criteria->compare('payment_date', $this->payment_date, true);
        $criteria->condition = "o.payment_status != 3";
        $criteria->order = "o.payment_date desc";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /** function getDeclinePaymentsSubscriptionIds() 
     * for get admin decline payment subscriptin ids.
     * return  array
     */
    public static function getDeclinePaymentsSubscriptionIds($snStudioId = "") {
        $snStudioId = ($snStudioId != "") ? $snStudioId : Yii::app()->admin->id;
        $oCriteria = new CDbCriteria;
        $oCriteria->select = "GROUP_CONCAT( DISTINCT od.package_subscription_id ) AS ps_ids";
        $oCriteria->alias = "o";
        $oCriteria->join = "INNER JOIN order_details od ON o.id = od.order_id";
        $oCriteria->condition = "o.user_id = :snUserId AND (od.sub_payment_status =:snFailed || od.sub_payment_status =:snPending)";
        $oCriteria->addCondition("IF(od.sub_payment_status != 3, DATE_FORMAT(od.due_date,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d'),1)");
        $oCriteria->params = array(':snUserId' => $snStudioId,
            ':snFailed' => Yii::app()->params['amPaymentStatus']['failed'],
            ':snPending' => Yii::app()->params['amPaymentStatus']['pending']
        );

        $omResults = self::model()->find($oCriteria);

        return $omResults->ps_ids;
    }

}