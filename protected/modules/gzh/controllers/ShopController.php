<?php
class ShopController extends DefaultController{

	public function actionIndex(){
		$model = new StoreCoupon;

        $model->unsetAttributes();
        if(isset($_REQUEST['StoreCoupon']))
        {
            $model->setAttributes($_REQUEST['StoreCoupon']);
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