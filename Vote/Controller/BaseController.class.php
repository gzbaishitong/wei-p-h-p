<?php

namespace Addons\Vote\Controller;


use Addons\UserInfo\UserInfoAddon;
use Home\Controller\AddonsController;

class BaseController extends AddonsController
{
    public $appid = 'wx807f16d8a8046457';
    public $secret = '2aeca10207571bf7918d2a974f63e6c2';

    function _initialize()
    {
        header("Content-Type:text/html; charset=utf-8");
        parent::_initialize();
        $code = I('code');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {//判断浏览器为非微信浏览器
        } else {
            session('token','gh_4fc719089612');
            if ($code != "" ) {
                getopenid($this->appid, $this->secret, $code);
            }
            $openid=$_SESSION['openid'];
            if($openid=='')
            {
//                redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');
                $this->error('未注册或无效链接');
            }

//            $access_token=$_SESSION['access_token'];
//            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
//            $info=json_decode(file_get_contents($url),true);
//           if($info['errcode']!=0)
//           {
//               $access_token=get_access_token(get_token());
//               $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
//               $info=json_decode(file_get_contents($url),true);
//               if($info['subscribe']==0)
//               {
//                   $this->error('请先关注公众号哦');
//               }
//           }
        }
    }
}
