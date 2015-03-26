<?php

class Wxh5Module extends CWebModule
{
	public $assetsUrl;
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'wxh5.models.*',
			'wxh5.components.*',
			'wxh5.controllers.DefaultController',
		));
		Yii::app()->clientScript->registerScript('baseUrl', 
            'var baseUrl=' . CJSON::encode(Yii::app()->getBaseUrl(true) . '/wxh5') . ';', CClientScript::POS_HEAD);
        
        $this->assetsUrl = $path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('wxh5.assets'));
        
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
