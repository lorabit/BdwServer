<?php

class GzhController extends DefaultController
{
	public function actionApi(){
		if($this->checkSignature()===false) return;
		//日志
		$log = new Wxlog;
		$log->type = 'gzh';
		$log->body = file_get_contents("php://input");
		if($log->save()==false){
			Yii::log($log->getErrors(),'error','api-log');
		}

		echo $_GET['echostr'];
	}

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = 'sdogj3ibtjk3to2';
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}