<?php

namespace Addons\UserInfo\Controller;


use Addons\UserInfo\UserInfoAddon;

class MeController extends BaseController
{
    public $apikey = "2b35ff22ed05a1be22eca1f4f59af099";

    function _initialize()
    {
        parent::_initialize();
    }

    public function index()//主页
    {
        $openid=$_SESSION['openid'];
        $map['openid']=$openid;
        $map['token']=get_token();
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $config=get_addon_config('Acctivity');//推荐好友送积分配置参数
        $this->assign('config',$config);
        $this->assign('info',$Info);
        $this->display();
    }

    public function myqrcode()//分享好友二维码视图
    {
        $openid=$_SESSION['openid'];
        $map['openid']=$openid;
        $map['token']=get_token();
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $this->assign('info',$Info);
        $this->display();
    }

    public function newslist()//转发文章列表视图
    {
        $map['isaddscore'] = array('neq',0);
        $map['token']=get_token();
        $NewsList = D('Addons://UserInfo/News')->getList($map);//转发文章列表
        $this->assign('NewsList', $NewsList);
        $this->display();
    }

    public function newscontent()//文章详情视图
    {
        $openid = $_SESSION['openid'];
        $id = I('id');
        $state = I('state');
        if (!empty($state)) {
            $id = $state;
            //开始解析参数
            $id = explode('|', $id);//包括文章id,分享人openid,分享方式
            //结束解析参数

            $map['id'] = $id[0];
            $NewsList = D('Addons://UserInfo/News')->getInfo($map);//文章列表
            if (!$NewsList) {
                $this->error('文章不存在');
            }
            D('Addons://UserInfo/News')->addreadcount($id[0]);//增加阅读次数
            $usermap['openid'] = $openid;
            $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermap);//阅读用户信息
            if ($Info) {
                $query = D('Addons://UserInfo/News')->addscore($openid, $id[0], 'r');//文章增加积分

            }
            $usermap['openid'] = $id[1];
            $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermap);//推荐阅读用户信息
            if (!$Info) {
                $this->error('此会员不存在');
            }
            if ($openid != $id[1])//如果是推荐好友阅读
            {
                $query= D('Addons://UserInfo/News')->addscore($id[1], $id[0], $id[2], $openid);//给推荐用户增加积分
                $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermap);//阅读用户信息
                if($query) {
                    //开始判断是否关注
                    $access_token = D("Addons://Vote/AccessToken")->getInfo();
                    $access_token=$access_token['access_token'];
                    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
                    $info = json_decode(file_get_contents($url), true);
                    if ($info['subscribe'] == 0) {
                        $this->assign('qrcode',$Info['qrcode']);
                    }
                    //结束判断是否关注
                    $diaoyong = new UserInfoAddon();
                    $localtime = date('Y-m-d H:i', time());//当前时间
                    $template = $diaoyong->subscribe($id[1], $localtime, $NewsList['sharescore'], '推荐好友阅读送积分', $Info['score'], $Info['nickname']);
                    $diaoyong->sendtempmsg(urldecode($template));
                }
                if($NewsList['url']!='')
                {
                    redirect($NewsList['url']);
                }
            }
        } else {
            $map['id'] = $id;
            $NewsList = D('Addons://UserInfo/News')->getInfo($map);//文章列表
            if($NewsList['url']!='')
            {
                $url=$NewsList['url'];
            }
            D('Addons://UserInfo/News')->addreadcount($id);//增加阅读次数
            $usermap['openid'] = $openid;
            $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermap);//阅读用户信息
            if ($Info) {
                $query = D('Addons://UserInfo/News')->addscore($openid, $id, 'r');//文章增加积分

            }
        }
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('openid', $openid);
        $this->assign('url',$url);
        $this->assign('NewsList', $NewsList);
        $this->display();
    }

    public function mycoupons()//我的优惠券视图
    {
        $openid=$_SESSION['openid'];
        $map['openid']=$openid;
        $map['token']=get_token();
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $CouPonList= D('Addons://UserInfo/Coupons')->getList($Info['id']);//优惠券列表
        $this->assign('CouPonList',$CouPonList);
        $this->display();
    }
}