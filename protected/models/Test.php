<?php

/**
 * This is the model class for table "test".
 *
 * The followings are the available columns in table 'test':
 * @property string $id
 * @property string $testee_id
 * @property string $tester_id
 * @property string $created_at
 * @property string $raw_answer
 * @property string $province
 * @property string $city
 * @property double $longitutde
 * @property double $latitude
 */
class Test extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'test';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('testee_id, tester_id, created_at, raw_answer, province, city, longitutde, latitude', 'required'),
			array('longitutde, latitude', 'numerical'),
			array('testee_id, tester_id', 'length', 'max'=>20),
			array('province, city', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, testee_id, tester_id, created_at, raw_answer, province, city, longitutde, latitude', 'safe', 'on'=>'search'),
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
            'testee' => array(self::BELONGS_TO, 'Testee', 'testee_id'),
            'tester' => array(self::BELONGS_TO, 'User', 'tester_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'testee_id' => 'Testee',
			'tester_id' => 'Tester',
			'created_at' => 'Created At',
			'raw_answer' => 'Raw Answer',
			'province' => 'Province',
			'city' => 'City',
			'longitutde' => 'Longitutde',
			'latitude' => 'Latitude',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('testee_id',$this->testee_id,true);
		$criteria->compare('tester_id',$this->tester_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('raw_answer',$this->raw_answer,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('longitutde',$this->longitutde);
		$criteria->compare('latitude',$this->latitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Test the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
    {
        if($this->isNewRecord)
        {
            $this->created_at = date(Yii::app()->controller->module->dateFormat);
        }
        return parent::beforeSave();
    }

}
