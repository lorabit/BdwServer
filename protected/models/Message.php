<?php

/**
 * This is the model class for table "Message".
 *
 * The followings are the available columns in table 'Message':
 * @property string $id
 * @property string $from
 * @property string $to
 * @property string $type
 * @property string $title
 * @property string $content
 * @property string $created_at
 */
class Message extends CActiveRecord
{
	CONST STATUS_SUCCESS = 200;
	CONST STATUS_FAILED = 400;

	public $articles;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to', 'length', 'max'=>20),
			array('type, title', 'length', 'max'=>45),
			array('content, created_at, status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from, to, type, title, content, created_at', 'safe', 'on'=>'search'),
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
			'to_user' => array(self::BELONGS_TO, 'User', 'to'),
			'from_user' => array(self::BELONGS_TO, 'User', 'from'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from' => 'From',
			'to' => 'To',
			'type' => 'Type',
			'title' => 'Title',
			'content' => 'Content',
			'created_at' => 'Created At',
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
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
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
    public function wxFormat(){
    	$obj = array(
    		'touser'=>$this->to_user->wxqyid,
    		'msgtype' => $this->type,
    		'agentid' => 1,
    		'safe' => 0,
    	);
    	if($this->type=='text'){
    		$obj['text'] = array('content'=>$this->content);
    	}
    	if($this->type=='news'){
    		$obj['news'] = array('articles'=>$this->articles);
    		$this->content = json_encode($this->articles,JSON_UNESCAPED_UNICODE);
    		$this->save();
    	}
    	return json_encode($obj,JSON_UNESCAPED_UNICODE);
    }

    public function send(){
    	if(empty($this->to_user->wxqyid))
    		return false;
    	$wx = new WXBiz;
    	if($res = $wx->post('https://qyapi.weixin.qq.com/cgi-bin/message/send',$this->wxFormat())){
    		$res = json_decode($res);
    		if($res->errcode==0){
    			$this->status = self::STATUS_SUCCESS;
    			$this->save();
    			return true;
    		}
    		else{
    			$this->status = self::STATUS_FAILED;
    			$this->save();
    			$this->addError('content',$res->errmsg);
    			return false;
    		}
    	}
    		
    }
}
