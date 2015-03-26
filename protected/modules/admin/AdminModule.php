<?php

class AdminModule extends CWebModule
{
	public $assetsUrl;
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
			'admin.controllers.DefaultController',
		));
		Yii::app()->clientScript->registerScript('baseUrl', 
            'var baseUrl=' . CJSON::encode(Yii::app()->getBaseUrl(true) . '/admin') . ';', CClientScript::POS_HEAD);
        
        $this->assetsUrl = $path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.assets'));
        //Yii::app()->clientScript->registerCssFile($path . '/plugins/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css');
        
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
