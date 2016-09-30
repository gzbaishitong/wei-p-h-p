<?php

namespace Addons\UserInfo\Controller;




//报名活动
use Home\Controller\AddonsController;

class SignUpController extends  AddonsController
{


    function _initialize()
    {
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
        parent::_initialize();
    }

public function aclist()//报名活动列表页
{
    $openid=$_SESSION['openid'];
    $Dao=M();
    $list=D('Addons://UserInfo/SignUp')->getList();//活动列表
    $surelist=$Dao->query("select b.*,a.telphone,a.sex,a.id as userid,a.isaudit,a.isjoin  from wp_signupuser a RIGHT JOIN wp_signup b ON a.typeid=b.id WHERE a.openid='$openid' and a.ispay=1");
    $localtime=time();
//    if($surelist[0]['acendtime']>$localtime) {
//        var_dump($surelist[0]['acendtime'] - $localtime);
//        exit;
//    }
//    else
//    {
//        var_dump('123');
//        exit;
//    }
    M('signupuser')->where("  ispay=0 AND endpaytime<'$localtime'  ")->delete();
    $this->assign('localtime',$localtime);
    $this->assign('list',$list);
    $this->assign('surelist',$surelist);
    $this->display();
}

    public function accontent()//活动详情页
    {
        $id=I('id');
        $info=D('Addons://UserInfo/SignUp')->getInfo($id);//活动列表
        $surecount=D('Addons://UserInfo/SignUpUser')->getsurecount($id);//活动列表
        if(!$info)
        {
            $this->error('此活动不存在');
        }
        $this->assign('localtime',time());
        $this->assign('surecount',$surecount);
        $this->assign('info',$info);
        $this->display();
    }

    public function signup()//报名填写信息页
    {
        $Dao=M();
        $openid=$_SESSION['openid'];
        $id=I('id');
        $info=D('Addons://UserInfo/SignUp')->getInfo($id);//活动列表
        $map['openid']=$openid;
        $usermap['openid']=$openid;
        $userinfo=$Dao->query("select truename as name,telphone,sex from wp_userinfo WHERE openid='$openid'");//会员卡信息
        if($userinfo)
        {
            $myinfo=$userinfo[0];
        }
        $recordinfo=M('signupuser')->where($map)->order('addtime desc')->limit(1)->select();
        if($recordinfo)
        {
            $myinfo=$recordinfo[0];
        }
        if(!$info)
        {
            $this->error('此活动不存在');
        }
        $this->assign('recordinfo',$myinfo);
        $this->assign('info',$info);
        $this->display();
    }

    public function neworder()//生成报名信息
    {
        $openid = $_SESSION['openid'];
        $id=I('id');
        $telphone=I('telphone');
        $name=I('name');
        $sex=I('sex');
        $map['openid'] = $openid;
        $map['typeid']=$id;
        $goodsinfo= D('Addons://UserInfo/SignUp')->getInfo($id);//报名信息
        if (IS_AJAX) {
            if($goodsinfo['begintime']>time())
            {
                $result['status'] = false;
                $result['msg'] = '该活动还未开始报名哦';
                $this->ajaxReturn($result, 'json');
            }
            elseif($goodsinfo['endtime']<time())
            {
                $result['status'] = false;
                $result['msg'] = '该活动已结束';
                $this->ajaxReturn($result, 'json');
            }
            //开始防并发
            $localtime=time();
            $begintime=$localtime-1;
            $endtime=$localtime+1;
            $list=M('signupuser')->where("typeid='$id'")->select();
            foreach($list as $val)
            {
                if($val['addtime']>=$begintime&&$val['addtime']<$endtime)
                {
                    $result['status'] = false;
                    $result['msg'] = '当前报名人数过多请稍后再试';
                    $this->ajaxReturn($result, 'json');
                }
            }
            $nopaymap['typeid']=$id;
            $nopaymap['ispay']=0;
            $nopaymap['openid']=$openid;
            $nopaymap['endpaytime']=array('gt',time());
            $find=M('signupuser')->where($nopaymap)->find();//当前用户未支付未超时记录
            if($find)
            {
                $result['msg']=$find['id'];
                $result['status'] = true;
                $this->ajaxReturn($result, 'json');
            }
            //结束防并发
            $nopaycount=M('signupuser')->where("typeid='$id' AND ispay=0 AND endpaytime>'$localtime' ")->count();//未支付并未超时订单
            if($nopaycount>=$goodsinfo['number']&&$nopaycount!=0)
            {
                $result['status'] = false;
                $result['msg'] = '当前报名人数过多请稍后再试';
                $this->ajaxReturn($result, 'json');
            }



            //开始查询该商品限购次数
            $OrderMap['typeid']=$id;
            $OrderMap['ispay']=1;
            $OrderMap['openid']=$openid;
            $count=M('signupuser')->where($OrderMap)->count();
//结束查询该商品限购次数
                if($count>=1)//如果超过限购次数
                {
                    $result['status'] = false;
                    $result['msg'] = '您已报名此活动,请勿重复报名哦';
                    $this->ajaxReturn($result, 'json');
                }

            $countMap['typeid']=$id;
            $countMap['ispay']=1;
            $allcount=M('signupuser')->where($countMap)->count();
            if($goodsinfo['money']!=0) {
            if($allcount>=$goodsinfo['number'])//如果超过报名次数
            {
                $result['status'] = false;
                $result['msg'] = '报名人数已满,敬请期待下次活动';
                $this->ajaxReturn($result, 'json');
            }
            }

            //开始插入报名记录
            $data['typeid']=$id;
            $data['token']=get_token();
            $data['addtime']=time();
            if($goodsinfo['money']!=0) {
                $data['endpaytime']=time()+15*60;
                $data['ispay'] = 0;
                $ordernum=time().rand(100,999);
                $data['ordernum']=$ordernum;
            }
            else
            {
                $data['isaudit']=0;
                $data['isjoin']=0;
                $data['ispay'] = 1;
            }
            $data['openid']=$openid;
            $data['telphone']=$telphone;
            $data['sex']=$sex;
            $data['name']=$name;
            $query=D('Addons://UserInfo/SignUpUser')->adduser($data);
            //结束插入报名记录
            if ($query) {
                $result['status'] = true;
                $result['msg']=$query;
                $this->ajaxReturn($result, 'json');
            } else {
                $result['status'] = false;
                $result['msg'] = "订单生成失败";
                $this->ajaxReturn($result, 'json');
            }
        }
    }

    private function weipay($orderinfo){
        $config = get_addon_config('Upay');
        //组装数据
        $data['body'] = "[{$orderinfo['ordernum']}]";
        $data['out_trade_no'] = $orderinfo['ordernum'];
        $data['total_fee'] = $orderinfo['total_price']*100;
        $data['notify_url'] = 'http://addon.rtda.cn/weiphp/index.php/addon/UserInfo/UserInfo/searchPay';//跳转程序

        $pay = new \Com\Weipay($config,$data);
        $apipay =  $pay->getParameters(); //获得jsapi支付的必要参数
        return $apipay;
    }

    public function payorder()//支付页面
    {
        $openid=$_SESSION['openid'];
        $id=I('id');//记录id
        $map['id']=$id;
        $info=D('Addons://UserInfo/SignUpUser')->getOrderInfo($map);//记录信息
        $signupinfo=D('Addons://UserInfo/SignUp')->getInfo($info['typeid']);//报名信息
       if(!$info)
       {
           $this->error('此订单不存在');
       }
        elseif($info['ispay']==1)
        {
            $this->assign('ispay',1);
        }
        else {
            $orderinfo['ordernum'] = $info['ordernum'];
            $orderinfo['total_price'] = $signupinfo['money'];
            try {
                $apipay = $this->weipay($orderinfo);
            } catch (\Think\Exception $e) {
                $this->error($e->getMessage());
            }
            $signPackage = getjssdk();
            $this->assign('timeout', $info['endpaytime'] - time());
            $this->assign('signPackage', $signPackage);
            $this->assign('apipay', $apipay);
        }
        $this->assign('info',$info);
        $this->assign('signupinfo',$signupinfo);
        $this->display();
    }

    public function closeorder()//超时关闭订单
    {
        $id=I('id');//订单id
        $map1['id'] = $id;
        $orderinfo = D('Addons://UserInfo/SignUpUser')->getOrderInfo($map1);
        $config = get_addon_config('Upay');
        //组装数据
        $data['body'] = "[{$orderinfo['ordernum']}]";
        $data['out_trade_no'] = $orderinfo['ordernum'];
        $data['total_fee'] = $orderinfo['total_price'] * 100;
//        $data['notify_url'] = addons_url('Shop://Index/searchPay', array('id' => $orderinfo['id'], 'key' => 'fasdfsadfwxmcmnvfref'));//跳转程序
        $data['notify_url'] ='m';
        $pay = new \Com\Weipay($config, $data);
        $result=$pay->closeorder($orderinfo['ordernum']);
        $this->success($result);
    }

    public function delorder()//30秒未支付自动删除订单
    {
        $id=I('id');//订单id
        $map['id']=$id;
        M('signupuser')->where($map)->delete();
    }



    public function surecontent()//已报名活动详情页
    {
        $id=I('id');
        $map['id']=$id;
        $recordinfo=D('Addons://UserInfo/SignUpUser')->getOrderInfo($map);
        $signupinfo=D('Addons://UserInfo/SignUp')->getInfo($recordinfo['typeid']);
        $this->assign('localtime',time());
        $this->assign('signupinfo',$signupinfo);
        $this->assign('recordinfo',$recordinfo);
        $this->display();
    }

    public function verifications()//报名核销控制器
    {
        if(IS_AJAX) {
            $id = I('id');
            $code = I('code');
            $config = get_addon_config('UserInfo');
            if ($code != $config['signupcode']) {
              $this->error('核销码错误');
            }
            $map['id'] = $id;
            $recordinfo = D('Addons://UserInfo/SignUpUser')->getOrderInfo($map);
            if (!$recordinfo) {
               $this->error('此报名不存在');
            }
            $data['isjoin'] = 1;
            D('Addons://UserInfo/SignUpUser')->updateinfo($map, $data);
            $this->success('核销成功');
        }
    }
    public function searchPay(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $id = $postStr['out_trade_no'];//订单id
        $map['ordernum'] = $id;
        $orderinfo = D('Addons://UserInfo/SignUpUser')->getOrderInfo($map);
        if (!$orderinfo) {
            $this->ajaxReturn(false, 'json');
        } else {
//            //验证是否已支付
            $config = get_addon_config('Upay');
            $pay = new \Com\Weipay($config);
            $result = $pay->searchPay($orderinfo['ordernum']); //获得jsapi支付的必要参数

//                //支付成功
            $data['transaction_id'] = $result['transaction_id'];
            $data['payTime'] = strtotime($result['time_end']);
            $data['isaudit']=1;
            $data['isjoin']=0;
            $data['ispay']=1;
            if($orderinfo['ispay']==0) {
                D('Addons://UserInfo/SignUpUser')->updateinfo($map, $data);
            }
            echo 'SUCCESS';

        }
    }




}
