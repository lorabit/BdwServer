<?php

class WXBiz{
	private $_access_token;

	public function getParams($value){
		return Yii::app()->params['wxqy'][$value];
	}

	function __construct() {
		$this->connect();
		 //parent::__construct();

	}
	public function connect(){
		if(!empty($this->_access_token))
			return;

		$cache = Yii::app()->cache;
		$access_token = $cache['wxqy_access_token'];
		
		if(empty($access_token)){
			try{
				$data = $this->curl_get('https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$this->getParams('corpId').'&corpsecret='.$this->getParams('secret'));
				$access_token = json_decode($data)->access_token;
				$cache->set("wxqy_access_token",$access_token,6000);
			}
			catch(Exception $e){
				return false;
			}
		}
		$this->_access_token = $access_token;
		return true;
	}

	public function post($url,$content){
		return $this->curl_post($url.'?access_token='.$this->_access_token,$content);
	}

	public function get($url,$content){
		$suffix = '';
		foreach ($content as $key => $value) {
			$suffix .= ('&'.$key.'='.urlencode($value));
		}
		return $this->curl_get($url.'?access_token='.$this->_access_token.$suffix);
	}

	public function curl_post($url,$content){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        $data = curl_exec($ch);
        $errno = curl_errno($ch);

        // var_dump($url,$content,$data,$errno);
        if ($errno > 0) {
            $err = "[CURL] url:{$url} errno:{$errno} info:" . curl_error($ch);
            error_log($err);
            $data = false;
        }
        curl_close($ch);
        return $data;
	}

	public function curl_get($url){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);

        
        $errno = curl_errno($ch);
        if ($errno > 0) {
            $err = "[CURL] url:{$url} errno:{$errno} info:" . curl_error($ch);
            error_log($err);
            $data = false;
        }
        curl_close($ch);
        return $data;
	}
}