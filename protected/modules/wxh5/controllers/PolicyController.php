<?php

class PolicyController extends DefaultController{
	
	public function actionView(){
		$model = $this->loadModel('PolicyPush');
		$policy = $model->policy;
		$this->render('view',array('push'=>$model,'policy'=>$policy));
	}

	public function actionSubmit(){
		$model = $this->loadModel('PolicyPush');
		$model->price = $_POST['price'];
		$model->time = $_POST['time'];
		$model->pickup = $_POST['pickup'];
		$model->status = PolicyPush::STATUS_QUOTED;
		$model->save();
        $model->notifyQuote();
		$this->renderJson(array('code'=>1));
	}

	public function actionIndex(){
		$model = new PolicyPush();
        $model->unsetAttributes();
        if(isset($_REQUEST['PolicyPush']))
        {
            $model->setAttributes($_REQUEST['PolicyPush']);
        }
        $model->store_id = Yii::app()->user->getState('store_id');
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

	public function actionBid(){
		$model = new PolicyPush();
        $model->unsetAttributes();
        if(isset($_REQUEST['PolicyPush']))
        {
            $model->setAttributes($_REQUEST['PolicyPush']);
        }
        $model->store_id = Yii::app()->user->getState('store_id');
        $criteria = new CDbCriteria();
        $criteria->addCondition('(status='.PolicyPush::STATUS_QUOTED.' or status='.PolicyPush::STATUS_PAID.' or status='.PolicyPush::STATUS_DONE.')');
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

    public function actionDone(){
        $model = $this->loadModel('PolicyPush');
        $model->status = PolicyPush::STATUS_DONE;
        $model->save();
        $model->store->finalizeDeal($model->price,$model->policy->user_id);
        $model->store->unfreezeUserBalance($model->policy->user_id);
        $model->notifyDone();
        //通知用户取车
        $this->redirect('view?id='.$model->id);
    }
}