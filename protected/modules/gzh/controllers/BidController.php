<?php
class BidController extends DefaultController{
	
	public function actionIndex($order='time'){
		$policy = $this->loadModel('Policy');
        if($policy->status!=Policy::STATUS_OPEN){
            $bid = PolicyPush::model()->find('policy_id=:policy_id and store_id=:store_id',array(
                'policy_id' => $policy->id,
                'store_id' => $policy->store_id,
            ));
            $this->redirect('view?id='.$bid->id);
        }
		$model = new PolicyPush;

        $model->unsetAttributes();
        if(isset($_REQUEST['PolicyPush']))
        {
            $model->setAttributes($_REQUEST['PolicyPush']);
        }
        $model->status = PolicyPush::STATUS_QUOTED;
        $model->policy_id = $policy->id;
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria,$order);

        $this->render('index', array(
            'policy' => $policy,
            'model' => $model,
            'dataProvider' => $dataProvider,
            'order' => $order,
        ));
	}

    public function actionView(){
        $this->layout = 'gzh.views.layouts.blank';
        $bid = $this->loadModel('PolicyPush');
        $store = $bid->store;
        $this->render('view',array('bid'=>$bid,'store'=>$store));
    }

    public function actionPay(){
        $bid = $this->loadModel('PolicyPush');
        $bid->pay();
        $this->redirect('view?id='.$bid->id);
    }

    public function actionComment(){
        $bid = $this->loadModel('PolicyPush');
        $bid->comment = $_REQUEST['comment'];
        $bid->rate = $_REQUEST['rate'];
        $bid->status = PolicyPush::STATUS_COMMENTED;
        $bid->policy->status = Policy::STATUS_CLOSED;
        $bid->policy->save();
        $bid->save();
        $this->redirect('view?id='.$bid->id.'#!comment');
    }
}