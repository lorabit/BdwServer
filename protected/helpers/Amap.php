<?php
	class Amap{
		 public $params;
		 public function getRestUrl(){
		 	$url = 'http://restapi.amap.com/v3/staticmap?key='.Yii::app()->params['amap']['key']['rest'];
		 	foreach ($this->params as $key => $value) {
		 		$url .= '&'.$key.'='.urlencode($value);
		 	}
		 	return $url;
		 }
	}