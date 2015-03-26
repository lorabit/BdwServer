<?php

class DefaultController extends Controller
{
	public $_wxcpt;
	public $_xml;
	public $_data;
	public function getParams($value){
		return Yii::app()->params['wxqy'][$value];
	}


	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionTest($echostr){
		$msg_signature = $_GET['msg_signature'];
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$errCode = $this->wxcpt->VerifyURL($msg_signature, $timestamp, $nonce, $echostr, $sEchoStr);
		if ($errCode == 0) {
			echo($sEchoStr);
		} else {
			echo("ERR: " . $errCode . "\n\n");
		}
	}

	public function wxcpt(){
		if(isset($this->_wxcpt))
			return $this->_wxcpt;
		$this->_wxcpt = new WXBizMsgCrypt($this->getParams('token'), $this->getParams('encodingAesKey'), $this->getParams('corpId'));
		return $this->_wxcpt;
	}

	public function decrypt($str){
		$msg_signature = $_GET['msg_signature'];
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$sMsg = "";  // 解析之后的明文
		$errCode = $this->wxcpt()->DecryptMsg($msg_signature, $timestamp, $nonce, $str, $sMsg);
		if ($errCode == 0) {
			return $sMsg;
		} else {
			print("ERR: " . $errCode . "\n\n");
			die();
		}
	}

	public function encrypt($str){
		$timestamp = date();
		$nonce = rand(0,2147482647);
		$sEncryptMsg = ""; //xml格式的密文
		$errCode = $this->wxcpt()->EncryptMsg($str, $timestamp, $nonce, $sEncryptMsg);
		if ($errCode == 0) {
			return $sEncryptMsg;
		} else {
			print("ERR: " . $errCode . "\n\n");
			die();
		}
	}

	public function xml(){
		$data = $this->decrypt(file_get_contents("php://input"));
		$xml = new DOMDocument();
		$xml->loadXML($data);
		$this->_xml = $xml;
		$this->_data = $data;
		return $xml;	
	}

	
}