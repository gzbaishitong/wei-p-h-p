<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;
use Addons\UserInfo\UserInfoAddon;

class HFiveController extends AddonsController{
    public $appid = 'wxb1114bb65753893c';
    public $secret = '6e7feece406d1b7c48baf85c071bd3f1';
    public function beforeindex()//填写手机号码
    {
        $this->display();
    }
   public function index()
   {
       exit;
       session('token','gh_d15476629f4b');
       $code = I('code');
       if ($code != "" && $_SESSION['openid'] == '') {
           getopenid($this->appid, $this->secret, $code);
       }
       $openid=$_SESSION['openid'];
       $Info= D('Addons://HFive/HFive')->getMemberInfo($openid);//单条用户信息
//       if($Info['telphone']=='')
//       {
//           redirect(U('beforeindex'));
//       }
       $signPackage = getjssdk();
       $this->assign('openid',$openid);
       $this->assign('appid', $this->appid);
       $this->assign('signPackage', $signPackage);
       $this->display();
   }

    public function addrecord()//新增转发记录
    {
          $openid=I('openid');
        $name=I('name');//游戏名称
        $query= D('Addons://HFive/HFive')->addrecord($openid,$name);//新增转发记录
        if($query)
        {
            $count= D('Addons://HFive/HFive')->getcount($openid);//转发条数
            if($count%3==0)
            {
                $diaoyong=new UserInfoAddon();
                $json=$diaoyong->get_access_token();
                $access_token=$json['access_token'];
                $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
                $info=json_decode(file_get_contents($url),true);
                $query=D('Addons://HFive/HFive')->saveinfo($openid,$info);
               $this->success('恭喜您今日已转发三次');
            }
            $this->success('您已转发'.$count.'次');
        }
    }

    public function saveinfo()//保存信息控制器
    {
        $openid=$_SESSION['openid'];
        $telphone=I('telphone');
        $name=I('name');
        $query=D('Addons://HFive/HFive')->saveinfo($openid,$telphone,$name);
        if($query)
        {
            $this->success('提交成功',U('index'));
        }
        else
        {
            $this->error('提交失败');
        }
    }

    public function getUber()
    {
        $url="https://get.uber.com.cn/envelope/GZDW012/?from=singlemessage&isappinstalled=0";
        $content=file_get_contents($url);
        $this->assign('content',$content);
        $this->display();
    }
}
