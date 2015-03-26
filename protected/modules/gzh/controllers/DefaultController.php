<?php

class DefaultController extends Controller
{
	public $layout = 'gzh.views.layouts.tabbar';
	public function actionIndex()
	{
		$this->render('index');
	}


	public function registerSDK($apilist = array()){
		echo '<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script type="text/javascript">
			wx.config('.json_encode($this->getSignPackage($apilist)).');
		</script>';
	}

	public function getSignPackage($apilist = array()) {
    $jsapiTicket = $this->getJsApiTicket();
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
    	// 'debug' => true,
      "appId"     => Yii::app()->params['gzh']['appid'],
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string,
      'jsApiList' => $apilist,
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    $cache = Yii::app()->cache;
    $data = $cache['jsapi_ticket'];
    if (empty($data)) {
      $wx = new WXGzh;
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($wx->get('https://api.weixin.qq.com/cgi-bin/ticket/getticket',array(
      	'type' => 'jsapi'
      	)));
      $data = $res->ticket;
      $cache->set("jsapi_ticket",$data,6000);
    } 

    return $data;
  }

}