<?php

namespace Addons\UserInfo\Controller;


use Addons\SendTempleMessage\SendTempleMessageAddon;
use Addons\UserInfo\UserInfoAddon;
use Org\Net\IpLocation;

class TestController extends BaseController
{
    public $apikey = "2b35ff22ed05a1be22eca1f4f59af099";

    function _initialize()
    {
        parent::_initialize();
    }

    public function index()//主页
    {
        header("Content-Type:text/html; charset=utf-8");
        //开始存缓存token

        //结束存缓存token
        $Dao=M();



        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if ($Info['istel'] == 0) {
            redirect(U('registered'));
        }
        $map['token'] = get_token();
        $NewsTypeList = D('Addons://UserInfo/NewsType')->getList($map);//文章分类列表
//        //开始判断是否关注
//        $access_token = D("Addons://Vote/AccessToken")->getInfo();
//        $access_token=$access_token['access_token'];
//        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
//        $info = json_decode(file_get_contents($url), true);
//            if ($info['openid'] == '')//当access_token失效
//            {
//                $access_token = get_access_token(get_token());//重新获取access_token
//                D('Addons://Vote/AccessToken')->saveinfo($access_token,1);
//                $access_token = D("Addons://Vote/AccessToken")->getInfo();
//                $access_token=$access_token['access_token'];
//                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
//                $info = json_decode(file_get_contents($url), true);
//            }
//        if ($info['subscribe'] == 0) {
//            redirect(U('tosubscribe'));
//        }
        //结束判断是否关注
        if ($Info) {
            $saveuserinfo = D('Addons://UserInfo/UserInfo')->saveuserinfo($openid, $_SESSION['userinfo']);//自动保存用户微信信息
        }
        $GoodsList=D("Addons://Shop/Order")->getTopthree($openid);//商品列表
        $ScoreList=array();
        $List=array();//积分记录列表
        $NewsRecordList=D("Addons://UserInfo/NewsRecord")->getList($Info['id']);//文章积分记录列表
        $AcRecordList=D("Addons://UserInfo/ActivityRecord")->getRecord($Info['id']);//活动积分记录列表
        $ShareRecordList=D("Addons://UserCenter/UserCenter")->getList($Info['id']);//推荐关注积分记录列表
        $userid=$Info['id'];
        $recordlist=$Dao->query("select * from ((select addtime,score,method as actype  from wp_newsrecord WHERE userid='$userid' ) UNION ALL  (select addtime,score,actype from wp_activityrecord WHERE userid='$userid' ) UNION ALL (select  addtime ,score,actype from wp_sharerecord WHERE lastid='$userid'and isaddscore=1 ) UNION ALL (select cTime as addtime,total_price  as score,id as actype  from wp_shop_orders WHERE openid='$openid' AND payStatus=2 AND payType='积分' ) )as a  order by a.addtime desc limit 3");
        //结束把积分记录加入数组
        //开始判断是否有资格领取红包
        $count=D('Addons://UserInfo/RedBag')->getcount($openid);
        $Config=get_addon_config('UserInfo');
        if($Info['score']>=$Config['getredbagscore'])
        {
            if($count<1) {
                $this->assign('money',101);
                $isgetredbagscore = 1;
            }
        }
        else
        {
            $isgetredbagscore=0;
        }
        //结束判断是否有资格领取红包
        //开始插入随机抽取红包用户列表
        $fakeList=D('Addons://UserInfo/RedBag')->getList();
        $this->assign('fakelist',$fakeList);
        //结束插入随机抽取红包用户列表
        $signPackage = getjssdk();
        //开始获取用户位置
        import('ORG.Net.IpLocation');// 导入IpLocation类
        $ip = get_client_ip();
        $Ip = new IpLocation('qqwry.dat'); // 实例化类 参数表示IP地址库文件
        $area = $Ip->getlocation($ip); // 获取某个IP地址所在的位置
        $area=iconv('GB2312', 'UTF-8', $area['country']);
        $area=substr($area,0,9);
        $this->assign('area',$area);
        //结束获取用户位置
        $this->assign('isgetredbagscore',$isgetredbagscore);
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('ScoreList',$List);
        $BannerList = D('Addons://UserInfo/ShopBanner')->getList("主页");//文章列表
        $Newsmap['isaddscore'] = 1;
        $Newsmap['isprivilege'] = 1;
        $Newsmap['token'] = get_token();
        $DutyList=D('Addons://UserInfo/Duty')->getList();//任务列表
        $NewsList = D('Addons://UserInfo/News')->getList($Newsmap);//文章列表
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $SignUpList=D('Addons://UserInfo/SignUp')->getTop(1);//报名活动列表
        $MembergradeMap['name']=$Info['membergrade'];
        $MemberInfo=D('Addons://UserInfo/MemberGrade')->getInfo($MembergradeMap);
        $this->assign('DutyList',$DutyList);
        $this->assign('SignUpList',$SignUpList[0]);
        $this->assign('memgradeinfo',$MemberInfo);
        $this->assign('recordlist',$recordlist);
        $this->assign('NewsRecord',$NewsRecordList[0]);
        $this->assign('GoodsList',$GoodsList);
        $this->assign('localtime',time());
        $this->assign('AcRecord',$AcRecordList[0]);
        $this->assign('ShareRecord',$ShareRecordList[0]);
        $this->assign('NewsType', $NewsTypeList);
        $this->assign('BannerList', $BannerList);
        $this->assign('NewsList', $NewsList);
        $this->assign('info', $Info);
        $this->display();
    }

    public function registered()//注册页面
    {
        $signPackage = getjssdk();
        import('ORG.Net.IpLocation');// 导入IpLocation类
        $ip = get_client_ip();
        $Ip = new IpLocation('qqwry.dat'); // 实例化类 参数表示IP地址库文件
        $area = $Ip->getlocation($ip); // 获取某个IP地址所在的位置
        $area=iconv('GB2312', 'UTF-8', $area['country']);
        $area=substr($area,0,9);
        $this->assign('area',$area);
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->display();
    }

    public function SendCode()//注册会员卡发送验证码控制器
    {
        header("Content-Type:text/html; charset=utf-8");
        $name = trim(I('name'));
        $openid = $_SESSION['openid'];
        //开始判断手机号码格式
        if (!(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $name))) {
            $this->error('手机号码格式不正确');
            exit;
        }
        $usermap['telphone'] = $name;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermap);//查询电话号码是否存在
        if (!empty($Info)&&$Info['openid']!=$openid) {
            $this->error('此手机已注册');
            exit;
        }
        $map['telphone'] = $name;
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if (!$Info) {
            $code = GetRandStr(6);
            $text = "【广州百事通】您的验证码是" . $code;
            send_sms($this->apikey, $text, $name);
            $data['telphone'] = $name;
            $data['code'] = $code;
            $data['starttime'] = time();
            $data['endtime'] = time() + 60;
            $data['openid'] = $openid;
            $data['token'] = get_token();
            $result = D('Addons://UserInfo/UserInfo')->adduser('', $data);//新增用户信息
            if ($result) {
                $this->success("验证码发送成功", U('index'));

            } else {
                $this->error("验证码发送失败");
            }
        } else if ($Info['istel'] == '0') {
            $code = GetRandStr(6);
            $text = "【广州百事通】您的验证码是" . $code;
            send_sms($this->apikey, $text, $name);
            $data['telphone'] = $name;
            $data['code'] = $code;
            $data['starttime'] = time();
            $data['endtime'] = $data['starttime'] + 60;
            $data['openid'] = $openid;
            $data['token'] = get_token();
            $map['openid'] = $openid;
            $map['telphone'] = $name;
            $result = D('Addons://UserInfo/UserInfo')->adduser($map, $data);//修改用户信息
            if ($result) {
                $this->success('发送验证码成功', U('index'));
            }
        }
        else
        {
            $this->error('此手机已存在');
        }
    }

    public function tijiao()   //注册提交会员信息控制器
    {
        header("Content-Type:text/html; charset=utf-8");
        $diaoyong = new UserInfoAddon();
        $string = "8";
        $name = trim(I('name'));
        $code = trim(I('yanzhengma'));
//        $sex = I('sex');
//        $data['sex'] = $sex;
        $data['istel'] = '1';
        $data['addtime'] = time();
        $map['telphone'] = $name;
        $map['code'] = $code;
        $localtime = time();
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if (!$Info) {
            $this->error('请先获取验证码哦');
        }
        $length = strlen($Info['id']);
        $str = 8 - $length;
        for ($i = 1; $i < $str; $i++) {
            $string = $string . "0";
        }
//        $data['userid'] = $string . $Info['id'];
        $data['userid'] =$name;
        if ($Info['endtime'] > $localtime) {  //判断验证码是否过期
            if ($Info) {
                $data['qrcode'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($Info['id']);
                $result = D('Addons://UserInfo/UserInfo')->adduser($map, $data);//保存会员信息
                if ($result) {
//                    //开始发送两种奖品
//                    $ordermap['id']=41;
//                    $product1=D('Addons://Shop/Products')->getInfo($ordermap);
//                    $ordermaps['id']=42;
//                    $product2=D('Addons://Shop/Products')->getInfo($ordermaps);
//                    $orderdata['endtime']=$product1['endtime'];
//                    $orderdata['product_id']=$product1['id'];
//                    $orderdata['storeid']=$product1['storeid'];
//                    $orderdata['isuse']=0;
//                    $orderdata['title']=$product1['name'];
//                    $orderdata['payType']='积分';
//                    $orderdata['openid']=$_SESSION['openid'];
//                    $orderdata['token']=get_token();
//                    $orderdata['total_price']=$product1['true_price'];
//                    $orderdata['cTime']=time();
//                    $orderdata['payTime']=time();
//                    $orderdata['payStatus']=2;
//                    $query=M('shop_orders')->add($orderdata);
//
//                    $orderdatas['endtime']=$product2['endtime'];
//                    $orderdatas['product_id']=$product2['id'];
//                    $orderdatas['storeid']=$product2['storeid'];
//                    $orderdatas['isuse']=0;
//                    $orderdatas['title']=$product2['name'];
//                    $orderdatas['payType']='积分';
//                    $orderdatas['openid']=$_SESSION['openid'];
//                    $orderdatas['token']=get_token();
//                    $orderdatas['total_price']=$product2['true_price'];
//                    $orderdatas['cTime']=time();
//                    $orderdatas['payTime']=time();
//                    $orderdatas['payStatus']=2;
//                    if($query) {
//                        $query1 = M('shop_orders')->add($orderdatas);
//                    }
//                    //结束发送两种奖品

                    $this->success('注册成功', 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');

                } else {
                    $this->error('注册失败');
                }
            } else {
                $this->error('验证码错误');
            }
        } else {
            $result = D('Addons://UserInfo/UserInfo')->deluser($map);//删除会员信息
            $this->error('验证码已过期');
        }
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
            $usermaps['openid'] = $id[1];
            $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermaps);//推荐阅读用户信息
            if (!$Info) {
                $this->error('此会员不存在');
            }
            if ($openid != $id[1])//如果是推荐好友阅读
            {
                $readmap['userid']=$Info['id'];
                $readmap['newsid']=$id[0];
                $readmap['recommendedopenid']=$openid;
                $readmap['token']=get_token();
                $count=D('Addons://UserInfo/NewsRecord')->getcount($readmap);
                if($count<1) {
                    $query = D('Addons://UserInfo/News')->addscore($id[1], $id[0], $id[2], $openid);//给推荐用户增加积分
                    $recordmap['newsid'] = $id[0];
                    $recordmap['userid'] = $Info['id'];
                    $recordmap['token']=get_token();
                    $recordmap['method']='分享给好友阅读文章';
                    $allcount = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//转发总次数
                    if($NewsList['dutyid']!=0)//如果任务id不为空
                    {
                        $dutyinfo=D('Addons://UserInfo/Duty')->getInfo($NewsList['dutyid']);//任务信息
                        if($dutyinfo['newsid']==$NewsList['id']) {//如果任务文章对应当前文章
                            $nowtime=time();
                            if ($nowtime >= $dutyinfo['begintime'] && $nowtime < $dutyinfo['endtime']) {
                                //开始获取单个用户记录条数
                                $dutymap['openid'] = $id[1];
                                $dutymap['dutyid'] = $dutyinfo['id'];
                                $dutymap['token'] = get_token();
                                $dutycount = D('Addons://UserInfo/DutyRecord')->getcount($dutymap);
                                $allmap['dutyid'] = $dutyinfo['id'];
                                $allmap['token'] = get_token();
                                $totalcount= D('Addons://UserInfo/DutyRecord')->getcount($allmap);
                                //结束获取单个用户记录条数
                                if ($dutyinfo['count'] == $allcount)//如果完成任务
                                {
                                    if ($dutycount < 1) {//如果没做过当前任务
                                        if($totalcount<$dutyinfo[''])
                                            $dutyrecord['dutyname'] = $dutyinfo['name'];
                                        $dutyrecord['token'] = get_token();
                                        $dutyrecord['addtime'] = time();
                                        $dutyrecord['openid'] = $id[1];
                                        $dutyrecord['dutyid'] = $dutyinfo['id'];
                                        D('Addons://UserInfo/DutyRecord')->addrecord($dutyrecord);//新增完成任务记录
                                        $diao=new SendTempleMessageAddon();
                                        $goodsmap['id']=$dutyinfo['goodsid'];
                                        $goodsinfo= D('Addons://Shop/Products')->getInfo($goodsmap);//商品信息
                                        $template=$diao->templete3($id[1],'恭喜您获得参加今晚秒杀'.$goodsinfo['name'].'商品的资格','今天'.date('H:i',$goodsinfo['seckilltime']).'准时开秒，数量有限，秒完即止.',date('Y-m-d',$goodsinfo['seckilltime']),'请点击详情查看今晚秒杀商品.',"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/Shop/Index/productinfo/id/".$goodsinfo['id']."html&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect");
                                        $diao->sendtempmsg(urldecode($template));
                                    }
                                }
                            }
                        }
                    }
                    $Info = D('Addons://UserInfo/UserInfo')->getInfo($usermaps);//阅读用户信息
                    if ($query) {
                        //开始判断此用户此文章是否到达上限
                        //结束判断此用户此文章是否到达上限
                        if($allcount==$NewsList['sharecounttotal']) {//如果到达上限就发送模版消息
                            $diaoyong = new UserInfoAddon();
                            $localtime = date('Y-m-d H:i', time());//当前时间
                            $template = $diaoyong->subscribe($id[1], $localtime, $NewsList['sharescore']*$NewsList['sharecounttotal'], '推荐好友阅读送积分', $Info['score'], $Info['nickname'],$NewsList['title']);
                            $diaoyong->sendtempmsg(urldecode($template));
                        }
                    }
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
                $query = D('Addons://UserInfo/News')->addscore($openid, $id, 'r','');//文章增加积分

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

    public function sharenews()//分享文章控制器
    {
        $openid = I('openid');
        $id = I('newsid');//文章id
        $method = I('method');//分享方式
        D('Addons://UserInfo/News')->addscore($openid, $id, $method);//文章增加积分
    }


    public function newslist()//文章列表视图
    {
        $id = I('id');//文章类型id
        $map['classifyid'] = $id;
        $map['token'] = get_token();
        $NewsList = D('Addons://UserInfo/News')->getList($map);//文章列表
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('NewsList', $NewsList);
        $this->display();
    }

    public function qiandao($typeid = 1)//签到控制器
    {
        $type = I('type');
        if (!empty($type)) {
            $typeid = $type;
        }
        $localtime = date('Y-m-d', time());//当前日期
        $qiandaoinfo = D('Addons://UserInfo/Acctivity')->getInfo($typeid);//活动信息
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $count = D('Addons://UserInfo/ActivityRecord')->getcount($Info['id'], $typeid);//当前用户当天活动次数
        $SignInfo=D('Addons://UserInfo/ActivityRecord')->getList($Info['id'],$qiandaoinfo['id']);//用户最新签到数据
        if(($localtime-strtotime($SignInfo['date']))>24*60*60)//当不是连续签到时
        {
            $allcount=1;
        }
        else {
            $allcount = $Info['signcount'];//当前用户连续签到次数
        }
//        $this->error(D('Addons://UserInfo/ActivityRecord')->getList($Info['id'],$qiandaoinfo['id']));
        $totalcount = D('Addons://UserInfo/ActivityRecord')->getallcount($Info['id'], $qiandaoinfo['id']);//签到总次数
        if ($count < $qiandaoinfo['count'])//如果当天未达到活动次数
        {
            if ($totalcount < 1)//如果从未做过此活动
            {
                $query = D('Addons://UserInfo/UserInfo')->addscore($openid, $qiandaoinfo['firstscore']);//增加用户积分
                $signquery = D('Addons://UserInfo/ActivityRecord')->addrecord($Info, $qiandaoinfo,$qiandaoinfo['firstscore']);//新增活动记录
//                $this->error($query);
            } else {
                if ($allcount >= $qiandaoinfo['increasetime'])//触发连续活动启动时间
                {

                    D('Addons://UserInfo/UserInfo')->addscore($openid, $qiandaoinfo['score'] + $qiandaoinfo['increasescore']);//增加用户积分
                    $signquery = D('Addons://UserInfo/ActivityRecord')->addrecord($Info, $qiandaoinfo,$qiandaoinfo['score'] + $qiandaoinfo['increasescore']);//新增活动记录
                } else {
                    D('Addons://UserInfo/UserInfo')->addscore($openid, $qiandaoinfo['score']);//增加用户积分
                    $signquery = D('Addons://UserInfo/ActivityRecord')->addrecord($Info, $qiandaoinfo,$qiandaoinfo['score'] );//新增活动记录
                }
            }
//            $signquery = D('Addons://UserInfo/ActivityRecord')->addrecord($Info, $qiandaoinfo);//新增活动记录
            $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
            $allcount = $Info['signcount'];//当前用户连续签到次数
            if ($localtime == date('Y-m-d', $qiandaoinfo['stime']))//如果为抽奖日期
            {
                $diaoyong = new UserInfoAddon();
                $randnum = rand(1, 10000);//中奖随机数
                if ($qiandaoinfo['jpsl'] > 0) {//如果中一等奖
                    if ($randnum <= $qiandaoinfo['zjgl']) {
                        $query = D('Addons://UserInfo/Prize')->addrecord($Info, '一等奖', $qiandaoinfo);//新增活动记录
                        //开始发送短信
                        $text = "【百事通】恭喜中得一等奖，请查看公众号领取微信红包吧";
//                        send_sms($this->apikey, $text, $Info['telphone']);
                        //结束发送短信

                        //开始减少奖品数量
                        $query = D('Addons://UserInfo/Acctivity')->reduceprize($qiandaoinfo, 'jpsl');
                        //结束减少奖品数量

//
//                        //开始发送模板消息
//                        $template = $diaoyong->sendjson($openid, '签到抽奖活动', '一等奖', '');
//                        $sendmes = $diaoyong->sendtempmsg(urldecode($template));
//                        //结束发送模板消息
//
//                        //开始发送微信红包
//                        $str=U('sendredpacks',array('openid'=>$openid,'money'=>'101','token'=>get_token()));
//                        $str_url=urlencode($str);
//                        $appid = $this->appid;
//                        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$str_url.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
                        //结束发送微信红包
                        if ($signquery) {
                            $this->success($qiandaoinfo['successtext'] . "<br/>您已成功参加活动" . $allcount . "天" . '恭喜您已获得一等奖，请注意查看模板消息和短信哦',U('sendredpacks'));
                        } else {
                            $this->error('网络有延迟哦');
                        }
                    }
                }
                if ($qiandaoinfo['secondjpsl'] > 0) {//如果中二等奖
                    if ($randnum <= $qiandaoinfo['secondzjgl']) {
                        $CouPon = D('Addons://UserInfo/Coupons')->getInfo(1);//随机优惠券信息
                        $query = D('Addons://UserInfo/Prize')->addrecord($Info, '二等奖', $qiandaoinfo);//新增活动记录
                        //开始发送短信
                        $text = "【百事通】恭喜中得二等奖" . $qiandaoinfo['secondname'] . '，电子口令为' . $CouPon['num'];
                        send_sms($this->apikey, $text, $Info['telphone']);
                        //结束发送短信

                        //开始减少奖品数量
                        $query = D('Addons://UserInfo/Acctivity')->reduceprize($qiandaoinfo, 'secondjpsl');
                        //结束减少奖品数量


                        D('Addons://UserInfo/Coupons')->isuse($CouPon['id']);//把优惠券改为已使用状态
                        //开始发送模板消息
                        $template = $diaoyong->sendjson($openid, '签到抽奖活动', '二等奖', $CouPon['num']);
                        $sendmes = $diaoyong->sendtempmsg(urldecode($template));
                        //结束发送模板消息
                        if ($signquery) {
                            $this->success($qiandaoinfo['successtext'] . "<br/>您已成功参加活动" . $allcount . "天" . '恭喜您已获得二等奖，请注意查看模板消息和短信哦');
                        } else {
                            $this->error('网络有延迟哦');
                        }
                    }
                }
                /*   if ($qiandaoinfo['thirdjpsl'] > 0) {//如果中三等奖
                      if ($randnum <= $qiandaoinfo['thirdzjgl']) {
                          $query = D('Addons://UserInfo/Prize')->addrecord($Info, '三等奖', $qiandaoinfo);//新增活动记录
                          //开始发送短信
                          $text = "【百事通】恭喜中得三等奖" . $qiandaoinfo['thirdname'] . '，去我的优惠券里面就能看到了哦';
                          send_sms($this->apikey, $text, $Info['telphone']);
                          //结束发送短信

                          //开始减少奖品数量
                          $query = D('Addons://UserInfo/Acctivity')->reduceprize($qiandaoinfo, 'thirdjpsl');
                          //结束减少奖品数量

                          //开始发送优惠券
                          $query = D('Addons://UserInfo/Coupons')->updatecoupons($Info, $qiandaoinfo);
                          //结束发送优惠券

                          //开始发送模板消息

                          $template = $diaoyong->sendjson($openid, '签到抽奖活动', '三等奖', '');
                          $sendmes = $diaoyong->sendtempmsg(urldecode($template));
                          //结束发送模板消息
                          if ($signquery) {
                              $this->success($qiandaoinfo['successtext'] . "您已成功参加活动" . $allcount . "天" . '恭喜您已获得三等奖，请注意查看模板消息和短信哦');
                          } else {
                              $this->error('网络有延迟哦');
                          }
                      }
                  } */
            }
            if ($signquery) {
                $this->success($qiandaoinfo['successtext'] . "<br/>您已成功参加活动" . $allcount . "天");
            } else {
                $this->error('网络有延迟哦');
            }
        } else {
            if ($typeid == 1) {
                $this->error('您当天已签到过');
            }
        }

    }

    public function prize($typeid = 1)//中奖页面
    {
        $prize = I('state');//中奖级别
        $qiandaoinfo = D('Addons://UserInfo/Acctivity')->getInfo($typeid);//日常签到信息
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('info', $qiandaoinfo);
        $this->assign('prize', $prize);
        $this->display();
    }



//   public function createqrcode()
//   {
////       header("Content-Type:image/jpg; charset=utf-8;");
//       $diaoyong=new UserInfoAddon();
//       $img=$diaoyong->createqrcode();
//       header("Location:https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$img");
//       $this->assign('img',$img);
//       $this->display();
//   }


    public function test()
    {
        header("Content-Type:text/html; charset=utf-8");
        $Mo = M('reduceprice');
        $usermo = M('baozouuser');
        $userlist = $usermo->where("isuse=0")->order('id desc')->limit(500)->select();
        foreach ($userlist as $val) {
            $specount = rand(1, 5);
            $usercount = rand(1, 2);
            $xingcount = rand(0, 79);//姓随机数
            $mingcount = rand(0, 98);//名随机数
            $xing = $this->getxing($xingcount);
            if ($usercount == 2) {
                $mingcounts = rand(0, 98);//名随机数
                $ming = $this->getming($mingcount) . $this->getming($mingcounts);
            } else {
                $ming = $this->getming($mingcount);
            }
            $specialcount = $this->getspecial($specount);
            $pricecount = rand(1, 100);
            $tourid = rand(1, 4);
            $data['tourid'] = $tourid;
            $tourmo = M('reducetour');
            $tourinfo = $tourmo->where("id='$tourid'")->find();
            $data['price'] = $tourinfo['initprice'] - $pricecount;
            $data['username'] = $xing . $ming;
            $data['telphone'] = "1" . $this->random(1, "tel") . $this->random(9, "number");
            $data['nickname'] = $specialcount;
            $data['addtime'] = time();
            $data['islimit'] = 0;
            $data['token'] = 'gh_4fc719089612';
            $id = $val['id'];
            $data['openid'] = $val['oauth'];
            $Mo->add($data);
            $userdata['isuse'] = 1;
            $usermo->where("id='$id'")->save($userdata);
        }
    }

    function random($length = 6, $type = 'string', $convert = 0)
    {
        header("Content-Type:text/html; charset=utf-8");
        $config = array(
            'tel' => '358',
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );

        if (!isset($config[$type])) $type = 'string';
        $string = $config[$type];

        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if (!empty($convert)) {
            $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
        }
        return $code;
    }

    function getxing($number)
    {
        $arr = ['赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '楮', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '伍', '余', '元', '卜', '顾', '孟', '平', '黄', '和', '穆', '萧', '尹', '姚', '邵', '湛', '汪', '祁', '毛', '禹', '狄', '米', '贝', '明', '臧', '计', '伏', '成', '戴', '谈', '宋', '茅', '庞', '熊', '纪', '舒', '屈', '项', '祝', '董', '梁', '杜', '阮', '蓝', '闽', '席', '季', '麻', '强'];
        return $arr[$number];
    }

    function getming($number)
    {
        $arr = ['成', '风', '云', '功', '禾', '诗', '丁', '林', '其', '立', '合', '春', '亮', '君', '生', '谂', '全', '节', '淑', '国', '卫', '飞', '英', '慕', '楠', '本', '坚', '伟', '龙', '艺', '聪', '志', '峰', '韵', '宏', '基', '小', '春', '德', '华', '雨', '声', '至', '言', '颖', '嘉', '怡', '艺', '俊', '林', '成', '丽', '君', '心', '仪', '廉', '壮', '旭', '阳', '希', '捷', '书', '怡', '思', '欣', '飞', '鸿', '文', '娜', '慧', '琳', '翠', '茹', '盛', '威', '伟', '业', '毅', '东', '嘉', '明', '杰', '全', '伟', '顺', '海', '生', '财', '鹏', '海', '怡', '琪', '琪', '悟', '空', '金', '娥', '玉', '建'];

        return $arr[$number];
    }

    function  getspecial($number)
    {
        $special = "";
        $arr = ['成', '风', '云', '功', '禾', '诗', '丁', '林', '其', '立', '合', '春', '亮', '君', '生', '谂', '全', '节', '淑', '国', '卫', '飞', '英', '慕', '楠', '本', '坚', '伟', '龙', '艺', '聪', '志', '峰', '韵', '宏', '基', '小', '春', '德', '华', '雨', '声', '至', '言', '颖', '嘉', '怡', '艺', '俊', '林', '成', '丽', '君', '心', '仪', '廉', '壮', '旭', '阳', '希', '捷', '书', '怡', '思', '欣', '飞', '鸿', '文', '娜', '慧', '琳', '翠', '茹', '盛', '威', '伟', '业', '毅', '东', '嘉', '明', '杰', '全', '伟', '顺', '海', '生', '财', '鹏', '海', '怡', '琪', '琪', '悟', '空', '金', '娥', '玉', '建', '︻', '︼', '︽', '︾', '〒', '↑', '↓', '☉', '⊙', '●', '〇', '◎', '¤', '★', '☆', '■', '▓', '「', '」', '『', '』', '◆', '◇', '▲', '△', '▼', '▽', '◣', '◥', '◢', '◣', '◤', '◥', '№', '↑', '↓', '→', '←', '↘', '↙', 'Ψ', '※', '㊣', '∑', '⌒', '∩', '【', '】', '〖', '〗', '＠', 'ξ', 'ζ', 'ω', '□', '∮', '〓', '※', '》', '∏', '卐', '√', '╳', '々', '♀', '♂', '∞', '①', 'ㄨ', '≡', '╬', '╭', '╮', '╰', '╯', '╱', '╲'];
        for ($i = 0; $i < $number; $i++) {
            $randcount = rand(0, sizeof($arr) - 1);
            $str = $arr[$randcount];
            $special .= $str;
        }
        return $special;
    }
//    function impUser(){//导入csv数据
//        if (!empty($_FILES)) {
//            $filename = $_FILES['tmp_name']['name'];
//            if (empty ($filename)) {
//                echo '请选择要导入的CSV文件！';
//                exit;
//            }
//             $handle = fopen('./Uploads/'.$filename,'r');;
//            $arr = array();
////循环取出 文件中数据
//            while($data = fgetcsv($handle)){
//
//                $arr[]=$data;
//
//            }
//            foreach($arr as $k=>$val){
////去除表头
//                if($k == 0){
//                    continue;
//                }
//                $oauth = iconv('gbk','utf-8',$val['6']);//中文转码
//                $telphone=iconv('gbk','utf-8',$val['5']);//中文转码
//                $Mo=M('vtuser');
//                $datas['openid']=$oauth;
//                $datas['telphone']=$telphone;
//                $Mo->add($datas);
//            }
//
//        }else
//        {
//            $this->error("请选择上传的文件");
//        }
//
//    }

//开始发送微信红包
    public function sendredpack()//公众号向用户发红包一级控制器
    {
        header("Content-type: text/html; charset=utf-8");
        $member_public=M('member_public');
        $token=get_token();
        $member_public=$member_public->where("token='$token'")->find();
        $openid=I('openid');
        $money=I('money');
        $str=U('sendredpacks',array('openid'=>$openid,'money'=>$money,'token'=>get_token()));

        $str_url=urlencode($str);


        $appid = $member_public['appid'];
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$str_url.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';

        header("Location:".$url);
    }

    public function sendredpacks()//公众号向用户发红包二级控制器
    {
        header("Content-type: text/html; charset=utf-8");
        $UpayConfig=getAddonConfig('Upay');
        $member_public=M('member_public');
        $UserMo=M('userinfo');
        $token=get_token();
        $member_public=$member_public->where("token='$token'")->find();
        $openids=$_SESSION['openid'];
        $moneys=rand(101,500);
        $appid = $member_public['appid'];
        $secret = $member_public['secret'];
        $code = $_GET["code"];
//var_dump($code);
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
// echo "<br/>".$get_token_url."<br/>";
//请求链接获取openid
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $get_token_url);

        $res = curl_exec($curl);
        curl_close($curl);

//var_dump($res);
        $json_obj = json_decode($res,true);
//获取openid
//        $access_token = $json_obj['access_token'];
//        $openids = $json_obj['openid'];
//        var_dump($json_obj);
//        exit;
        $Year=date('Y',time());//获取年份2016
        $month=date('m',time());//获取月份
        $day=date('d',time());//获取天数
        $mch_appid=$appid;
        $mchid=$UpayConfig['MCHID'];//商户号
        $rand=GetRandStr(10);
        $nonce_str=generate_password(16);//随机数
        $partner_trade_no=$mchid.$Year.$month.$day.$rand;//商户订单号
        $openid;
        if(!empty($openids)) {
            $openid = $openids;//用户唯一标识
        }
        if(empty($openid))
        {
            $this->error('网络有错误哦');
        }
        $map['openid']=$openid;
        $UserFind=$UserMo->where($map)->find();
        if(!$UserFind)
        {
            exit;
        }
        $wishing="恭喜获得现金红包，努力赚取积分还能兑换更多的奖品哦！";//红包祝福语
        $act_name="成为百事通会员";//活动名称
        $sremark="猜越多得越多，快来抢！";//备注
        $total_num=1;//
        $total_amount;
        if(!empty($moneys)) {
            $total_amount = $moneys;//
        }
        $send_name="广州百事通";//
        $spbill_create_ip=$_SERVER["REMOTE_ADDR"];//请求ip$_SERVER["REMOTE_ADDR"]

//封装数组
        $dataArr=array();
        $dataArr['mch_billno']=$partner_trade_no;//商户订单号
        $dataArr['mch_id']=$mchid;//商户号
        $dataArr['wxappid']=$mch_appid;//公众号appid
        $dataArr['send_name']=$send_name;//红包发送者名称
        $dataArr['re_openid']=$openid;//用户相对于公众号的唯一ID
        $dataArr['total_amount']=$total_amount;//发放总金额1-200元之间
        $dataArr['total_num']=$total_num;//发放数量
        $dataArr['wishing']=$wishing;//祝福语
        $dataArr['client_ip']=$spbill_create_ip;//客户端ip
        $dataArr['act_name']=$act_name;//活动名称
        $dataArr['remark']=$sremark;//备注
        $dataArr['nonce_str']=$nonce_str;//随机数
        $sign=$this->getSign($dataArr);


//echo "-----<br/>签名：".$sign."<br/>*****";//die;
        $data="<xml>
<sign><![CDATA[".$sign."]]></sign>
<mch_billno><![CDATA[".$partner_trade_no."]]></mch_billno>
<mch_id><![CDATA[".$mchid."]]></mch_id>
<wxappid><![CDATA[".$mch_appid."]]></wxappid>
<send_name><![CDATA[".$send_name."]]></send_name>
<re_openid><![CDATA[".$openid."]]></re_openid>
<total_amount><![CDATA[".$total_amount."]]></total_amount>
<total_num><![CDATA[".$total_num."]]></total_num>
<wishing><![CDATA[".$wishing."]]></wishing>
<client_ip><![CDATA[".$spbill_create_ip."]]></client_ip>
<act_name><![CDATA[".$act_name."]]></act_name>
<remark><![CDATA[".$sremark."]]></remark>
<nonce_str><![CDATA[".$nonce_str."]]></nonce_str>
</xml>";
//var_dump($data);
        $ch = curl_init ();
//红包链接
        $MENU_URL="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
        curl_setopt ( $ch, CURLOPT_URL, $MENU_URL );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
//        U('Public/zhengshu/apiclient_cert.pem');
//        $zs1=$member_public['cert'];
//        $zs2=$member_public['key'];
//        $zs1=substr($zs1,1);
//        $zs2=substr($zs2,1);
        $zs1="Uploads/Download/zhengshu/apiclient_cert.pem";
//        $zs1=$member_public['cert'];
        $zs2="Uploads/Download/zhengshu/apiclient_key.pem";
//        $zs2=$member_public['key'];
        curl_setopt($ch,CURLOPT_SSLCERT,$zs1);
        curl_setopt($ch,CURLOPT_SSLKEY,$zs2);
// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01;
// Windows NT 5.0)');
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );

        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $info = curl_exec ( $ch );
        $info=urlencode($info);
//        $xml = simplexml_load_string($info);
//        $info = json_decode(json_encode($xml),true);
        if (curl_errno ( $ch )) {
//            echo 'Errno' . curl_error ( $ch );
            $this->error( curl_error ( $ch ));
        }
        curl_close ( $ch );
        $this->success($info);
//        $this->assign('info',$info);
//        echo "-----<br/>请求返回值：";
//        var_dump($info);
//        $this->display();
    }


    public  function addredpack()//插入红包记录
    {
        $money=I('total_amount');
        $data['openid']=I('re_openid');
        $data['mch_billno']=I('mch_billno');
        $data['mch_id']=I('mch_id');
        $data['money']=substr($money,0,1).'.'.substr($money,1,2);
        $data['addtime']=time();
        $data['orderid']=I('send_listid');
        $data['method']=I('method');
        $data['nickname']=I('nickname');
        $data['token']=get_token();
        D('Addons://UserInfo/RedBag')->addrecord($data);
    }


    function formatBizQueryParaMap($paraMap, $urlencode)
    {
//        var_dump($paraMap);//die;
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
//        var_dump($reqPar);//die;
        return $reqPar;
    }

    /**
     * 	作用：生成签名
     */
    function getSign($Obj)
    {
        $UpayConfig=getAddonConfig('Upay');
        $key=$UpayConfig['KEY'];
//        var_dump($Obj);//die;
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=$key";
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }
    //结束发送微信红包


    public function mygoods()//我的商品视图(可核销)
    {
        $openid=$_SESSION['openid'];
        $GoodList=D("Addons://Shop/Order")->getList($openid);
        $this->assign('GoodList',$GoodList);
        $signPackage = getjssdk();
        $this->assign('localtime',time());
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->display();
    }

    public function myscorerecord()//积分明细
    {
        $Dao=M();
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if(!$Info)
        {
            $this->error('未注册或无效链接');
        }
        $userid=$Info['id'];
//        $NewsRecordList=D("Addons://UserInfo/NewsRecord")->getList($Info['id']);//文章积分记录列表
//        $AcRecordList=D("Addons://UserInfo/ActivityRecord")->getRecord($Info['id']);//文章积分记录列表
//        $ShareRecordList=D("Addons://UserCenter/UserCenter")->getList($Info['id']);//推荐关注积分记录列表
//        $OrderList= $Dao->query("select a.total_price,a.isuse,a.title,b.head_img,a.payType,a.id,a.cTime from wp_shop_orders a LEFT JOIN wp_shop_products b ON a.product_id=b.id WHERE a.openid='$openid' AND a.payStatus=2 AND a.payType='积分' ORDER BY a.cTime desc ");
        $signPackage = getjssdk();

        $list=$Dao->query("select * from ((select addtime,score,method as actype  from wp_newsrecord WHERE userid='$userid' ) UNION ALL  (select addtime,score,actype from wp_activityrecord WHERE userid='$userid') UNION ALL (select  addtime ,score,actype from wp_sharerecord WHERE lastid='$userid' and isaddscore=1) UNION ALL (select cTime as addtime,total_price  as score,id  from wp_shop_orders WHERE openid='$openid' AND payStatus=2 AND payType='积分' ) )as a  order by addtime desc");
        $this->assign('list',$list);
        $this->assign('appid', $this->appid);
//        $this->assign('OrderList',$OrderList);
        $this->assign('signPackage', $signPackage);
//        $this->assign('NewsRecord',$NewsRecordList);
//        $this->assign('AcRecord',$AcRecordList);
//        $this->assign('ShareRecord',$ShareRecordList);
        $this->display();
    }

    public function tosubscribe()//关注二维码页面
    {
        $this->display();
    }
    public function howtogetscore()
    {
        header("Content-type: text/html; charset=utf-8");
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('info',$Info);
        $this->display();
    }

    public function myinfo()//我的资料视图
    {
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if(IS_AJAX)
        {
            $sex=I('sex');//性别
            $truename=I('truename');//真实姓名
            $birth=I('birth');//生日
            $data['sex']=$sex;
            $data['birth']=$birth;
            $data['truename']=$truename;
            $query= D('Addons://UserInfo/UserInfo')->adduser($map, $data);//修改用户信息

            $qiandaoinfo = D('Addons://UserInfo/Acctivity')->getInfo(3);//活动信息
            $totalcount = D('Addons://UserInfo/ActivityRecord')->getallcount($Info['id'], $qiandaoinfo['id']);//签到总次数
            if($totalcount<1) {//如果完善资料没有加过积分
                D('Addons://UserInfo/UserInfo')->addscore($openid, $qiandaoinfo['score']);//增加用户积分
                D('Addons://UserInfo/ActivityRecord')->addrecord($Info, $qiandaoinfo, $qiandaoinfo['score']);//新增活动记录
                $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
                $diaoyong = new UserInfoAddon();
                $localtime = date('Y-m-d H:i', time());//当前时间
                $template = $diaoyong->subscribe($openid, $localtime, $qiandaoinfo['score'], '完善资料送积分', $Info['score'], $Info['nickname'],'');
                $diaoyong->sendtempmsg(urldecode($template));
            }
            $this->success('修改成功');


        }
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('info',$Info);
        $this->display();
    }
    public function forwardnews()//转发文章列表
    {
        $Newsmap['isaddscore'] = 1;
        $Newsmap['isprivilege'] = 1;
        $Newsmap['is_show']=1;
        $Newsmap['token'] = get_token();
        $Newsmap['dutyid']=array('eq',0);
        $NewsList = D('Addons://UserInfo/News')->getList($Newsmap);//文章列表
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('NewsList', $NewsList);
        $this->display();
    }


    public function mypayrecord()//购买记录
    {
        $Dao=M();
        $openid=$_SESSION['openid'];
        $OrderList= $Dao->query("select a.total_price,a.isuse,a.title,b.head_img,a.payType,a.id,a.cTime from wp_shop_orders a LEFT JOIN wp_shop_products b ON a.product_id=b.id WHERE a.openid='$openid' AND a.payStatus=2 AND a.payType='元' ORDER BY a.cTime desc ");
        $this->assign('PayList',$OrderList);
        $this->display();
    }

//    public function create()//一键生成二维码
//    {
//        $diaoyong=new UserInfoAddon();
//        $Mo=M('userinfo');
//        $list=$Mo->where("id>=3604 and id<4172")->select();
//        foreach($list as $val)
//        {
//            $id=$val['id'];
//            $qrcode= "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($id);
//            $data['qrcode']=$qrcode;
//            $Mo->where("id='$id'")->save($data);
//        }
//    }

    public function dutycontent()//任务详情页
    {
        $id=I('id');
        $dutyinfo=D('Addons://UserInfo/Duty')->getInfo($id);//任务信息
        $newsid=$dutyinfo['newsid'];
        $map['id'] = $newsid;
        $NewsList = D('Addons://UserInfo/News')->getInfo($map);//文章信息
        $goodsmap['id']=$dutyinfo['goodsid'];
        $goodsinfo= D('Addons://Shop/Products')->getInfo($goodsmap);//商品信息
        $signPackage = getjssdk();
        $this->assign('signPackage', $signPackage);
        $this->assign('NewsInfo',$NewsList);
        $this->assign('GoodsInfo',$goodsinfo);
        $this->assign('DutyInfo',$dutyinfo);
        $this->assign('NewsList', $NewsList);
        $this->assign('appid',$this->appid);
        $this->assign('openid',$_SESSION['openid']);
        $this->display();
    }
    public function testcontent()
    {
        $info=file_get_contents('http://mp.weixin.qq.com/s?__biz=MjM5ODUzMDA4MA==&mid=2707494129&idx=1&sn=f6489d1955e1ac70fef3e38f2b860295&scene=4#wechat_redirect');
        var_dump($info);
        exit;
        $this->assign('info',$info);
        $this->display();
    }







}
