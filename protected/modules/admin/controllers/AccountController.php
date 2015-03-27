<?php

class AccountController extends DefaultController
{
	public function actionCreate()
	{
		$user = new User;
		$msg = "";
		if(isset($_POST['User'])){
			$user->attributes = $_POST['User'];
			if(empty($user->email)){
				$user->addError('email','Email 不能为空.');
			}
			if(empty($user->password)){
				$user->addError('password','密码 不能为空.');
			}
			if($user->validate()){
				$user->password = md5($user->password);
				if($user->save()){
					$msg = '创建成功！';
					$this->redirect('update?id='.$user->id);
				}else{
					$msg = '创建失败！';
				}
			}else{
				$msg = '创建失败！';
			}
		}
		$this->render('_form',array('model'=>$user,'msg'=>$msg));
	}

	public function actionIndex(){
		$model = new User();
        $model->unsetAttributes();
        if(isset($_REQUEST['User']))
        {
            $model->setAttributes($_REQUEST['User']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

	public function actionUpdate(){
		$user = $this->loadModel('User');
		$msg = "";
		$old_password = $user->password;
		if(isset($_POST['User'])){
			$user->attributes = $_POST['User'];
			if(!empty($user->password)){
				$user->password = md5($user->password);
			}else{
				$user->password = $old_password;
			}
			if($user->validate()){
				if($user->save()){
					$msg = '保存成功！';
				}else{
					$msg = '保存失败！';
				}
			}else{
				$msg = '保存失败！';
			}
		}
		unset($user->password);
		$this->render('_form',array('model'=>$user,'msg'=>$msg));
	}

	public function actionSend(){
		$user = $this->loadModel('User');
		$msg = new Message;
		if(isset($_POST['Message'])){
			$msg->attributes = $_POST['Message'];
			$msg->to = $user->id;
			$msg->type = 'text';
			if($msg->validate()){
				$msg->send();
			}
		}
		$this->render('send',array('user'=>$user,'msg'=>$msg));
	}

}