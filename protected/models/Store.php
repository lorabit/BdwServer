<?php

/**
 * This is the model class for table "Store".
 *
 * The followings are the available columns in table 'Store':
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $description
 * @property string $icon
 * @property string $created_at
 * @property string $updated_at
 */
class Store extends CActiveRecord
{
	CONST STATUS_REMOVED = -1;
	CONST STATUS_OPEN = 200;
	CONST STATUS_CLOSED = 400;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Store';
	}

	public static function getStatusLabel($status=null){
		if($status==null)
			return array(
				self::STATUS_CLOSED => '已关闭',
				self::STATUS_OPEN => '营业中',
				self::STATUS_REMOVED => '已删除',
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
			array('status, name, description', 'required'),
			array('status, user_id,comment_good, comment_bad', 'numerical', 'integerOnly'=>true),
			array('fix_time', 'numerical'),
			array('name, address, phone,service,longitude,latitude', 'length', 'max'=>45),
			array('icon', 'length', 'max'=>255),
			array('description, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, status, description, icon, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'name' => '店名',
			'status' => '状态',
			'description' => '店铺描述',
			'icon' => '图标',
			'user_id' => '店长',
			'created_at' => '创建时间',
			'updated_at' => '更新时间',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Store the static model class
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

    public function getGoodRate(){
    	$total = $this->comment_bad+$this->comment_good;
    	if($total == 0) return '100%';
    	return sprintf('%2f',$this->comment_good/$total).'%';
    }

    public function addUserBalance($balance,$user_id = null){
    	if($user_id == null)
    		$user_id = Yii::app()->user->id;
    	$model = StoreCoupon::model()->find('user_id=:user_id and store_id = :store_id',array(
    		'user_id' => $user_id,
    		'store_id' => $this->id
    	));
    	if(empty($model)){
    		$model = new StoreCoupon;
    		$model->store_id = $this->id;
    		$model->user_id = $user_id;
  			$model->balance = 0;
    	}
    	$model->balance = $model->balance  + $balance;
    	return $model->save();
    }

    public function freezeUserBalance($balance,$user_id = null){
    	if($user_id == null)
    		$user_id = Yii::app()->user->id;
    	$model = StoreCoupon::model()->find('user_id=:user_id and store_id = :store_id',array(
    		'user_id' => $user_id,
    		'store_id' => $this->id
    	));
    	if($model->balance<$balance) return false;
    	$model->balance = $model->balance - $balance;
    	$model->frozen = $model->frozen + $balance;
    	return $model->save();
    }

    public function unfreezeUserBalance($user_id = null){
    	if($user_id == null)
    		$user_id = Yii::app()->user->id;
    	$model = StoreCoupon::model()->find('user_id=:user_id and store_id = :store_id',array(
    		'user_id' => $user_id,
    		'store_id' => $this->id
    	));
    	if($model->frozen<=0) return false;
    	$model->balance = $model->balance + $model->frozen;
    	$model->frozen = 0;
    	return $model->save();
    }

    public function finalizeDeal($balance,$user_id = null){
    	if($user_id == null)
    		$user_id = Yii::app()->user->id;
    	$model = StoreCoupon::model()->find('user_id=:user_id and store_id = :store_id',array(
    		'user_id' => $user_id,
    		'store_id' => $this->id
    	));
    	if($model->frozen<$balance) return false;
    	$model->frozen = $model->frozen - $balance;
    	if($model->save()){
			$cash = new Cash;
			$cash->user_id = $user_id;
			$cash->store_id = $this->id;
			$cash->rate = $balance;
			$cash->created_at = date('Y-m-d H:i:s');
			// $cash->policy_id = $
			if($cash->save()){
				return true;
			}else{
				var_dump($balance,$cash->getErrors());
				die();
			}

    	}
    }

    
}
