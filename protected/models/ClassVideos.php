<?php

Yii::import('application.models._base.BaseClassVideos');

class ClassVideos extends BaseClassVideos {

    public $num;
    public $video_ids;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'video' => array(self::BELONGS_TO, 'Videos', 'video_id'),
            'class' => array(self::BELONGS_TO, 'Classes', 'class_id'),
        );
    }

    /** function addUsers() 
     * for add/remove selected/unselected video ids from class.
     * @param  int     $snClassId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function addVideos($snClassId, $anVideoIds) {
        foreach ($anVideoIds as $snVideoId) {
            // FOR CHECK USER ALREADY EXISTS INTO CLASS OR NOT //
            $oCriteria = new CDbCriteria;
            $oCriteria->alias = 'cu';
            $oCriteria->condition = 'cu.class_id=:classID AND cu.video_id=:videoID';
            $oCriteria->params = array(':classID' => $snClassId, ':videoID' => $snVideoId);
            $omRecordExists = ClassVideos::model()->find($oCriteria);

            if (!$omRecordExists) {
                // FOR ADD USER UNDER CLASS //
                $oModel = new ClassVideos();
                $oModel->class_id = $snClassId;
                $oModel->video_id = $snVideoId;
                $oModel->save();
            }
        }
        // Phase-II: Commented bcoz now we don't show the already added videos into the add video list //
        // REMOVE USERS FROM CLASS WHICH ARE UNSELECTED //
        //self::removeUnselectedVideoIds($snClassId, $anVideoIds);
        return true;
    }

    /** function removeUnselectedVideoIds() 
     * for remove videos which are unselected from the class
     * @param  int     $snClassId
     * @param  array   $anVideoIds
     * return  boolean
     */
    public static function removeUnselectedVideoIds($snClassId, $anVideoIds) {
        $ssCriteria = (count($anVideoIds) > 0) ? 'video_id NOT IN(' . implode(',', $anVideoIds) . ') AND class_id = ' . $snClassId : 'class_id = ' . $snClassId;
        ClassVideos::model()->deleteAll($ssCriteria);
        return true;
    }

    /** function removeClassVideos() 
     * for remove row from class video table
     * @param  int     $snClassId
     * @param  int     $snVideoId
     * return  boolean
     */
    public static function removeClassVideos($snClassId, $snVideoId) {
        $bDeleteStatus = ClassVideos::model()->deleteAll('class_id = :classID AND video_id =:videoID', array('classID' => $snClassId, 'videoID' => $snVideoId));
        return $bDeleteStatus;
    }

}