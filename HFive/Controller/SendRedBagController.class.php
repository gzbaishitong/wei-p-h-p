<?php

namespace Addons\HFive\Controller;
use Addons\UserInfo\UserInfoAddon;
use Home\Controller\AddonsController;
use Think\Crypt\Driver\Think;

//广州好招职作为服务号
class SendRedBagController extends AddonsController{
    public $appid = 'wx7108a60f6ce26947';
    public $secret = 'ac7db62865f421069477aa5ea9ed61aa';
    function _initialize()
    {

    }
    public function beforeindex()//摇一摇视图
    {
       $totalmoney= M('redbagrecord')->where("method='关注5个公众号送红包'")->sum('money');
       if($totalmoney>=3000)
       {
           redirect(U('finish'));
       }
        $state=I('state');
        $state=explode('|',$state);
        $token=$state[0];
        $lastid=$state[1];//推荐人id
        $lastinfo=M('redbaguser')->where("id='$lastid'")->find();
        $code=I('code');
        if ($code != "" &&get_token()!=$token) {
            session('token',$token);
           $publicinfo= get_token_appinfo();
            getopenid($publicinfo['appid'], $publicinfo['secret'], $code);
        }
        $openid=$_SESSION['openid'];
        $isplay=M('redbaguser')->where("(openid='$openid' or openid1='$openid') and number!=0 ")->find();//判断用户是否玩过
        if($isplay)
        {
            redirect('http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect');
        }
        if($lastinfo)//如果找到推荐人信息
        {
            $diaoyong=new UserInfoAddon();
            $img=$lastinfo['qrcode1'];
            $this->assign('img',$img);
        }
//        $locationMo=M('userlocation');
//        $map['token']=get_token();
        $map['openid']=$openid;
//        $locatioinfo=$locationMo->where($map)->find();
        $signPackage = getjssdk();
//        if($locatioinfo)
//        {
//            $this->assign('locatioinfo',$locatioinfo);
//        }
        $userinfo= M('redbaguser')->where($map)->find();//用户信息
        $this->assign('userinfo',$userinfo['openid']);
        $this->assign('headimgurl',$_SESSION['userinfo']);
        $this->assign('openid',$_SESSION['openid']);
        $this->assign('signPackage', $signPackage);
        $this->assign('id',$userinfo['id']);
        $this->display();
    }

    public function qrcode()//公众号链接
    {
        $state=I('state');
        if(!empty($state))
        {
            $state=explode('|',$state);
            $token=$state[0];
//            $id=$state[1];
//            $limit=$state[2];
            $limit=$state[1];
            $code=I('code');
            if ($code != "" &&get_token()!=$token) {
                session('token',$token);
                $publicinfo= get_token_appinfo();
                getopenid($publicinfo['appid'], $publicinfo['secret'], $code);
            }
            $openid=$_SESSION['openid'];
            $map['openid']=$openid;
            $userinfo= M('redbaguser')->where($map)->find();//用户信息
            setcookie("userid", $userinfo['id']);
        }
        if(!$userinfo)
        {
            redirect("http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect");
        }
        if($userinfo['number']==5)
        {
            redirect("http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect");
        }
        if($userinfo['number']<=$limit)
        {
            $data['number']=$limit;
            M('redbaguser')->where("openid='$openid'")->save($data);
        }
        else
        {
            redirect("http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect");
        }
        switch($limit)
        {
            case 1:
                $qrcode="http://oboo4n5lb.bkt.clouddn.com/xingshe.jpg";
                break;
            case 2:
                $qrcode="http://oboo4n5lb.bkt.clouddn.com/guangfo.jpg";
            break;
            case 3:
                $qrcode="http://oboo4n5lb.bkt.clouddn.com/lvxing.jpg";
                break;
            case 4:
                $qrcode="http://oboo4n5lb.bkt.clouddn.com/405929437083001776.jpg";
                break;
            case 5:
                $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx2cc9c898d1d091b9&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/HFive/SendRedBag/complete&response_type=code&scope=snsapi_userinfo&state=gh_6b887787bf3f|5#wechat_redirect";
                break;
        }
        $this->assign('limit',$limit);
        $this->assign('qrcode',$qrcode);
        $this->display();
    }

    public function complete()//完成任务视图
    {
        $userid=$_COOKIE["userid"];//用户id
        $state=I('state');
        $type=I('type');
        if(!empty($state))
        {
            $state=explode('|',$state);
            $token=$state[0];
//            $id=$state[1];
//            $limit=$state[2];
            $limit=$state[1];
            if($limit!=5)
            {
                redirect("http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect");
            }
            $code=I('code');
            if ($code != "" &&get_token()!=$token) {
                session('token',$token);
                $publicinfo= get_token_appinfo();
                getopenid($publicinfo['appid'], $publicinfo['secret'], $code);
            }
            $openid=$_SESSION['openid'];
            $openfind=M('redbaguser')->where("openid1='$openid'")->find();
            $userinfo=M('redbaguser')->where("id='$userid'")->find();
            if(!$openfind) {
                if (!$userinfo) {
                    redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx14416ed01ea0f349&redirect_uri=http://www.bzggl.com/weiphp/index.php?s=/addon/HFive/SendRedBag/qrcode&response_type=code&scope=snsapi_base&state=gh_ea944655af62|4#wechat_redirect');//第一个服务号
                }
            }
            else
            {
                $userinfo=$openfind;
            }
            if(!$userinfo)
            {
                redirect("http://mp.weixin.qq.com/s?__biz=MzAwMzgwNjM2MQ==&mid=501292992&idx=1&sn=778a3930c1cd2fdd870568c3064e3f40&scene=20#wechat_redirect");
            }
            if($userinfo['lastid']!=0&&$userinfo['number']==4)
            {
                $lastid=$userinfo['lastid'];
                $lastinfo=M('redbaguser')->where("id='$lastid'")->find();
                if($lastinfo) {
                    $rand=rand(101,200);
                    if($lastinfo['money']+$rand>=400) {
                        $lastdata['money'] = 400;
                    }
                    else
                    {
                        $lastdata['money'] = $lastinfo['money']+$rand;
                    }
                M('redbaguser')->where("id='$lastid'")->save($lastdata);
                    }
            }
            if($userinfo['openid1']=='') {
                $datas['openid1'] = $openid;
                $datas['number']=5;
                $datas['nickname']=$_SESSION['userinfo']['nickname'];
                M('redbaguser')->where("id='$userid'")->save($datas);
            }
        }
//        var_dump($userinfo);
//        exit;
        $this->assign('type',$type);
        $money=substr($userinfo['money'],0,1).'.'.substr($userinfo['money'],1,2);;
        $this->assign('userinfo',$userinfo);
        $this->assign('money',$money);
        $this->display();
    }
    public function createqrcode()//生成带参数二维码(第一个服务号)
    {
        session('token','gh_ea944655af62');
        $code=I('code');
        if ($code != "" ) {
            getopenid('wx14416ed01ea0f349', '596fb11499da239d19ff7e6f532e55a5', $code);
        }
        $diaoyong=new UserInfoAddon();
        var_dump('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$diaoyong->createqrcode(1));
        exit;
    }

    public function withdrawal()//提现控制器(粤港澳)
    {
        header("Content-type: text/html; charset=utf-8");
        $UpayConfig['APPID']='wx2cc9c898d1d091b9';
        $UpayConfig['MCHID']='1385397202';
        $UpayConfig['KEY']='9a28f97635c5b95c7e68ef3c40f63757';
        $UpayConfig['APPSECRET']='8d2d1fc5957bb43c30a9ff2ef6fbdd41';
        $userid=I('userid');
        $userinfo=M('redbaguser')->where("id='$userid'")->find();
        $openids=$userinfo['openid1'];
        $member_public=M('member_public');
        $token=get_token();
        $member_public=$member_public->where("token='$token'")->find();
        $moneys=(int)(I('money')*100);
        $appid = $member_public['appid'];
        $secret = $member_public['secret'];
        $code = $_GET["code"];
        $totalmoney= M('redbagrecord')->where("method='关注5个公众号送红包'")->sum('money');
        $totalmoney=(int)$totalmoney;
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
        $count=M('redbagrecord')->where("openid='$openid'")->count();
        if($count>=2)
        {
            $this->error('您已提现过两次');
        }
        $openidfind=M('redbaguser')->where("openid1='$openid'")->find();
        if(!$userinfo&&!$openidfind)
        {
            $this->error('无效用户');
        }
        if((int)$openidfind['money']<(int)$moneys)
        {
            $this->error('提现金额不足');
        }
        if(($moneys+$totalmoney)>=3000)
        {
            $this->error('您慢了一步哦,红包已被抢完了');
        }
        $wishing="恭喜获得现金红包，继续推荐好友关注还可以获得更多红包哦";//红包祝福语
        $act_name="老板任性抢红包";//活动名称
        $sremark="猜越多得越多，快来抢！";//备注
        $total_num=1;//
        $total_amount;
        if(!empty($moneys)) {
            $total_amount = $moneys;//
        }
        $send_name="粤港澳演唱会";//
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
        $zs1="Uploads/Download/zhengshu/yuegangao/apiclient_cert.pem";
//        $zs1=$member_public['cert'];
        $zs2="Uploads/Download/zhengshu/yuegangao/apiclient_key.pem";
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
        $moneydata['money']=(int)$openidfind['money']-$moneys;
        M('redbaguser')->where("openid1='$openid'")->save($moneydata);//扣减可提现金额
        $this->success($info);
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
    public  function addredpack()//插入红包记录
    {
        $money=I('total_amount');
        $openid=I('re_openid');
        $data['openid']=$openid;
        $userinfo=M('redbaguser')->where("openid1='$openid'")->find();
        $data['mch_billno']=I('mch_billno');
        $data['mch_id']=I('mch_id');
        $data['money']=substr($money,0,1).'.'.substr($money,1,2);
        $data['addtime']=time();
        $data['orderid']=I('send_listid');
        $data['method']=I('method');
        $data['nickname']=$userinfo['nickname'];
        $data['token']=get_token();
        D('Addons://UserInfo/RedBag')->addrecord($data);
    }
    function getSign($Obj)
    {
        $UpayConfig['APPID']='wx2cc9c898d1d091b9';
        $UpayConfig['MCHID']='1385397202';
        $UpayConfig['KEY']='9a28f97635c5b95c7e68ef3c40f63757';
        $UpayConfig['APPSECRET']='8d2d1fc5957bb43c30a9ff2ef6fbdd41';
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

    public function testcontent()
    {
        header("Content-type: image/jpeg");
        $imgs = array(
            'dst' => 'Uploads/Download/sendredbag/qbg.png',
            'src' => 'Uploads/Download/sendredbag/58.png'
        );

        list($max_width, $max_height) = getimagesize($imgs['dst']);
        $dests = imagecreatetruecolor($max_width, $max_height);

        $dst_im = imagecreatefrompng($imgs['dst']);

        imagecopy($dests,$dst_im,0,0,0,0,$max_width,$max_height);
        imagedestroy($dst_im);

        $src_im = imagecreatefrompng($imgs['src']);
        $src_info = getimagesize($imgs['src']);
        imagecopy($dests,$src_im,76,296,0,0,162,162);
        imagedestroy($src_im);

        imagejpeg($dests);
    }

    public function adduser()//摇一摇ajax
    {
        vendor("phpqrcode.phpqrcode");
        $money=I('money');
        if(!$money)
        {
            $this->error('提现金额不能为空');
        }
        $openid=$_SESSION['openid'];
       $info= M('redbaguser')->where("openid='$openid'")->find();
        if($info)
        {
            $this->error('此用户已注册');
        }
        $data['openid']=$openid;
        $data['nickname']=$_SESSION['userinfo']['nickname'];
        $data['headimgurl']=$_SESSION['userinfo']['headimgurl'];
        $data['addtime']=time();
        $data['number']=0;
        $data['money']=$money;
        $query= M('redbaguser')->add($data);
        if($query)
        {

            $this->success('新增成功');
        }
        else
        {
            $this->error('新增失败');
        }
    }

    public function saveqrcode()
    {
        vendor("phpqrcode.phpqrcode");
        $openid=I('openid');
        $userinfo= M('redbaguser')->where("openid='$openid'")->find();
        $diaoyong=new UserInfoAddon();
        $query=$userinfo['id'];
        if(!$userinfo) {
            $this->error('此用户不存在');
        }
            $data = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx14416ed01ea0f349&redirect_uri=http://www.bzggl.com/weiphp/index.php?s=/addon/HFive/SendRedBag/beforeindex&response_type=code&scope=snsapi_userinfo&state=gh_ea944655af62|' . $query . '#wechat_redirect';
//        // 纠错级别：L、M、Q、H
            $level = 'L';
//        // 点的大小：1到10,用于手机端4就可以了
            $size = 2.5;
//        // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            $path = "Uploads/Download/sendredbag/";
//        // 生成的文件名
            $fileName = $path . $query . '.png';
            \QRcode::png($data, $fileName, $level, $size);
            $imgs = array(
                'dst' => 'Uploads/Download/sendredbag/qbg.png',
                'src' => 'Uploads/Download/sendredbag/' . $query . '.png'
            );
            $font = 'STHeiti-Light.ttc';//字体
            $head_path = 'Uploads/Download/sendredbag/headimg/' . $query . '.png';
//            $headimgurl=file_get_contents($userinfo['headimgurl']);
//            file_put_contents($head_path,$headimgurl);
            $nickname = $userinfo['nickname'];
            list($max_width, $max_height) = getimagesize($imgs['dst']);
            $dests = imagecreatetruecolor($max_width, $max_height);
//             $headimgurl=imagecreatefromjpeg('Uploads/Download/sendredbag/moon.jpg');
//缩放比例
            $ratio = 0.5;

//修改尺寸 至于各个函数是干嘛的，google一下吧
            $imagedata = getimagesize($userinfo['headimgurl']);
            $olgWidth = $imagedata[0];
            $oldHeight = $imagedata[1];
            $newWidth = $olgWidth * $ratio;
            $newHeight = $oldHeight * $ratio;

            $image = imagecreatefromjpeg($userinfo['headimgurl']);
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($thumb, $image, 0, 0, 0, 0, 100, 100, $olgWidth, $oldHeight);
            imagejpeg($thumb, $head_path);

            imagedestroy($thumb);
            imagedestroy($image);
            $dst_im = imagecreatefrompng($imgs['dst']);


            $black = imagecolorallocate($dests, 0xFF, 0xFF, 0xFF);//字体颜色


            imagecopy($dests, $dst_im, 0, 0, 0, 0, $max_width, $max_height);
            imagedestroy($dst_im);

            $src_im = imagecreatefrompng($imgs['src']);
            imagecopy($dests, $src_im, 76, 296, 0, 0, 162, 162);
            imagedestroy($src_im);

            $headimgurl = imagecreatefromjpeg($head_path);
            imagecopy($dests, $headimgurl, 130, 210, 0, 0, 100, 100);
            imagedestroy($headimgurl);
            imagefttext($dests, 14, 0, 140, 280, $black, $font, $nickname);
            imagejpeg($dests, 'Uploads/Download/sendredbag/' . $query . '.png');
//            $dests=imagecreatefrompng($imgs['src']);

            $qrcode['qrcode'] = "http://addon.rtda.cn/weiphp/" . $fileName;
            $qrcode['qrcode1'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($query);
            M('redbaguser')->where("id='$query'")->save($qrcode);

    }








}