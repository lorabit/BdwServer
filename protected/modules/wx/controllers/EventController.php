<?php

class EventController extends DefaultController
{
	public function subscribe(){
		$xml = $this->xml();
		$userid = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
		$member = new BizMember;
		$member->userid = $userid;
		if($member->get()){
			$member->sync();
		}
	}

	public function actionApi(){


		//测试
		if($_GET['echostr']){
			$msg_signature = $_GET['msg_signature'];
			$timestamp = $_GET['timestamp'];
			$nonce = $_GET['nonce'];
			$errCode = $this->wxcpt()->VerifyURL($msg_signature, $timestamp, $nonce, $_GET['echostr'], $sEchoStr);
			if ($errCode == 0) {
				echo($sEchoStr);
			} else {
				echo("ERR: " . $errCode . "\n\n");
			}
			return;
		}


		$xml = $this->xml();
		


		//日志
		$log = new Wxlog;
		$log->type = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
		$log->body = $this->_data;
		if($log->save()==false){
			Yii::log($log->getErrors(),'error','api-log');
		}

		//处理消息
		$MsgType = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
		if($MsgType=='event'){
			$this->processEvent();
		}


	}

	public function processEvent(){
		$xml = $this->_xml;
		$Event = $xml->getElementsByTagName('Event')->item(0)->nodeValue;
		if($Event == 'LOCATION'){
			$this->processLocation();
		}
	}

	public function processLocation(){
		$xml = $this->_xml;
		$location = new Location;
		$location->type = 'qyid';
		$location->userid = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
		$location->longitude = $xml->getElementsByTagName('Longitude')->item(0)->nodeValue;
		$location->latitude = $xml->getElementsByTagName('Latitude')->item(0)->nodeValue;
		$location->precision = $xml->getElementsByTagName('Precision')->item(0)->nodeValue;
		$location->save();
	}

}