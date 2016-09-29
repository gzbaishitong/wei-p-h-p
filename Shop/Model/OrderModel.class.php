<?php

namespace Addons\shop\Model;
use Think\Model;

/**
 * cart 购物车 模型
 */
class OrderModel extends Model{
    private $errormsg;
    private $token;
    protected $tableName = 'shop_orders';

    public function getErrorMsg(){
        return $this->errormsg;
    }
    public function getTopthree($openid)//获取用户最新购买的三个商品列表
    {
        $map['openid']=$openid;
        $map['payStatus']=2;
        $Dao=M();
        $List=$Dao->query("select a.total_price,a.isuse,a.title,b.head_img,a.payType,a.id,a.endtime from wp_shop_orders a LEFT JOIN wp_shop_products b ON a.product_id=b.id WHERE a.openid='$openid' AND a.payStatus=2 ORDER BY a.cTime desc limit 3");
        return $List;
    }
    //订单列表
    public function getList($openid){
        $map['openid']=$openid;
        $map['payStatus']=2;
        $Dao=M();
        $List=$Dao->query("select a.total_price,a.isuse,a.title,b.head_img,a.payType,a.id,a.endtime from wp_shop_orders a LEFT JOIN wp_shop_products b ON a.product_id=b.id WHERE a.openid='$openid' AND a.payStatus=2 ORDER BY a.cTime desc ");
        return $List;
    }
    //代发货订单数量
    public function waitFaCount(){
        $map['token'] = get_token();
        $map['wuliuStatus'] = array('eq',1);
        $map['_string'] = "payType = 3 OR payStatus = 2";
        $map['orderStatus'] = 1;
        $result = $this->where($map)->count();
        if(!$result){
            return 0;
        }else{
            return $result;
        }
    }
    public function isuse($id)//核销
    {
        $map['id']=$id;
        $data['isuse']=1;
        $this->where($map)->save($data);
    }
    //是否含有未支付订单，首页红点效果
    public function hasUnPay(){
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        $map['orderStatus'] = 1;
        $map['payType'] = 1;//需支付订单
        $map['payStatus'] = 1;//未支付订单
        $result =$this->where($map)->find();
        if($result){
            return true;
        }else{
            return false;
        }
    }

    //后台查阅的订单数量
    public function orderCount(){
        $map['token'] = get_token();
        $count = $this->where($map)->count();
        return $count;
    }

    //订单列表  （包含详情）
    public function getAllList($map){
        $list= $this->where($map)->order('cTime desc')->select();
        $order_detailDB = M('shop_order_detail');
        foreach($list as &$vo){
            $detail = $order_detailDB->where('order_id="'.$vo['id'].'"')->select();
            $vo['detail'] = $detail;
        }
        return $list;
    }
    //删除订单
    public function delOrder($map,$data = array()){
        $data['orderStatus'] = 2;
        return $this->where($map)->save($data);
    }
    //订单详情
    public function getInfo($map){
        $info = $this->where($map)->find();
        return $info;
    }
    //
    public function getAllInfo($map){
        $info = $this->where($map)->find();
        if($info){
            $detail = M('shop_order_detail')->where('order_id="'.$info['id'].'"')->select();
            $info['detail'] = $detail;
        }
        return $info;
    }

    //生成新订单
    public function newOrder($data){
        $data['ordernum'] = $this->getOrderNum();
        $data['cTime'] = time();
        $data['token'] = get_token();
        $data['openid'] = $_SESSION['openid'];
        $key = get_token().'_dept_shop';
        //$data['dept_from'] = is_numeric(session($key))?session($key):'';

        //$id =  parent::add($data);
        $id = $this->add($data);
        if(!$id) return false;
        //保存订单明细
        $order_detailDB = M('shop_order_detail');
        foreach($data['detail'] as $vo){
            $vo['p_id'] = $vo['id'];
            unset($vo['id']);
            $vo['order_id'] = $id;
            $result = $order_detailDB -> add($vo);
            if($result){
                //此商品销量加1
                D('Addons://Shop/Products')->sellNumInc($vo['p_id'],$vo['num']);
            }
        }

        //发送微信的订单通知
        // $url = addons_url('Shop://Index/orderCode',array('content'=>$data['ordernum']));
        //$this->sendTemplateMsg($data['openid'],$url, $data['ordernum'], count($data['detail']), $data['total_price']);

        //add by cxf   您有新订单生成。测试中ING webscoket相关，暂时屏蔽
        /*
        $shop_id = md5(get_token());
        $msg=array(
            'type'=>'new_order',
            'shop_id'=>$shop_id,
            'ordernum'=>$data['ordernum']
        );
        send_workerman($msg);
         */
        return $id;
    }
    //被动效果


    //生成订单号
    public function getOrderNum(){
        return time().rand(100,999);
    }
    public function iscanpay($Info,$map)//判断是否够积分并扣减积分
    {
        $UserMo = M('userinfo');
        $orderinfo= $this->getInfo($map);
        if($orderinfo['coupon']!=0) {
            $CouponList= D('Addons://Shop/Coupon')->getInfo($orderinfo['coupon']);
            if ($Info['score'] >= $orderinfo['total_price']-$CouponList['score']) {
                if($orderinfo['total_price']>=$CouponList['score']) {
                    $Info['score'] = $Info['score'] - $orderinfo['total_price']+$CouponList['score'];
                    $query=$UserMo->save($Info);
                    if($query) {
                        $query=D('Addons://Shop/Coupon')->isuse($orderinfo['coupon']);
                        if($query) {
                            return $orderinfo['total_price']-$CouponList['score'];
                        }
                    }
                }
                else
                {
                    $query=D('Addons://Shop/Coupon')->isuse($orderinfo['coupon']);
                    if($query) {
                        return '0';
                    }
                }
            }
        }
        else
        {
            if ($Info['score'] >= $orderinfo['total_price']) {
                $Info['score'] = $Info['score'] - $orderinfo['total_price'];
                $query=$UserMo->save($Info);
                if($query) {
                    return $orderinfo['total_price'];
                }
            }
        }
        return '积分不足';
    }
    //确认订单支付
    public function isPay($map,$data,$method){
        $orderinfo=$this->getInfo($map);//订单信息
        $goodsmap['id']=$orderinfo['product_id'];
        $goodsinfo= D('Addons://Shop/Products')->getInfo($goodsmap);//商品信息
        $goodsid=$goodsinfo['id'];
        $goodsinfo['inventory']=$goodsinfo['inventory']-1;
        $GoodMo=M('shop_products');
        $GoodMo->where("id='$goodsid'")->save($goodsinfo);
        $data['payStatus'] = 2;
        $data['payType']=$method;
        if($goodsinfo['iselectronicticket']==1)
        {
            $coupon= D('Addons://Shop/Coupon')->getList($goodsid);//随机获取一张电子码
            if($coupon[0]['qrcode']!=0)
            {
                $data['code']=$coupon[0]['qrcode'];
            }
            else
            {
                $data['code']=$coupon[0]['num'];
            }
            $data['isuse']=1;
            D('Addons://Shop/Coupon')->isuse($coupon[0]['id']);//把电子码改为已使用
        }
        return $this->where($map)->save($data);//将状态改成已支付
    }

    //订单发货
    public function sendOrder($map,$data){
        $data['wuliuStatus'] = 2;
        $result =  $this->where($map)->save($data);//将状态改成已发货
        return $result;
    }

    //确认订单收货
    public function isGet($map,$data){
        //确认什么情况下可以确认收货
        $map['wuliuStatus'] = 2;//已发货的可以确认收货

        //确认收货操作
        $data['wuliuStatus'] = 3;
        $result = $this->where($map)->save($data);
        return $result;
    }

    public function getRecord($limit)//商品兑换记录
    {
        $Dao=M();
        $list=$Dao->query("select a.title,b.nickname  from wp_shop_orders a JOIN wp_userinfo b ON a.openid=b.openid where a.payStatus='2' and b.nickname!=''  ORDER BY a.payTime desc limit $limit");
        return $list;
    }
    /*
     * 验证方法
     */
    //验证商品是否存在（存在，上线，且库存足够）
    //发送模版消息
    /*
     * 发送模版小心
     * $openid 发送对象,$url 链接地址,$ordern 订单号,$refundno 数量 ,$refundproduct 金额

   function sendTemplateMsg($openid,$url,$ordern,$refundno,$refundproduct){
       $config = getAddonConfig ('Shop' );
       if(empty($config['template_id'])){
           return;
       }else{
           $template_id = $config['template_id'];
           $token =  get_token();
           $info = get_token_appinfo ( $token );
           $access_token=get_access_token();
           //获取分组信息
           try{
               $wechat = new \Com\WechatAuth($info['appid'],$info['secret'],$access_token);
               $data=array(
                   'first'=>array('value'=> '您的订单已创建成功，可以在公众号 “我的服务 - 我的订单” 中查询订单详情','color'=>'#FFOOOO'),
                   'orderno'=>array('value'=> $ordern,'color'=>'#FFOOOO'),
                   'refundno'=>array('value'=> $refundno,'color'=>'#FFOOOO'),
                   'refundproduct'=>array('value'=>$refundproduct,'color'=>'#FFOOOO'),
                   'remark'=>array('value'=>  '如有疑问，可拨打客服电话 020-29042260 咨询','color'=>'#FFOOOO')
               );
               $result = $wechat->sendTemplateMsg($openid,$config['template_id'],$url,'#FF0000',$data);
               return;
           }catch(\Exception $e){
               return;
           }
       }

   }

     */
}
