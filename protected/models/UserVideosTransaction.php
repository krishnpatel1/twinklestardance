<?php

Yii::import('application.models._base.BaseUserVideosTransaction');

class UserVideosTransaction extends BaseUserVideosTransaction {

    public $title;
    public $price;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function saveUserVideos() 
     * for add dancer (user) videos.
     * @param  int     $snClassId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function saveUserVideos($snClassId, $anVideoIds, $snOrderId) {

        foreach ($anVideoIds as $snVideoId) {
            $oModel = new UserVideosTransaction();
            $oModel->order_id = $snOrderId;
            $oModel->user_id = Yii::app()->admin->id;
            $oModel->class_id = $snClassId;
            $oModel->video_id = $snVideoId;
            $oModel->save();
        }
    }

    /** function checkIsUserPackageSubHasBeenExpired() 
     * for check is package/subscription has been expired
     * @param  array     $snPackageSubId
     * return  boolean
     */
    public static function getDancerOrderDetails($snOrderId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'uvt.order_id,v.title,v.price';
        $oCriteria->alias = 'uvt';
        $oCriteria->join = "INNER JOIN orders o ON uvt.order_id = o.id";
        $oCriteria->join .= " INNER JOIN videos v ON uvt.video_id = v.id";
        $oCriteria->condition = "o.id = :snOrderId";
        $oCriteria->params = array(':snOrderId' => $snOrderId);

        $omResultSet = self::model()->findAll($oCriteria);

        return $omResultSet;
    }

}