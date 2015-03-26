<?php
class AuthController extends DefaultController{
	public function actionLogin($phone,$password){
		$model = new LoginForm;
		$model->phone = $phone;
		$model->password = $password;
		if($model->validate() && $model->login()){
			$token = $this->generateToken();
			Yii::app()->cache->set('app_token_'.$token,Yii::app()->user->id);
			$this->renderJson(array(
				'success' => 1,
				'token' => $token
			));
			return;
		}
		$this->renderJson(array(
			'success' => 0
		));

	}

	public function generateToken()  
    {  
        $encrypt_key = md5(((float) date("YmdHis") + rand(100,999)).rand(1000,9999));  
        return $encrypt_key;  
    }  
}
