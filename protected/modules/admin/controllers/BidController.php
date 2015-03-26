<?php

class BidController extends DefaultController{
	public function actionIndex(){
		$model = new PolicyPush();
        $model->unsetAttributes();
        if(isset($_REQUEST['PolicyPush']))
        {
            $model->setAttributes($_REQUEST['PolicyPush']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}
}