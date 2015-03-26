<?php

/**
 * This is the model class for table "Policy".
 *
 * The followings are the available columns in table 'Policy':
 * @property string $id
 * @property string $uid
 * @property string $created_at
 * @property string $comment
 * @property double $latitude
 * @property double $longitude
 * @property string $updated_at
 */
class Policy extends CActiveRecord
{

	CONST STATUS_OPEN = 0;
	CONST STATUS_CLOSED = 400;
	CONST STATUS_PAID = 100;
	CONST STATUS_SERVING = 200;
	CONST STATUS_REMOVED = -1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Policy';
	}

	public static function getStatusLabel($status=null){
		if($status==null)
			return array(
				self::STATUS_CLOSED => '已关闭',
				self::STATUS_OPEN => '竞价中',
				self::STATUS_REMOVED => '已删除',
				self::STATUS_PAID => '已支付',
				self::STATUS_SERVING => '服务中',
			);
		else
			return self::getStatusLabel()[$status];
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('latitude, longitude, store_id, quote', 'numerical'),
			array('user_id', 'length', 'max'=>20),
			array('created_at, comment, updated_at,car_model', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, created_at, comment, latitude, longitude, updated_at', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => '发起用户',
			'created_at' => 'Created At',
			'comment' => '备注',
			'store_id' => '关联店铺',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'updated_at' => 'Updated At',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('updated_at',$this->updated_at,true);

		$sort = new CSort();
        $sort->defaultOrder = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>$sort
        ));
	}

	public function publish(){
		$stores = Store::model()->findAll();
		$count = 0;
		foreach ($stores as $store) {
			$push = new PolicyPush;
			$push->policy_id = $this->id;
			$push->store_id = $store->id;
			if($push->save()){
				if($push->send()){
					$count ++;
				}
			}
		}
		return $count;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Policy the static model class
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

    public function getIconUrl(){
    	$img =  Photo::model()->find('policy_id='.$this->id);
    	if($img)
    		return $img->getUrl();
    	return '/themes/classic/assets/images/image.jpg';
    }
}
