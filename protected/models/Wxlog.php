<?php

/**
 * This is the model class for table "Wxlog".
 *
 * The followings are the available columns in table 'Wxlog':
 * @property string $id
 * @property string $type
 * @property string $body
 * @property string $userid
 * @property string $created_at
 */
class Wxlog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Wxlog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'length', 'max'=>20),
			array('type, userid', 'length', 'max'=>45),
			array('body, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, body, userid, created_at', 'safe', 'on'=>'search'),
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
			'type' => '类型',
			'body' => 'Body',
			'userid' => 'Userid',
			'created_at' => '时间',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('created_at',$this->created_at,true);

		$sort = new CSort();
        $sort->defaultOrder = 't.id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

            'sort' => $sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wxlog the static model class
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