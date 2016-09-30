<?php

namespace Addons\UserInfo\Controller;


use Addons\UserInfo\UserInfoAddon;
use Home\Controller\AddonsController;

class BaseController extends AddonsController
{
    public $appid = 'wx807f16d8a8046457';
    public $secret = '2aeca10207571bf7918d2a974f63e6c2';

    function _initialize()
    {
//       if( $_SERVER['HTTP_HOST']=='addon.gzbaishitong.com'||$_SERVER['HTTP_HOST']=='addon.hxbear.com.cn')
//       {
//           exit;
//       }
//        parent::_initialize();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {//判断浏览器为非微信浏览器
        } else {
            header("Content-Type:text/html; charset=utf-8");
            $code = I('code');
            session('token','gh_4fc719089612');
            if ($code != "" && $_SESSION['openid']=='' ) {
                getopenid($this->appid, $this->secret, $code);
            }
            if(IS_AJAX) {
                if (empty($_SESSION['openid'])) {
                    $this->error('身份验证失效,请重新从自定义菜单进入会员卡进行操作');
                }
            }else
            {
                if (empty($_SESSION['openid'])) {
                    redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');
                }
            }


        }
    }
}
