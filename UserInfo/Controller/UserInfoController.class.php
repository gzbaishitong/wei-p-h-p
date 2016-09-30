<?php

namespace Addons\UserInfo\Controller;


use Home\Controller\AddonsController;

class UserInfoController extends AddonsController
{

    public function searchPay()//报名回调
    {
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
            $data['isaudit'] = 1;
            $data['isjoin'] = 0;
            $data['ispay'] = 1;
            if ($orderinfo['ispay'] == 0) {
                D('Addons://UserInfo/SignUpUser')->updateinfo($map, $data);
            }
            echo 'SUCCESS';

        }
    }

    public function searchPa()//会员卡商城回调
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $id = $postStr['out_trade_no'];//订单id
        $map['ordernum'] = $id;
        $orderinfo = D('Addons://Shop/Order')->getInfo($map);
        if (!$orderinfo) {
            $this->ajaxReturn(false, 'json');
        } else {
            //验证是否已支付
            $config = get_addon_config('Upay');
            $pay = new \Com\Weipay($config);
            $result = $pay->searchPay($orderinfo['ordernum']); //获得jsapi支付的必要参数
            if ($result['trade_state'] == 'SUCCESS') {
                //支付成功
                $data['transaction_id'] = $result['transaction_id'];
                $data['payTime'] = strtotime($result['time_end']);
                D('Addons://Shop/Order')->isPay($map, $data,'元');
                echo 'SUCCESS';
            } else {
                echo 'SUCCESS';
                //支付失败
                $this->ajaxReturn(false, 'json');
            }
        }
    }


}
