<?php

Yii::import('application.models._base.BaseEmailFormat');

class EmailFormat extends BaseEmailFormat
{
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'file_name' => Yii::t('app', 'File Name'),
            'last_updated' => Yii::t('app', 'Last Updated'),
            'status' => Yii::t('app', 'Status'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('last_updated', $this->last_updated, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
        ));
    }

    public static function getEmailTitleLabel($title){
        $title_name = '';
        $type_arr = array(
                        0=>'Visitor Login',
                        1=>'Individual',
                        2=>'Group',                        
                    );

        foreach($type_arr AS $key => $value){
            //echo $title.'||'.intval($title).' == '.$key.'||'.intval($key).'===='.$value.'<br />';
            if((intval($title) == intval($key))){
                $title_name = $value;
                //return $value;
            }
        }
        return $title_name;
    }

    protected function afterFind ()
    {
        // convert to display format
        $this->last_updated = strtotime ($this->last_updated);
        $this->last_updated = date('Y-m-d', $this->last_updated);
        parent::afterFind ();
    }
    
    public static function label($n = 1) {
            return Yii::t('app', 'Email', $n);
    }
    
    public function rules() {
        return array(
            array('title, subject, body', 'required'),
            array('title, status', 'length', 'max'=>1),
            array('subject, file_name', 'length', 'max'=>255),
            array('status,file_name', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, title, subject, body, file_name, last_updated, status', 'safe', 'on'=>'search'),
        );
    }
}