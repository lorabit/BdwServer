<?php

class PolicyController extends DefaultController
{
	public function actionCreate()
	{
		$model = new Policy;
		if(isset($_POST['Policy'])){
			$model->attributes = $_POST['Policy'];
			if($model->validate()){
				if($model->save()){
					$this->redirect(array('update','id'=>$model->id));
				}
			}
		}
		$this->render('_form',array('model'=>$model));
	}

	public function actionIndex(){
		$model = new Policy();
        $model->unsetAttributes();
        if(isset($_REQUEST['Policy']))
        {
            $model->setAttributes($_REQUEST['Policy']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

	public function actionUpdate(){
		$model = $this->loadModel('Policy');
		if(isset($_POST['Policy'])){
			$model->attributes = $_POST['Policy'];
			if($model->validate()){
				if($model->save()){
					//$this->redirect(array('update','id'=>$model->id));
				}
			}
		}
		$this->render('_form',array('model'=>$model));
	}

	public function actionPublish(){
		$model = $this->loadModel('Policy');
		$count = $model->publish();
		$this->renderJson(array('count'=>$count));
	}

}