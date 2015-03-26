<?php

/**
 * This is the model class for table "Cash".
 *
 * The followings are the available columns in table 'Cash':
 * @property string $id
 * @property string $user_id
 * @property string $store_id
 * @property integer $rate
 * @property string $policy_id
 * @property string $created_at
 * @property string $comment
 */
class Cash extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Cash';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, store_id, rate, created_at', 'required'),
			array('rate', 'numerical', 'integerOnly'=>true),
			array('user_id, store_id, policy_id', 'length', 'max'=>20),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, store_id, rate, policy_id, created_at, comment', 'safe', 'on'=>'search'),
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
			'policy' => array(self::BELONGS_TO, 'Policy', 'policy_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'store_id' => 'Store',
			'rate' => 'Rate',
			'policy_id' => 'Policy',
			'created_at' => 'Datetime',
			'comment' => 'Comment',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('policy_id',$this->policy_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cash the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() 
    {
        if($this->isNewRecord)
        {
            $this->created_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave();
    }
}
