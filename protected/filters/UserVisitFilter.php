<?php

class UserVisitFilter extends CFilter {

    public $not_record_ajax = true;


    protected function preFilter($filterChain) {

        $_controller = isset($filterChain->controller) ? $filterChain->controller->id : null;
        $_module = isset($filterChain->controller->module) ? $filterChain->controller->module->id : 'site';
        $_action = isset($filterChain->controller->action) ? $filterChain->controller->action->id : null;
        if (Yii::app()->user->getState('user_group')==User::USER_GROUP_SYSTEM)
            return true;
        //微信企业号H5页面权限逻辑
        if($_module=='wxh5'){
            if($_controller=='auth')return true;
            //若未登录
            if(!Yii::app()->user->getState('wxqyid')){
                Yii::app()->user->returnUrl = Yii::app()->request->getUrl();
                Yii::log(Yii::app()->user->returnUrl,'error','returnUrl - wxh5 - filter');
                Yii::app()->request->redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.Yii::app()->params['wxqy']['corpId'].'&redirect_uri='.urlencode(Yii::app()->params['url'].'wxh5/auth/login').'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect');
                return false;
            }
        }
        //微信公众号H5页面逻辑
        if($_module=='gzh'){
            if($_controller=='auth')return true;
            //若未登录
            if(!Yii::app()->user->getState('id')){
                Yii::app()->user->returnUrl = Yii::app()->request->getUrl();
                Yii::log(Yii::app()->user->returnUrl,'error','returnUrl - gzh - filter');
                Yii::app()->request->redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.Yii::app()->params['gzh']['appid'].'&redirect_uri='.urlencode(Yii::app()->params['url'].'gzh/auth/login').'&response_type=code&scope=snsapi_base&state=123#wechat_redirect');
                return false;
            }
            return true;
        }
        if($_module=='site'&&$_controller=='public') return true;
        if($_module=='wx')
            return true;
        if($_action=='login'||$_action=='error')
            return true;
        //APP验证逻辑
        if($_module=='app'){
            $cache = Yii::app()->cache;
            $token = $_GET['token'];
            if(empty($token))return false;
            if(isset($cache['app_token_'.$token])){
                $id = $cache['app_token_'.$token];
                // var_dump($id);die();
                $user = User::model()->find("id=$id");
                $user->setState();
                return true;
            }
            return false;
        }
        if (!Yii::app()->user->getState('id')) {
            Yii::app()->user->returnUrl = Yii::app()->request->getUrl();
            Yii::app()->request->redirect('/admin/default/login');
            return false;
        }
        return true;
    }

    protected function postFilter($filterChain) {
    
        parent::postFilter($filterChain);
    }

}

?>
