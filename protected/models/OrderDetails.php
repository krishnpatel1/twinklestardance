<?php

Yii::import('application.models._base.BaseOrderDetails');

class OrderDetails extends BaseOrderDetails {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function saveStudioOrderDetails($amOrderDetails) {

        $oModel = new OrderDetails();
        $oModel->order_id = $amOrderDetails['order_id'];
        $oModel->package_subscription_id = $amOrderDetails['package_subscription_id'];
        $oModel->start_date = $amOrderDetails['start_date'];
        $oModel->expiry_date = $amOrderDetails['expiry_date'];
        $oModel->amount = $amOrderDetails['amount'];
        $oModel->duration = $amOrderDetails['duration'];

        $oModel->save(false);
    }

    public static function getStudioOrders($snUserId, $bIsCriteria = false) {

        $oCriteria = new CDbCriteria;
        $oCriteria->select = "o.id, od.*";
        $oCriteria->alias = 'od';
        $oCriteria->join = 'INNER JOIN orders o ON o.id = od.order_id';
        $oCriteria->condition = "o.user_id = :snUserId";
        $oCriteria->order = "od.id DESC";
        $oCriteria->params = array(':snUserId' => $snUserId);

        return ($bIsCriteria) ? $oCriteria : self::model()->findAll($oCriteria);
    }

}