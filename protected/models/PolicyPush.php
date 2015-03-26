<?php

/**
 * This is the model class for table "PolicyPush".
 *
 * The followings are the available columns in table 'PolicyPush':
 * @property string $id
 * @property string $policy_id
 * @property string $created_at
 * @property string $store_id
 * @property integer $status
 */
class PolicyPush extends CActiveRecord
{

	CONST STATUS_SENT = 200;
	CONST STATUS_QUOTED = 300;
	CONST STATUS_PAID = 400;
	CONST STATUS_DONE = 500;
	CONST STATUS_COMMENTED = 600;
	CONST STATUS_CANCELED = 1000;

	public function getStatusLabel($all = false){
		if($all == false)
			return $this->getStatusLabel(true)[$this->status];
		return array(
			self::STATUS_SENT => '已推送',
			self::STATUS_QUOTED => '已定价',
			self::STATUS_PAID => '已支付',
			self::STATUS_DONE => '已处理',
			self::STATUS_COMMENTED => '已评价',
			self::STATUS_CANCELED => '已取消',
		);
	}

	public function send(){
		$send_to = User::model()->findAll('store_id=:store_id',array('store_id'=>$this->store_id));
		$photo = Photo::model()->find('policy_id='.$this->policy_id);
		if($photo){
			$picurl = $photo->getUrl();
		}
		foreach ($send_to as $user) {
			$msg = new Message;
			$msg->to = $user->id;
			$msg->type = "news";
			$msg->articles = array(
				array(
					'title' => '新订单 - 赶快抢单！',
					'description' => $this->policy->comment,
					'url' => Yii::app()->params['url'].'/wxh5/policy/view?id='.$this->id,
					'picurl' => $picurl,
				),
			);
			$msg->send();
		}
		$this->status = self::STATUS_SENT;
		return $this->save();
	}

	public function notifyQuote(){
		if(!empty($this->policy->user->wxopenid)){
			$wx = new WXGzh;
			$wx->post('https://api.weixin.qq.com/cgi-bin/message/template/send',json_encode(array(
				'touser' => $this->policy->user->wxopenid,
				'template_id' => 'LT3FogSqPuKl5o5UDC_ZcxbJf5FPr6clR5DGHBuWT5Q',
				'url' => Yii::app()->params['url'].'/gzh/bid/view?id='.$this->id,
				'topcolor' => '#8BBC3A',
				'data' => array(
					'first' => array(
						'value' => $this->store->name.' 报价啦',
						'color' => '#333333'
					),
					'keyword1' => array(
						'value' => '维修费 '.$this->price.' 元',
						'color' => '#FF4400'
					),
					'keyword2' => array(
						'value' => '商家竞价中',
						'color' => '#333333'
					),
					'remark' => array(
						'value' => '点击查看详情',
						'color' => '#333333'
					),

				)
			)));
		}
	}


	public function notifyDone(){
		if(!empty($this->policy->user->wxopenid)){
			$wx = new WXGzh;
			$wx->post('https://api.weixin.qq.com/cgi-bin/message/template/send',json_encode(array(
				'touser' => $this->policy->user->wxopenid,
				'template_id' => 'LT3FogSqPuKl5o5UDC_ZcxbJf5FPr6clR5DGHBuWT5Q',
				'url' => Yii::app()->params['url'].'/gzh/bid/view?id='.$this->id,
				'topcolor' => '#8BBC3A',
				'data' => array(
					'first' => array(
						'value' => $this->store->name.' 叫你取车啦',
						'color' => '#333333'
					),
					'keyword1' => array(
						'value' => '您获得了价值 '.($this->policy->quote-$this->price).' 元的代金券',
						'color' => '#FF4400'
					),
					'keyword2' => array(
						'value' => '服务完成',
						'color' => '#333333'
					),
					'remark' => array(
						'value' => '点击评价',
						'color' => '#333333'
					),

				)
			)));
		}
	}

	public function notifyPayment(){
    	$send_to = User::model()->findAll('store_id=:store_id',array('store_id'=>$this->store_id));
		$photo = Photo::model()->find('policy_id='.$this->policy_id);
		if($photo){
			$picurl = $photo->getUrl();
		}
		foreach ($send_to as $user) {
			$msg = new Message;
			$msg->to = $user->id;
			$msg->type = "news";
			$msg->articles = array(
				array(
					'title' => '用户已支付！',
					'description' => '用户选择了您的报价并支付了定损额 '.$this->policy->quote.' 元。',
					'url' => Yii::app()->params['url'].'/wxh5/policy/view?id='.$this->id,
					'picurl' => $picurl,
				),
			);
			$msg->send();
		}
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PolicyPush';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, time, pickup, rate', 'numerical', 'integerOnly'=>true),
			array('policy_id, store_id', 'length', 'max'=>20),
			array('created_at, comment, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, policy_id, created_at, store_id, status, price, time, pickup', 'safe', 'on'=>'search'),
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
			'policy_id' => 'Policy',
			'created_at' => 'Created At',
			'store_id' => 'Store',
			'status' => 'Status',
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
	public function search($criteria = null,$order = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		if($criteria == null)
			$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('policy_id',$this->policy_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('status',$this->status);

		$sort = new CSort();
        $sort->defaultOrder = 't.id DESC';
        if($order=='time')
        	$sort->defaultOrder = 't.updated_at desc';
        if($order=='price')
        	$sort->defaultOrder = 't.price asc';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>$sort
        ));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PolicyPush the static model class
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
        $this->updated_at = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }

    //支付完成之后调用该函数
    public function pay(){
    	if($this->status!=self::STATUS_QUOTED) return false;
    	$this->status = self::STATUS_PAID;
    	$this->save();
    	$this->store->addUserBalance($this->policy->quote);
    	$this->store->freezeUserBalance($this->policy->quote);
    	$this->policy->store_id = $this->store_id;
    	$this->policy->status = Policy::STATUS_SERVING;
    	$this->policy->save();
    	$this->notifyPayment();
    	return true;
    }

    public function finish(){

    }
}
