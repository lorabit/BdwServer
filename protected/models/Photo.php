<?php

/**
 * This is the model class for table "Photo".
 *
 * The followings are the available columns in table 'Photo':
 * @property string $id
 * @property string $user_id
 * @property string $media_id
 * @property string $created_at
 * @property string $policy_id
 */
class Photo extends CActiveRecord
{

	CONST STATUS_REMOVED = -1;
	CONST STATUS_NEW = 0;
	CONST STATUS_UPLOADED = 200;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, policy_id', 'length', 'max'=>20),
			array('media_id', 'length', 'max'=>256),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, media_id, created_at, policy_id', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'media_id' => 'Media',
			'created_at' => 'Created At',
			'policy_id' => 'Policy',
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
		$criteria->compare('media_id',$this->media_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('policy_id',$this->policy_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Photo the static model class
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

    public function getUrl(){
    	return Yii::app()->params['url'].'public/photo/id/'.$this->id;
    }

    public function sendFile(){
    	$path = Yii::app()->params['data_path'].'photo/'.$this->id;
        Yii::app()->request->sendFile('policy.jpg',file_get_contents($path));
    }

    public function downloadMedia(){
		$save_path = Yii::app()->params['data_path'].'photo/';
		$new_file_name = $this->id;
		$file_path = $save_path . $new_file_name;
		$wx = new WXGzh;
		$data = $wx->get('http://file.api.weixin.qq.com/cgi-bin/media/get',array(
			'media_id' => $this->media_id
		));
		file_put_contents($file_path, $data);
		@chmod($file_path, 0644);
		$this->status = Photo::STATUS_UPLOADED;
		$this->save();
    }

}
