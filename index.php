<?php
 date_default_timezone_set('PRC');
// phpinfo();
// die();

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

ini_set('error_reporting', 7);
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);

require_once($yii);
Yii::createWebApplication($config)->run();
