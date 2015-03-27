<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'不倒翁',
	
    'theme' => 'classic',

	// preloading 'log' component
	'preload'=>array('log','booster'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
        'application.extensions.*',
		'application.models.*',
        'application.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin',
		'wx',
		'app',
		'wxh5',
		'gzh',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
'assetManager' => array(
            'linkAssets' => false,
            'forceCopy' => true,
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        'booster' => array(
            'class' => 'ext.booster.components.Booster',
        ),
		// uncomment the following to enable URLs in path-format
		
		 'urlManager' => array(
            'urlFormat' => 'path',
            // 'showScriptName' => false,
            'rules' => array(
                // '/' => 'site/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
            ),
        ),
		'cache' => array(
            'class' => 'CFileCache'
        ),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				// array(
    //               'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
    //               //'ipFilters' => array('115.206.152.207'),
    //               'ipFilters' => array('127.0.0.1'),
    //               ), 
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				// array(
				// 	'class'=>'CWebLogRoute',
				// ),
				
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	
);
