<?php

class StoreController extends DefaultController
{
	public function actionCreate()
	{
		$model = new Store;
		if(isset($_POST['Store'])){
			$model->attributes = $_POST['Store'];
			if($model->validate()){
				if($model->save()){
					$this->redirect(array('update','id'=>$model->id));
				}
			}
		}
		$this->render('_form',array('model'=>$model));
	}

	public function actionIndex(){
		$model = new Store();
        $model->unsetAttributes();
        if(isset($_REQUEST['Store']))
        {
            $model->setAttributes($_REQUEST['Store']);
        }
        
        $criteria = new CDbCriteria();
        $dataProvider = $model->search($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
	}

	public function actionUpdate(){
		$model = $this->loadModel('Store');
		if(isset($_POST['Store'])){
			$model->attributes = $_POST['Store'];
			if($model->validate()){
				if($model->save()){
					//$this->redirect(array('update','id'=>$model->id));
				}
			}
		}
		$this->render('_form',array('model'=>$model));
	}

}