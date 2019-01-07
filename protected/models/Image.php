<?php

/**
 * This is the model class for table "genre".
 *
 * The followings are the available columns in table 'genre':
 * @property integer $id
 * @property string $name
 */
class Image extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'home_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'required'),			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, url, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Filename',
            'position' => 'Position',
            
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
        $criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
              'sort'=>array(
                'defaultOrder'=>array(
                  'position'=>false
                )
              )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Genre the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function removeSelectedItems($itemIds) {
        $bDeleted = Image::model()->deleteAll('id IN(' . implode(',', $itemIds) . ')');
        return $bDeleted;
    }
    
    public static function updateSelectedItems($itemIds,$itemLinks,$itemPos) {        
        $i=0;
        foreach ($itemIds as &$id) {                                    
            $updated = Image::model()->updateByPk($id, array(
                'imglink' => $itemLinks[$i],
                'position' => $itemPos[$i],                
            ));
            $i+=1;
        }        
        return $updated;
    }
    
}
