<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $realname
 * @property string $phone
 * @property string $password
 * @property string $title
 * @property string $org_id
 * @property string $created_at
 * @property string $source_user
 * @property string $province
 * @property string $city
 * @property integer $user_group
 */
class User extends CActiveRecord
{

	CONST USER_GROUP_NORMAL = 0; //预留的普通用户
	CONST USER_GROUP_CERTIFIED = 1000; //认证账户，由中心管理员添加的护士、养老院护理人员等
	CONST USER_GROUP_CENTER_MANAGER = 2000; //中心管理员
	CONST USER_GROUP_AREA_MANAGER = 5000; //地区推广管理员
	CONST USER_GROUP_SYSTEM = 10000; //系统管理员

	public static function getUserGroupLabel($user_group=null){
		if($user_group==null)
			return array(
				self::USER_GROUP_NORMAL => '普通用户',
				self::USER_GROUP_CERTIFIED => '认证用户',
				self::USER_GROUP_CENTER_MANAGER => '中心管理员',
				self::USER_GROUP_AREA_MANAGER => '地区管理员',
				self::USER_GROUP_SYSTEM => '系统管理员',
			);
		else
			return self::getUserGroupLabel()[$user_group];
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phone, password, realname', 'required'),
			array('user_group, created_by', 'numerical', 'integerOnly'=>true),
			array('realname, phone, password, title, province, city, center_name', 'length', 'max'=>45),
			array('org_id, source_user', 'length', 'max'=>20),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, realname, phone, password, title, org_id, created_at, source_user, province, city, user_group', 'safe', 'on'=>'search'),
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
			'realname' => '姓名',
			'phone' => '手机号',
			'password' => '密码',
			'title' => '职称',
			'org_id' => 'Org',
			'created_at' => 'Created At',
			'source_user' => 'Source User',
			'province' => '省份',
			'city' => '城市',
			'user_group' => '用户分组',
			'center_name' => '中心名称',
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
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('org_id',$this->org_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('source_user',$this->source_user,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('user_group',$this->user_group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->phone,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	public static function encodePassword($pwd){
		return md5($pwd);
	}

	public function setState(){
		Yii::app()->user->setState('id',$this->id);
		Yii::app()->user->setState('realname',$this->realname);
		Yii::app()->user->setState('phone',$this->phone);
		Yii::app()->user->setState('user_group',$this->user_group);
	}

	public function validate(){
		if(!empty($this->phone)){
			$user = self::model()->find('phone=:phone',array('phone'=>$this->phone));
			if($user)
			if($user->id!=$this->id){
				$this->addError('phone','手机号码 已注册！');
				return false;
			}
		}
		return parent::validate();
	}

	public function beforeSave() 
    {
        if($this->isNewRecord)
        {
        	$this->created_by = Yii::app()->user->id;
            $this->created_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave();
    }
}
