<?php

class TesteeController extends DefaultController
{

	public function actionIndex(){
		$model = new Testee();
        $model->unsetAttributes();
        if(isset($_REQUEST['Testee']))
        {
            $model->setAttributes($_REQUEST['Testee']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

}