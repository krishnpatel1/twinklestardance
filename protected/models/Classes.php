<?php

Yii::import('application.models._base.BaseClasses');

class Classes extends BaseClasses {

    public $num;
    public $user_video_id;
    public $video_id;
    public $title;
    public $image_url;
    public $iframe_code;
    public $static_image_url;
    public $description;
    public $from_start_date;
    public $to_start_date;
    public $genre_name;
    public $category_name;
    public $age_range_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('name,start_time,days_of_week,start_date,end_date', 'required'),
            array('end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>', 'allowEmpty' => false, 'message' => '{attribute} must be greater than "{compareValue}".'),
            array('status, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('name, image_url, static_image_url, token', 'length', 'max' => 255),
            array('days_of_week, created_at, updated_at', 'safe'),
            array('name, image_url, start_time, days_of_week, start_date, end_date, token, status, created_at, created_by, updated_at, updated_by', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, name, image_url, start_time, days_of_week, start_date, end_date, token, status, created_at, created_by, updated_at, updated_by,from_start_date,to_start_date', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('app', 'Name'),
            'image_url' => Yii::t('app', 'Image'),
            'start_time' => Yii::t('app', 'Start Time'),
            'days_of_week' => Yii::t('app', 'Days Of Week'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'token' => Yii::t('app', 'Class Link'),
            'static_image_url' => 'Image URL',
        );
    }

    /** function getAllClassesCreateByUser()
     * for get classes as per user role wise.
     * @param  int     $snUserId
     * @param  boolean $bCriteria
     * return  object
     */
    public static function getAllClassesCreateByUser($snUserId, $bCriteria = false,$to_start_date="",$to_end_date="",$from_start_date="",$from_end_date="",$name="") {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'c.*,(select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 'c';


        if (!AdminModule::isStudioAdmin()) {
            $oCriteria->join = 'INNER JOIN class_users cu ON cu.class_id=c.id';
            $oCriteria->condition = "cu.user_id = :dancerOrInstructorID AND DATE_FORMAT(c.end_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
            $oCriteria->params = array(':dancerOrInstructorID' => $snUserId);
        } else {
            $oCriteria->condition = 'c.created_by = :studioID';
            $oCriteria->params = array(':studioID' => $snUserId);
        }
        
        if(!empty($from_start_date) && empty($to_start_date))
        {
            $oCriteria->addCondition("start_date >= '$from_start_date'");  // date is database date column field
        }elseif(!empty($to_start_date) && empty($from_start_date))
        {
            $oCriteria->addCondition("start_date <= '$to_start_date'");
        }elseif(!empty($to_start_date) && !empty($from_start_date))
        {
            $oCriteria->addCondition("start_date  >= '$from_start_date' and start_date <= '$to_start_date'");
        }
        if(!empty($from_end_date) && empty($to_end_date))
        {
            $oCriteria->addCondition("end_date >= '$from_end_date'");  // date is database date column field
        }elseif(!empty($to_end_date) && empty($from_end_date))
        {
            $oCriteria->addCondition("end_date <= '$to_end_date'");
        }elseif(!empty($to_end_date) && !empty($from_end_date))
        {
            $oCriteria->addCondition("end_date  >= '$from_end_date' and end_date <= '$to_end_date'");
        }
        
        if(!empty($name)){
            //$oCriteria->addCondition("name LIKE :name");
            $oCriteria->addCondition("name LIKE :name");        
            $oCriteria->params[':name'] ="%$name%";        
        }
        
        // FOR RETURN ONLY CRITERIA OBJECT //
        if ($bCriteria)
            return $oCriteria;

        // FOR RETURN CRITERIA RESULTS //
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResults = self::model()->findAll();

        return $omResults;
    }

    /** function getClassVideos()
     * for get class video.
     * @param  int     $snClassId
     * return  object
     */
    public static function getClassVideos($snClassId, $bCriteria = false,$title="",$genre="",$category="",$age="") {
        $oCriteria = new CDbCriteria;
        $oCriteria->select = 'DISTINCT v.id as video_id,v.title,v.image_url,v.iframe_code,v.description, c.id, g.name as genre_name, cat.name as category_name, age.range as age_range_name, (select @n := @n + 1 from (select @n:=0) initvar) as num';
        $oCriteria->alias = 'c';
        $oCriteria->join = "INNER JOIN class_videos cs ON c.id = cs.class_id";
        $oCriteria->join .= " INNER JOIN videos v ON v.id = cs.video_id";
        $oCriteria->join .= " LEFT JOIN genre g ON v.genre = g.id";
        $oCriteria->join .= " LEFT JOIN category cat ON v.category = cat.id";
        $oCriteria->join .= " LEFT JOIN age_range age ON v.age_range = age.id";
        $oCriteria->condition = 'c.id=:classID';
        if (AdminModule::isDancer()) {
            $snDancerId = Yii::app()->admin->id;
            $oCriteria->select .= ", uvt.video_id as user_video_id";
            //$oCriteria->join .= " LEFT JOIN user_videos_transaction uvt ON cs.video_id1 = uvt.video_id AND uvt.user_id = $snDancerId AND uvt.user_id IN(SELECT o.user_id FROM orders o INNER JOIN order_details od ON o.id = od.order_id WHERE o.payment_status = 1 AND DATE_FORMAT(od.expiry_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d'))";
            $oCriteria->join .= " LEFT JOIN user_videos_transaction uvt ON cs.video_id = uvt.video_id AND uvt.user_id = $snDancerId AND uvt.user_id IN(SELECT o.user_id FROM orders o WHERE o.payment_status = 1)";
        }

        if (AdminModule::isInstructor()) {

            // FOR GET CLASS VIDEOS //
            $oCriteria1 = new CDbCriteria;
            $oCriteria1->select = 'GROUP_CONCAT(cv.video_id) as video_ids';
            $oCriteria1->alias = 'cv';
            $oCriteria1->condition = 'cv.class_id = ' . $snClassId;
            $oResult1 = ClassVideos::model()->find($oCriteria1);

            // FOR GET SUB IDS FROM CLASS VIDEOS //
            $anPackageSubIds = array();
            if ($oResult1) {

                // FOR GET STUDIO DETAILS //
                $omStudioInfo = Users::getStudioDetailsRelatedWithInstructor(Yii::app()->admin->id);
                $snStudioId = $omStudioInfo->parent_id;
                $snVideoIds = $oResult1->video_ids;

                // FOR GET STUDIO PURCHASED PACKAGE / SUBSCRIPTION IDs //
                if (count($snVideoIds) > 0) {
                    $oSubCriteria = new CDbCriteria;
                    $oSubCriteria->select = 'upv.*';
                    $oSubCriteria->alias = 'upv';
                    $oSubCriteria->condition = "upv.user_id = $snStudioId AND upv.video_id IN ($snVideoIds)";
                    $omResults = UserPurchasedVideos::model()->findAll($oSubCriteria);
                    if ($omResults) {
                        foreach ($omResults as $omResultsSet) {

                            $snPackageSubId = ($omResultsSet->package_id != "") ? $omResultsSet->package_id : $omResultsSet->subscription_id;
                            $omValidSubscription = Orders::checkIsUserPackageSubHasBeenExpired($snPackageSubId, $snStudioId);
                            if ($omValidSubscription)
                                $anPackageSubIds[] = ($omResultsSet->package_id != "") ? $omResultsSet->package_id : $omResultsSet->subscription_id;
                        }
                    }
                }
            }

            // FOR THE CHECK CLASS VIDEO'S PACKAGE/SUBSCRIPTION IS NOT BEING EXPIRED //
            $anUniquePackageSubIds = array_unique($anPackageSubIds);
            if (count($anUniquePackageSubIds) > 0) {
                $snPackageSubIds = implode(',', $anUniquePackageSubIds);
                $oCriteria->join .= ' INNER JOIN user_purchased_videos upv ON upv.video_id = cs.video_id';
                $oCriteria->addCondition("IF(upv.package_id IS NOT NULL, upv.package_id, upv.subscription_id) IN ($snPackageSubIds)");
                $oCriteria->addCondition("upv.user_id = $snStudioId");

                ////////////////////////////////////////////////////////////////////////////////////////
                // FOR CHECK AND GET DECLIENED PAYMENT SUBSCRIPTION IDS //
                //$smPackageSubIds = Orders::getDeclinePaymentsSubscriptionIds($snStudioId);
                //if ($smPackageSubIds != "")
                //    $oCriteria->addCondition("IF(upv.package_id IS NOT NULL, upv.package_id, upv.subscription_id) NOT IN ($smPackageSubIds)");
                ////////////////////////////////////////////////////////////////////////////////////////
            } else {
                // FOR USER CAN SEE ANY VIDEOS //
                $oCriteria->addCondition("0");
            }
        }

        $oCriteria->params = array(':classID' => $snClassId);
        
        if($title!=""){
            $oCriteria->addCondition("v.title LIKE :title");        
            $oCriteria->params[':title'] ="%$title%";
        }
        if($genre!=""){
            $oCriteria->addCondition("v.genre = :genre");        
            $oCriteria->params[':genre'] ="$genre";
        }
        if($category!=""){
            $oCriteria->addCondition("v.category = :category");        
            $oCriteria->params[':category'] ="$category";
        }
        if($age!=""){
            $oCriteria->addCondition("v.age_range = :age");        
            $oCriteria->params[':age'] ="$age";
        }
        

        if ($bCriteria) {
            return $oCriteria;
        }
        self::model()->getDbCriteria()->mergeWith($oCriteria);
        $omResults = self::model()->findAll();

        return $omResults;
    }

    /** function checkIsClassEnd()
     * for check class end date.
     * @param  int     $snClassId
     * return  object
     */
    public static function checkIsClassEnd($snClassId) {
        $oCriteria = new CDbCriteria;
        $oCriteria->alias = 'c';
        $oCriteria->condition = "c.id = :snClassID AND DATE_FORMAT(c.end_date,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
        $oCriteria->params = array(':snClassID' => $snClassId);

        $omResultSet = self::model()->find($oCriteria);
        return $omResultSet;
    }

    /** function beforeSave() 
     * override parent method
     */
    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->admin->id;
        }

        $this->updated_by = Yii::app()->admin->id;
        $this->updated_at = new CDbExpression('NOW()');

        return parent::beforeSave();
    }

}