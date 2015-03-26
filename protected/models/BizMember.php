<?php

class BizMember{

	public $userid;
	public $name;
	public $department;
	public $position;
	public $mobile;
	public $email;
	public $weixinid;
	public $extattr;
	public $avatar;
	public $status;


	public function create(){
		try{
			$wx = new WXBiz;
			$res = $wx->post('https://qyapi.weixin.qq.com/cgi-bin/user/create',json_encode($this->getArray(),JSON_UNESCAPED_UNICODE));
			// var_dump($res);
			// 		die();
			return json_decode($res)->errcode==0;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function update(){
		try{
			$wx = new WXBiz;
			$res = $wx->post('https://qyapi.weixin.qq.com/cgi-bin/user/update',json_encode($this->getArray(),JSON_UNESCAPED_UNICODE));
			return json_decode($res)->errcode==0;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function delete(){
		try{
			$wx = new WXBiz;
			$res = $wx->get('https://qyapi.weixin.qq.com/cgi-bin/user/delete',array('userid'=>$this->userid));
			return json_decode($res)->errcode==0;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function get(){
		try{
			$wx = new WXBiz;
			$res = $wx->get('https://qyapi.weixin.qq.com/cgi-bin/user/get',array('userid'=>$this->userid));
			$arr = json_decode($res,true);
			
			if($arr['errcode']!==0)
				return false;

			$this->setArray($arr);
			return true;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function invite(){
		try{
			$wx = new WXBiz;
			$res = $wx->post('https://qyapi.weixin.qq.com/cgi-bin/user/send',json_encode(array(
				'userid'=>$this->userid,
				'invite_tips' => '车安安邀请您关注！'
			),JSON_UNESCAPED_UNICODE));
			return json_decode($res)->errcode==0;
		}
		catch(Exception $e){
			return false;
		}
	}


	//与系统数据库同步
	public function sync(){
		$user = User::model()->find('wxqyid=:wxqyid',array('wxqyid'=>$this->userid));
		if($user){
			$user->wxstatus = $this->status;
			$user->wxavatar = $this->avatar;
			$user->phone = $this->mobile;
			$user->wxid = $this->weixinid;
			$user->save();
		}
	}

	public function getArray(){
		return array(
			'userid'=>$this->userid,
			'name'=>$this->name,
			'department' => $this->department,
			'position' => $this->position,
			'mobile' => $this->mobile,
			'email' => $this->email,
			'weixinid' => $this->weixinid,
			'extattr' => $this->extattr,
		);
	}

	public function setArray($arr){
		$property = array(
			'userid','name','department','position','mobile','email','weixinid','avatar','status','extattr'
		);
		foreach ($property as $value) {
			$this->$value = $arr[$value];
		}
	}
}