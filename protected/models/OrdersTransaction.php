<?php

Yii::import('application.models._base.BaseOrdersTransaction');

class OrdersTransaction extends BaseOrdersTransaction {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addVideosToSubscription() 
     * for get subscription as per package.
     * @param  int     $snSubscriptionId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function addVideosToSubscription($snSubscriptionId, $anVideoIds) {
        $snDecAvailCount = 0;
        foreach ($anVideoIds as $snVideoId) {
            $oModel = new Orders();
            $oModel->user_id = Yii::app()->admin->id;
            $oModel->package_subscription_id = $snSubscriptionId;
            $oModel->video_id = $snVideoId;
            $oModel->save();
            $snDecAvailCount++;
        }
        // UPDATE TOTAL AVAILABLE COUNT WITH DEC WHOM ADDED INTO THE SUBSCRIPTION //        
        $ssSql = "UPDATE user_available_update_video SET total_available_video=total_available_video-:decAvailVideoCnt WHERE subscription_id=:subscriptionID AND user_id=:userID";
        $oCommand = Yii::app()->db->createCommand($ssSql);
        $oCommand->bindValue(":subscriptionID", $snSubscriptionId, PDO::PARAM_INT);
        $oCommand->bindValue(":decAvailVideoCnt", $snDecAvailCount, PDO::PARAM_INT);
        $oCommand->bindValue(":userID", Yii::app()->admin->id, PDO::PARAM_INT);
        $oCommand->execute();
        
//        $ssSql = "UPDATE orders_transaction SET total_available_video=total_available_video-:decAvailVideoCnt WHERE subscription_id=:subscriptionID AND video_id IS NULL AND user_id=:userID";
//        $oCommand = Yii::app()->db->createCommand($ssSql);
//        $oCommand->bindValue(":subscriptionID", $snSubscriptionId, PDO::PARAM_INT);
//        $oCommand->bindValue(":decAvailVideoCnt", $snDecAvailCount, PDO::PARAM_INT);
//        $oCommand->bindValue(":userID", Yii::app()->admin->id, PDO::PARAM_INT);
//        $oCommand->execute();
    }

    /** function saveUserPackageSub() 
     * for add studio purchased package/subscription details
     * @param  int     $snOrderId
     * @param  array   $anPackageSubIds
     * return  boolean
     */
    public static function saveUserPackageSub($snOrderId, $anPackageSubIds) {
        //p($anPackageSubIds);
        $amUserPackageSubscription = array();
        foreach ($anPackageSubIds as $omData) {
            $ssType = is_object($omData) ? $omData->type : $omData['type'];
            $ssPackageSubId = is_object($omData) ? $omData->package_sub_id : $omData['package_sub_id'];
            if ($ssType == "Package") {
                $omSubscriptionId = PackageSubscriptionTransaction::getSubscriptionsAsPerPackage($ssPackageSubId);
                if ($omSubscriptionId) {
                    foreach ($omSubscriptionId as $omDataSet) {

                        // FOR GET AVAILABLE UPDATE FOR SUBSCRIPTION //
                        $omAdditionalVideos = Videos::getUpdatedVideos($omDataSet->subscription_id);
                        $snTotalFreeAvailable = (int) (count($omAdditionalVideos) / 2);

                        $amUserPackageSubscription[] = array('package_id' => $omDataSet->package_id,
                            'subscription_id' => $omDataSet->subscription_id,
                            'total_available_count' => $snTotalFreeAvailable,
                        );
                    }
                }
            } else {
                // FOR GET AVAILABLE UPDATE FOR SUBSCRIPTION //
                $omAdditionalVideos = Videos::getUpdatedVideos($ssPackageSubId);
                $snTotalFreeAvailable = (int) (count($omAdditionalVideos) / 2);

                $amUserPackageSubscription[] = array(
                    'subscription_id' => $ssPackageSubId,
                    'total_available_count' => $snTotalFreeAvailable,
                );
            }
        }
        //p($amUserPackageSubscription);
        foreach ($amUserPackageSubscription as $amResults) {

            $oModel = new OrdersTransaction();
            $oModel->user_id = Yii::app()->admin->id;
            $oModel->order_id = $snOrderId;
            if (isset($amResults['package_id']))
                $oModel->package_id = $amResults['package_id'];
            $oModel->subscription_id = $amResults['subscription_id'];
            $oModel->total_available_video = $amResults['total_available_count'];
            $oModel->save();
        }

        return true;
    }

}