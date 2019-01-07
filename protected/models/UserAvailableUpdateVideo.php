<?php

Yii::import('application.models._base.BaseUserAvailableUpdateVideo');

class UserAvailableUpdateVideo extends BaseUserAvailableUpdateVideo {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function saveUserPackageSub() 
     * for add user purchased subscription ids with available updates
     * @param  array   $anPackageSubIds
     * return  boolean
     */
    public static function saveUserAvaibleUpdate($anPackageSubIds) {
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

            $omUserSubExists = UserAvailableUpdateVideo::model()->findByAttributes(array('user_id' => Yii::app()->admin->id, 'subscription_id' => $amResults['subscription_id']));
            if (!$omUserSubExists) {
                $oModel = new UserAvailableUpdateVideo();
                $oModel->user_id = Yii::app()->admin->id;
                $oModel->subscription_id = $amResults['subscription_id'];
                $oModel->total_available_video = $amResults['total_available_count'];
                $oModel->save();
            }
        }
        return true;
    }

}