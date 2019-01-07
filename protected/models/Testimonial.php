<?php

/**
 * This is the model class for table "testimonial".
 *
 * The followings are the available columns in table 'testimonial':
 * @property integer $id
 * @property string $name
 */
class Testimonial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'testimonial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name,institution,position', 'length', 'max'=>250),
            array('name,institution,position,text,sysposition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,institution,position', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
            'institution' => 'Institution',
            'position' => 'Position',
            'text' => 'Testimonial',
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
		$criteria->compare('name',$this->name,true);
        $criteria->compare('institution',$this->institution,true);
        $criteria->compare('position',$this->position,true);
        $criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Testimonial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function removeSelectedItems($itemIds) {
        $bDeleted = Testimonial::model()->deleteAll('id IN(' . implode(',', $itemIds) . ')');
        return $bDeleted;
    }
    
     public static function updateSelectedItems($itemIds,$itemPos) {        
        $i=0;
        foreach ($itemIds as &$id) {                                    
            $updated = Testimonial::model()->updateByPk($id, array(                
                'sysposition' => $itemPos[$i],                
            ));
            $i+=1;
        }        
        return $updated;
    }
    
}
