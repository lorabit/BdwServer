<?php
class AuthController extends DefaultController{
	public function actionLogin($code){
		$wx = new WXGzh;
		$data = $wx->get('https://api.weixin.qq.com/sns/oauth2/access_token',array(
			'appid'=>$wx->getParams('appid'),
			'secret' => $wx->getParams('secret'),
			'code' => $code,
			'grant_type' => 'authorization_code',
		));
		$data = json_decode($data);
		try{
			$openid = $data->openid;
			Yii::app()->user->setState('wxopenid',$openid);
			$user = User::model()->find('wxopenid=:openid',array('openid'=>$openid));
			if(!$user){
				$this->redirect('/gzh/auth/register');
			}else{
				$user->setState();
				$this->redirect(Yii::app()->user->returnUrl);
			}

		}catch(Exception $e){
			echo $e->getMessage;
		}
	}

	public function actionRegister(){
		if($_POST['phone']){
			$phone = $_POST['phone'];
			$password = $_POST['password'];
			$password = User::encodePassword($password);
			$user = User::model()->find('phone=:phone',array('phone'=>$phone));
			if($user){
				//关联
				if($user->password==$password){
					$user->wxopenid = Yii::app()->user->getState('wxopenid');
					$user->save();
					$user->setState();
					$this->redirect(Yii::app()->user->returnUrl);
				}else
					$msg = '密码错误';
			}else{
				//注册
				$user = new User;
				$user->phone = $phone;
				$user->password = $password;
				$user->wxopenid = Yii::app()->user->getState('wxopenid');
				$user->user_group = User::USER_GROUP_NORMAL;
				if($user->save()){
					$user->setState();
					$this->redirect(Yii::app()->user->returnUrl);
				}else
					print_r($user->getMessages());
			}

		}
		$this->render('register',array('msg'=>$msg));
	}
}