<?php

Yii::import('application.models._base.BaseCart');

class Cart extends BaseCart {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** function addToCart() 
     * for get all Package-Subscription Information 
     * return  array
     */
    public static function addToCart($id, $duration, $userId, $videoIds, $adminApproval = 0) {
        $cnt = Yii::app()->db->createCommand('select count(*) as tot from cart WHERE user_id=:user_id and package_subscription_id=:id')
                ->bindValues(array(':user_id' => $userId, ':id' => $id))
                ->queryAll();
        if ($cnt[0]['tot'])
            $result = Yii::app()->db->createCommand('update cart set duration=:duration, video_id=:videoid, is_admin_approved=:adminApproved where user_id=:userid and package_subscription_id=:id')->bindValues(array(':duration' => $duration, ':videoid' => $videoIds, ':userid' => $userId, ':id' => $id, ':adminApproved' => $adminApproval))->execute();
        else
            $result = Yii::app()->db->createCommand('insert into cart(user_id,package_subscription_id,video_id,duration,is_admin_approved) values(:userid,:id,:videoid,:duration, :adminApproved)')->bindValues(array(':userid' => $userId, ':id' => $id, ':videoid' => $videoIds, ':duration' => $duration, ':adminApproved' => $adminApproval))->execute();
    }

    /** function getCartItems() 
     * for get all cartItems
     * return  array
     */
    public static function getCartItems($userid) {
        $items = Yii::app()->db->createCommand('select c.is_admin_approved, c.duration as cart_duration, c.video_id, ps.* from cart c inner join package_subscription ps on ps.id=c.package_subscription_id where c.user_id=:userid')
                ->bindValue(':userid', $userid)
                ->queryAll();
        return $items;
    }

    /** function getAllowedCartItems() 
     * for get all allowed cartItems
     * return  array
     */
    public static function getAllowedCartItems($snUserId) {
        $items = Yii::app()->db->createCommand('select c.id as cart_id, c.is_admin_approved, c.duration as cart_duration, c.video_id, ps.* from cart c inner join package_subscription ps on ps.id=c.package_subscription_id where c.user_id=:userid AND c.is_admin_approved = 1')
                ->bindValue(':userid', $snUserId)
                ->queryAll();
        return $items;
    }

    /** function removeSelectedItems() 
     * for remove selected items 
     * @param  array     $anItemIds
     * return  boolean
     */
    public static function removeSelectedItems($anItemIds, $userid) {
        $bDeleted = Cart::model()->deleteAll('package_subscription_id IN(' . implode(',', $anItemIds) . ') and user_id=' . $userid);
        return $bDeleted;
    }

}