<?php

Yii::import('application.models._base.BaseSubscriptionVideoTransaction');

class SubscriptionVideoTransaction extends BaseSubscriptionVideoTransaction {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function saveSubscriptions() 
     * for get subscription as per package.
     * @param  int     $snSubscriptionId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function saveVideosIds($snSubscriptionId, $anVideoIds, $updated = 0) {
                
        if (count($anVideoIds) > 0) {
            foreach ($anVideoIds as $snVideoId) {
                // FOR CHECK SUBSCRIPTION VIDEO ALREADY EXISTS OR NOT //
                $oCriteria = new CDbCriteria;
                $oCriteria->alias = 'svt';
                $oCriteria->condition = 'svt.video_id=:videoID AND svt.subscription_id=:subscriptionID';
                $oCriteria->params = array(':videoID' => $snVideoId, ':subscriptionID' => $snSubscriptionId);
                $omRecordExists = SubscriptionVideoTransaction::model()->find($oCriteria);

                if (!$omRecordExists) {
                    // FOR ADD VIDEOS UNDER SUBSCRIPTION //
                    $oModel = new SubscriptionVideoTransaction();
                    $oModel->subscription_id = $snSubscriptionId;
                    $oModel->video_id = $snVideoId;
                    $oModel->additional_status = $updated;
                    $oModel->save();
                }
            }           
        }
        // REMOVE VIDEOS FROM SUBSCRIPOTION WHICH ARE UNSELECTED //
        self::removeUnselectedVideoIds($snSubscriptionId, $anVideoIds);
        return true;
    }

    /** function removeUnselectedVideoIds() 
     * for remove video which are unselected from subscription
     * @param  int     $snSubscriptionId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function removeUnselectedVideoIds($snSubscriptionId, $anVideoIds) {
        $ssVideoCriteria = (count($anVideoIds) > 0) ? 'video_id NOT IN(' . implode(',', $anVideoIds) . ') AND subscription_id = ' . $snSubscriptionId : 'subscription_id = ' . $snSubscriptionId;
        SubscriptionVideoTransaction::model()->deleteAll($ssVideoCriteria);
        return true;
    }

    /** function saveSubscriptionIds() 
     * for add/remove selected/unselected subscription ids from video id
     * @param  int     $snSubscriptionId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function saveSubscriptionIds($snVideoId, $anSubIds, $updated = 0) {
        foreach ($anSubIds as $snSubscriptionId) {
            // FOR CHECK VIDEO SUBSCRIPTION ALREADY EXISTS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'svt';
            $oCriteria->condition = 'svt.video_id=:videoID AND svt.subscription_id=:subscriptionID';
            $oCriteria->params = array(':subscriptionID' => $snSubscriptionId, ':videoID' => $snVideoId);
            $omRecordExists = SubscriptionVideoTransaction::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD SUBSCRIPTION UNDER VIDEOS //
                $oModel = new SubscriptionVideoTransaction();
                $oModel->subscription_id = $snSubscriptionId;
                $oModel->video_id = $snVideoId;
                $oModel->additional_status = $updated;
                $oModel->save();
            }
        }
        // REMOVE SUBSCRIPTION FROM WHICH ARE UNSELECTED //
        self::removeUnselectedSubIds($snVideoId, $anSubIds);
        return true;
    }

    /** function removeUnselectedSubIds() 
     * for remove subscription ids which are unselected from video
     * @param  int     $snVidoeId
     * @param  array   $anSubIds
     * return  boolean
     */
    public static function removeUnselectedSubIds($snVideoId, $anSubIds) {
        $ssVideoCriteria = (count($anSubIds) > 0) ? 'subscription_id NOT IN(' . implode(',', $anSubIds) . ') AND video_id = ' . $snVideoId : 'video_id = ' . $snVideoId;
        SubscriptionVideoTransaction::model()->deleteAll($ssVideoCriteria);
        return true;
    }

    /** function removeVideoFromSubscription() 
     * for remove particular video from the subscription
     * @param  int     $snSubscriptionId
     * @param  array   $snVideoId
     * return  boolean
     */
    public static function removeVideoFromSubscription($snSubscriptionId, $snVideoId) {

        $bDeleteStatus = SubscriptionVideoTransaction::model()->deleteAll('subscription_id = :subscriptionID AND video_id =:videoID', array('subscriptionID' => $snSubscriptionId, 'videoID' => $snVideoId));
        return $bDeleteStatus;
    }

    /** function getTotalUpdatedVideos() 
     * for get all videos updated as per package id
     * return  object $omUpdatedPackageVideoResults
     */
    public static function getTotalUpdatedVideos($anSubscriptionIDs, $bCriteria = false) {
        
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'svt';
        $oCriteria->condition = 'svt.subscription_id IN('.implode(",",$anSubscriptionIDs).') AND svt.additional_status = 1 AND svt.video_id NOT IN(SELECT video_id FROM user_purchased_videos WHERE AND user_id = :userID AND subscription_id = svt.subscription_id)';
        $oCriteria->params = array(':userID' => Yii::app()->admin->id);

        if ($bCriteria) {
            return $oCriteria;
        }

        $omUpdatedPackageVideoResults = self::model()->findAll($oCriteria);

        return $omUpdatedPackageVideoResults;
    }

}