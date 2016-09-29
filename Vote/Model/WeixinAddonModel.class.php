<?php
namespace Addons\Vote\Model;
use Addons\UserInfo\UserInfoAddon;
use Home\Model\WeixinModel;

/**
 * Vote模型
 */
class WeixinAddonModel extends WeixinModel {
    function reply($dataArr, $keywordArr = array()) {
//		//先获取投票消息
        $map['token'] = get_token();
//		if (! empty ( $keywordArr ['aim_id'] )) {
//			$map ['id'] = $keywordArr ['aim_id'];
//		}
//
        $info = M ( 'vote' )->where ( $map )->order ( 'id desc' )->find ();
        if (! $info) {
            return false;
        }
//
//		//组装用户在微信里点击图文的时跳转URL
//		//其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
//		$param ['id'] = $info ['id'];
//		$param ['token'] = get_token ();
//		$param ['openid'] = get_openid ();
//		$url = addons_url ( 'Vote://Vote/show', $param );
//
//		//组装微信需要的图文数据，格式是固定的
//		$articles [0] = array (
//				'Title' => $info ['title'],
//				'Description' => $info ['info'],
//				'PicUrl' => get_cover_url ( $info ['picurl'] ),
//				'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe63aee4e2103cd84&redirect_uri=http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/Vote/Vote/show&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect'
//		);

//		$res = $this->replyNews ( $articles );
//		return $res;
    }
    // 关注时的操作
    function subscribe($dataArr)
    {

       if(get_token()=='gh_4fc719089612') {
           // 增加积分
           $list = D('Addons://UserCenter/UserCenter')->isaddscore($dataArr['FromUserName']);
           $lastid = $dataArr['EventKey'];//推荐人id
           $lastid = substr($lastid, 8);
           $map['id'] = $lastid;
           $UserMo = M('userinfo');
           $UserInfo = $UserMo->where($map)->find();
           $allcount = D('Addons://UserCenter/UserCenter')->getallcount($UserInfo['id']);//当天用户已推荐好友关注总条数
           $config = get_addon_config('Acctivity');
           if ($UserInfo) {
               if ($dataArr['FromUserName'] != $UserInfo['openid']) {
                   if ($list < 1)//如果该用户未被推荐过
                   {
                       if ($allcount < $config['sharecount']) {//如果该用户未超过当天推荐条数
                           $query = D('Addons://UserInfo/UserInfo')->addscore($UserInfo['openid'], $config['sharescore']);//用户增加积分
                           $query = D('Addons://UserCenter/UserCenter')->addrecord($UserInfo, $dataArr['FromUserName'], 1, $config['sharescore']);//新增记录
                           $articles [0] = array(
                               'Title' => '你的关注已经帮' . $UserInfo['nickname'] . '加了' . $config['sharescore'] . '积分哦',
                               'Description' => '点击图文可以注册会员卡哦',
                               'PicUrl' => get_cover_url($config ['picurl']),
                               'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect'
                           );


                           $UserInfo = $UserMo->where($map)->find();
                           $diaoyong = new UserInfoAddon();
                           $localtime = date('Y-m-d H:i', time());//当前时间
                           $template = $diaoyong->subscribe($UserInfo['openid'], $localtime, $config['sharescore'], '推荐好友关注送积分', $UserInfo['score'], $UserInfo['nickname'], '');
                           $diaoyong->sendtempmsg(urldecode($template));
                           $this->replyNews($articles);
                           exit;
                       } else {
                           $query = D('Addons://UserCenter/UserCenter')->addrecord($UserInfo, $dataArr['FromUserName'], 0, 0);//新增记录
                       }
                   }
//                  add_credit('subscribe');
//                  D('Common/Follow')->init_follow($dataArr ['FromUserName']);
               }
           }
       }
        elseif(get_token()=='gh_ea944655af62')//好招职
        {
            vendor("phpqrcode.phpqrcode");
            $diaoyong=new UserInfoAddon();
            $lastid = $dataArr['EventKey'];//推荐人id
            $lastid = substr($lastid, 8);
            $lastinfo=M('redbaguser')->where("id='$lastid'")->find();
            if($lastinfo)//如果找到推荐人信息
            {
                //开始新增被推荐人信息
                $openid=$dataArr['FromUserName'];
                $data['lastid']=$lastid;
               $userinfo= M('redbaguser')->where("openid='$openid'")->find();
                if($userinfo) {
                   $info= M('redbaguser')->where("openid='$openid'")->save($data);
                    $query=$userinfo['id'];
                }

//                $articles [0] = array(
//                    'Title' => '点击继续做任务',
//                    'Description' => '点击继续做任务',
//                    'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx14416ed01ea0f349&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/HFive/SendRedBag/qrcode&response_type=code&scope=snsapi_base&state=gh_ea944655af62|1#wechat_redirect'
//                );
//                $this->replyNews($articles);
                //结束新增被推荐人信息
            }
        }
    }
    public function scan($dataArr)
//        exit;
        {
            if(get_token()=='gh_4fc719089612') {
                $info = get_addon_config('UserInfo');
                $lastid = $dataArr['EventKey'];//推荐人id
                if ($lastid == 0) {
                    $articles [0] = array(
                        'Title' => $info ['text'],
                        'Description' => $info ['desc'],
                        'PicUrl' => get_cover_url($info ['cover']),
                        'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect'
                    );
                } else if ($lastid == 1) {
                    $articles [0] = array(
                        'Title' => '我的门票',
                        'Description' => '立即点击查看“我的门票”>>~',
                        'PicUrl' => "http://addon.rtda.cn/weiphp/Uploads/Download/goupiao.jpg",
                        'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/BuyTicket/Index/orderlist/type/pay.html&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect'
                    );
                }
                $this->replyNews($articles);
                exit;
//        $this->replyText('欢迎进入暴走广州');
            }
//            elseif(get_token()=='gh_ea944655af62')//好招职
//            {
//                $openid=$dataArr['FromUserName'];
//                $userinfo= M('redbaguser')->where("openid='$openid'")->find();
//                if($userinfo['number']==4)
//                {
//                    $count=M('redbagrecord')->where("openid='$openid'")->count();
//                    if($count<1)
//                    {
//
//                    }
//                    else
//                    {
//                        $this->replyText('你已经提现过了哦,快邀请好友一起来领红包吧');
//                    }
//                }
//            }


    }

    public function location($dataArr) {
        $locationMo=M('userlocation');
        $data['Latitude']=$dataArr['Latitude'];
        $data['Longitude']=$dataArr['Longitude'];
        $data['openid']=$dataArr['FromUserName'];
        $data['addtime']=time();
        $data['token']=get_token();
        $map['openid']=$dataArr['FromUserName'];
        $find=$locationMo->where($map)->find();
        if($find)
        {
            $locationMo->where($map)->save($data);
        }
        else {
            $locationMo->add($data);
        }
        return true;
    }


}
