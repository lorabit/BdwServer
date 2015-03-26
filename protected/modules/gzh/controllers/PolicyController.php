<?php
class PolicyController extends DefaultController{
	public function actionCreate(){
		$this->pageTitle = '询价';
		$policy = new Policy;
		if(Yii::app()->request->isAjaxRequest){
			$mediaid = $_POST['mediaid'];
			$description = $_POST['description'];
			$quote = $_POST['quote'];
			$model = $_POST['model'];
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			if(empty($mediaid)||empty($description)||empty($quote)||empty($model)){
				$this->renderJson(array('code'=>1,'msg'=>'信息不完整'));
			}
			$policy->comment = $description;
			$policy->user_id = Yii::app()->user->id;
			$policy->latitude = $latitude;
			$policy->longitude = $longitude;
			$policy->car_model = $model;
			$policy->quote = $quote;
			if($policy->save()){
				//上传图片
				foreach ($mediaid as $value) {
					$photo = new Photo;
		            $photo->user_id = Yii::app()->user->id;
		            $photo->media_id = $value;  
		            $photo->status = Photo::STATUS_NEW;
		            $photo->policy_id = $policy->id;
		            $photo->validate();
		            if($photo->save()==false){
		            	$this->renderJson($mediaid);
		            	return;
		            }
		            $photo->downloadMedia();
				}
				$policy->publish();
				$this->renderJson(array('code'=>0));
			}else
				$this->renderJson(array('code'=>1,'msg'=>'创建失败！'));
			return;
		}
		$this->render('create',array('model'=>$policy));
	}

	public function actionIndex(){
		$model = new Policy();
        $model->unsetAttributes();
        if(isset($_REQUEST['Policy']))
        {
            $model->setAttributes($_REQUEST['Policy']);
        }
        $model->user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

}