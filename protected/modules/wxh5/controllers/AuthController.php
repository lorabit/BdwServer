<?php

class AuthController extends DefaultController{
	
	public function actionLogin($code){

		$wx = new WXBiz;
		$data = $wx->get('https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo',array(
			'code'=>$code,
			'agentid'=>1,
		));
		$data = json_decode($data);
		if(!$data->UserId){
			$this->renderText('接口异常！');
			return;
		}
		$user = User::model()->find('wxqyid=:wxqyid',array('wxqyid'=>$data->UserId));
		if(!$user){
			$user = new User;
			$user->wxqyid = $data->UserId;
			$user->createWx();
		}
		$identity = new UserIdentity($user->email,'');
		$duration=3600*24*30; // 30 days
		Yii::app()->user->login($identity,$duration);
		Yii::app()->user->setState('email',$user->email);
		Yii::app()->user->setState('id',$user->id);
		Yii::app()->user->setState('wxqyid',$user->wxqyid);
		Yii::app()->user->setState('user_group',$user->user_group);
		Yii::app()->user->setState('store_id',$user->store_id);
		Yii::log(Yii::app()->user->returnUrl,'error','returnUrl - wxh5 - login');
		$this->redirect(Yii::app()->user->returnUrl);
	}
}