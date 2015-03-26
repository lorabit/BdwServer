<?php

class SysController extends DefaultController
{
	public function actionWxqylog()
	{
		$model = new Wxlog();
        $model->unsetAttributes();
        if(isset($_REQUEST['Wxlog']))
        {
            $model->setAttributes($_REQUEST['Wxlog']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('wxqylog', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

}