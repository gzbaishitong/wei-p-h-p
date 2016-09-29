<?php

namespace Addons\HFive\Controller;


use Addons\UserInfo\UserInfoAddon;
use Home\Controller\AddonsController;

class BaseController extends AddonsController
{
    public $appid = 'wxb1114bb65753893c';
    public $secret = '6e7feece406d1b7c48baf85c071bd3f1';

    function _initialize()
    {
        if( $_SERVER['HTTP_HOST']=='addon.gzbaishitong.com'||$_SERVER['HTTP_HOST']=='addon.hxbear.com.cn')
        {
            exit;
        }
        header("Content-Type:text/html; charset=utf-8");
        parent::_initialize();
        $code = I('code');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {//判断浏览器为非微信浏览器
        } else {
            session('token','gh_d15476629f4b');
            if ($code != "" ) {
                getopenid($this->appid, $this->secret, $code);
            }
            $openid=$_SESSION['openid'];
            if($openid=='')
            {
                redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb1114bb65753893c&redirect_uri=http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/HFive/Tiger/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');
//                $this->error('未注册或无效链接');
            }


        }
    }
}
