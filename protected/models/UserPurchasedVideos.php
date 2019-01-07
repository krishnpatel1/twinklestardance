<?php

Yii::import('application.models._base.BaseUserPurchasedVideos');

class UserPurchasedVideos extends BaseUserPurchasedVideos {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addVideosToSubscription()  (CR)
     * for add updated videos from subscription
     * @param  int     $snSubscriptionId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function addUpdatedVideosToSubscription($snSubscriptionId, $anVideoIds, $snPackageId) {
        foreach ($anVideoIds as $snVideoId) {
            $oModel = new UserPurchasedVideos();
            $oModel->user_id = Yii::app()->admin->id;

            if ($snPackageId > 0)
                $oModel->package_id = $snPackageId;

            $oModel->subscription_id = $snSubscriptionId;
            $oModel->video_id = $snVideoId;
            $oModel->is_updated = 1;
            $oModel->updated_on = date('Y-m-d H:i:s');
            $oModel->save();
        }

        return true;
    }

    /** function assignVideosToUser() 
     * to assign the videos to user after purchasing them     
     * return  none
     */
    public static function assignVideosToUser($videoIds, $packageId=0) {
        $arrVideos = explode(',', $videoIds);
        foreach ($arrVideos as $video) {
            $all = explode('_', $video);
	    $model = false;
	    if(isset($all[0]) && isset($all[1])){
		$model = UserPurchasedVideos::model()->find('user_id =:user_id and subscription_id=:subscription_id and video_id=:video_id', 			array(
                'user_id' => Yii::app()->admin->id,
                ':subscription_id' => $all[0],
                ':video_id' => $all[1])
	       );
		if (!$model) {
		   $model = new UserPurchasedVideos();
		    $model->user_id = Yii::app()->admin->id;
		    if($packageId)
		       $model->package_id = $packageId;
		    $model->subscription_id = $all[0];
		    $model->video_id = $all[1];
		    $model->is_updated = 0;
		    $model->save(false);
		}
	    }                        
        }
    }

}
