<?php

namespace Addons\UserInfo;
use Common\Controller\Addon;

/**
 * 百事通会员信息插件
 * @author 无名
 */

class UserInfoAddon extends Addon{

    public $info = array(
        'name'=>'UserInfo',
        'title'=>'百事通会员信息',
        'description'=>'这是一个临时描述',
        'status'=>1,
        'author'=>'无名',
        'version'=>'0.1',
        'has_adminlist'=>1,
        'type'=>1
    );

    public function install() {
        $install_sql = './Addons/UserInfo/install.sql';
        if (file_exists ( $install_sql )) {
            execute_sql_file ( $install_sql );
        }
        return true;
    }
    public function uninstall() {
        $uninstall_sql = './Addons/UserInfo/uninstall.sql';
        if (file_exists ( $uninstall_sql )) {
            execute_sql_file ( $uninstall_sql );
        }
        return true;
    }

    //实现的weixin钩子方法
    public function weixin($param){

    }
    public function sendjson($openid,$keyword1,$keyword2,$num)//组装模板消息(签到中奖)
    {
        $remark="电子码:".$num;
        if($keyword2=="三等奖")
        {
            $remark="您已获得优惠券,快去我的优惠券页面看看吧";
        }
        if($keyword2=='一等奖')
        {
            $remark="您已获得微信红包,快去公众号里面领取吧";
        }
        $first = "恭喜您参与的活动中奖了！";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/UserInfo/Index/prize&response_type=code&scope=snsapi_base&state=$keyword2#wechat_redirect";
        $template = array(
            "touser" => $openid,
            "template_id" => "68-BLwa_xM2PAbud6n5QY8oT9N-Zs-o2TiIpMMi7pb4",
            "url" => $url,
            "topcolor" => "#FF0000",
            "data" => array("first" => array(
                "value" => urlencode($first),
                "color" => "#FF0000",
            ),
                "keyword1" => array(
                    "value" => urlencode($keyword1),
                    "color" => "#FF0000",
                ),
                "keyword2" => array(
                    "value" => urlencode($keyword2),
                    "color" => "#FF0000",
                ),
                "remark" => array(
                    "value" => urlencode($remark),
                    "color" => "#FF0000",
                ),
            )
        );
        $template = json_encode($template);
        return $template;
    }
    public function subscribe($openid,$keyword1,$keyword2,$keyword3,$keyword4,$nickname,$newsname)//组装模板消息(关注送积分)
    {
        $remark="点击查看积分";
        if($newsname!='') {
            $first = "亲爱的" . $nickname . "，您的积分账户有新的变动，文章:(" . $newsname . ")积分增加已达上限,具体内容如下：";
        }
        else
        {
            $first = "亲爱的" . $nickname . "，您的积分账户有新的变动，具体内容如下：";
        }
        $score=20-$keyword4;
        if($score<=0)
        {
            $score=0;
        }
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        $template = array(
            "touser" => $openid,
            "template_id" => "_iovpNqzt80I9kAiKw4PhO78dwqvR5-TuwWbr2F_u4o",
            "url" => $url,
            "topcolor" => "#FF0000",
            "data" => array("first" => array(
                "value" => urlencode($first),
                "color" => "#FF0000",
            ),
                "keyword1" => array(
                    "value" => urlencode($keyword1),
                    "color" => "#FF0000",
                ),
                "keyword2" => array(
                    "value" => urlencode($keyword2),
                    "color" => "#FF0000",
                ),
                "keyword3" => array(
                    "value" => urlencode($keyword3),
                    "color" => "#FF0000",
                ),
                "keyword4" => array(
                    "value" => urlencode($keyword4.'(还差'.$score.'分就可以领取微信红包了哦)'),
                    "color" => "#FF0000",
                ),
                "remark" => array(
                    "value" => urlencode($remark),
                    "color" => "#FF0000",
                ),
            )
        );
        $template = json_encode($template);
        return $template;
    }
    public function sendtempmsg($xml) {


        $Info=D('Addons://Vote/AccessToken')->getInfo();//查询access_token
        $access_token=$Info['access_token'];
        $res = $this->http_request('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,$xml);
        $res = json_decode($res, true);
        // 记录日志
        if ($res ['errcode'] == 0) {
            addWeixinLog ( $xml, 'post' );
        }
//        else
//        {
//            $info = get_token_appinfo ( get_token() );
//            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];
//            $tempArr = json_decode ( file_get_contents ( $url ), true );
//            $access_token=$tempArr ['access_token'];
//            D('Addons://Vote/AccessToken')->saveinfo($access_token,1);
//            $res = $this->http_request('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,$xml);
//            $res = json_decode($res, true);
//        }
        return $res;


    }

    //获取access_token
    public function get_access_token(){
        $url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx807f16d8a8046457&secret=2aeca10207571bf7918d2a974f63e6c2';
        $data = json_decode(file_get_contents($url_get), true);
        if ($data ['errcode'] == 0) {

            return $data;
        }else{

            return 0;
        }
    }
    public  function http_request($url,$data=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function createqrcode($id)//生成带参数的永久二维码ticket
    {
        $Info=D('Addons://Vote/AccessToken')->getInfo();//查询access_token
        $access_token=$Info['access_token'];
        $qrcode='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":'.$id.'}}}';
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        $result=$this->http_request($url,$qrcode);
        $jsoninfo=json_decode($result,true);
        $ticket=urlencode($jsoninfo['ticket']);
        if(empty($ticket))
        {
            $info = get_token_appinfo ( get_token() );

            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];
            $tempArr = json_decode ( file_get_contents ( $url ), true );
            $access_token=$tempArr ['access_token'];
            D('Addons://Vote/AccessToken')->saveinfo($access_token,1);
            $qrcode='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":'.$id.'}}}';
            $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
            $result=$this->http_request($url,$qrcode);
            $jsoninfo=json_decode($result,true);
            $ticket=urlencode($jsoninfo['ticket']);
        }
        return $ticket;
    }
}