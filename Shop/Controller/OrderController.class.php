<?php

namespace Addons\shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺产品管理
 * 
 */
class OrderController extends BaseController{
     public $model;
    //初始化
    function _initialize() {
        $this->model = $this->getModel ( 'shop_orders' );
        //$model_id = $this->model['id'];
        $this->assign('model_id', $this->model['id']);
        parent::_initialize ();
    }
     //订单列表
    public function lists() {
         // 使用提示
        $normal_tips = '为了保证订单数据准确性以及退款的唯一性，请您通过微信支付商户平台进行订单查询和退款操作';
        $this->assign ( 'normal_tips', $normal_tips );
        
        $this->assign('add_button',false);
        $this->assign('del_button',false);
        
        
        
        $type = I('type')?I('type'):'waitfa';
        $this->assign('type',$type);
         switch ($type) {
            case 'unpay':
                //待支付订单  （逻辑是  选择微信支付 却为支付的订单）
                $map['payType'] = 1; //微信支付
                $map['payStatus'] = 1; //未支付
                $map['orderStatus'] = 1;
                break;
            case 'waitfa':
                //待发货订单  货到付款，或者已付款，并且未发货的订单
                $map['wuliuStatus'] = array('eq',1);
                $map['_string'] = "payType = 3 OR payStatus = 2";
                $map['orderStatus'] = 1;
                break;
            case 'over':
                //已确认收货   已处理订单
                $map['wuliuStatus'] = array('egt',2);
                $map['orderStatus'] = 1;
                break;
            case 'close':
                //已关闭订单
                $map['orderStatus'] = 2;
                break;
        }
        
        
       //get_name_by_status();
        session ('common_condition',$map);
        
        $token = md5(get_token());
        $this->assign('token',$token);
        parent::lists($this->model);
    }
    //订单详情
    public function orderInfo() {
        $id = I('id');
        $map['id'] = $id;
        //$map['orderStatus'] = 1;
        $map['token'] = get_token();
        $info = D ( 'Addons://Shop/Order')->getAllInfo($map);
        $this->assign('info',$info);
        $this->display();
    }
    //删除订单（商家）
    public function closeOrderShop(){
        if(IS_AJAX){
            $id = I('id');
            $map['id'] = $id;
            //$map['payStatus'] = 1;//只能删除未支付的订单
            $data['close_remark'] = I('closeremark');
            $data['close_from'] = 2;//管理员
            $data['close_mid'] = get_mid();
            $data['close_time'] = time();
            $result = D('Addons://Shop/Order')->delOrder($map,$data);
            
            $this->ajaxReturn(D()->getLastSql(),'json');
        }else{
            $id = I('id');
            $map['id'] = $id;
            $map['token'] = get_token();
            $info = D ( 'Addons://Shop/Order')->getInfo($map);
            $this->assign('info',$info);
            $this->display('closeOrder');
        }
    }
    
     //删除订单 （客户）
    public function closeOrderBuyer(){
        if(IS_AJAX){
            $id = I('id');
            $map['id'] = $id;
            $map['openid'] = $_SESSION['openid'];
            $map['payStatus'] = 1;//只能删除未支付的订单
            
            $data['close_from'] = 1;//客户
            $data['close_time'] = time();
            
            $result = D('Addons://Shop/Order')->delOrder($map,$data);
            $this->ajaxReturn($result,'json');
        }else{
            return false;
        }
    }
    
    //发货
    public function sendOrder(){
        $id = I('id');
        $map['id'] = $id;
        $map['orderStatus'] = 1;
        $map['token'] = get_token();
        $info = D ( 'Addons://Shop/Order')->getInfo($map);
        if(IS_AJAX){
            if(!$info){
                $r['status'] = false;
                $r['msg'] = '无法查询操作此订单';
            }elseif($info['payStatus'] != 2 && $info['payType'] != 3){
                $r['status'] = false;
                $r['msg'] = '此订单未支付';
            }elseif($info['wuliuStatus'] == 2){
                $r['status'] = false;
                $r['msg'] = '此订单已发货';
            }else{
                $r['status'] = true;
            }
            $this->ajaxReturn($r,'json');
        }else{
           $this->assign('info',$info);
           //判断是否需要自派单
		   /*
           $shop_list = D('Addons://Uwork/Dept')->getShopList();
           if(check_addons('Uwork')&&$shop_list){
               foreach($shop_list as &$vo){
                   if($vo['id'] == $info['dept_from']){
                       $vo['is_checked'] = true;
                   }
               }
               
               $this->assign('shop_list',$shop_list);
           }*/
           $this->display();
        }
    }
    public function ajaxSendOrder(){
        $id = I('id');
        $map['id'] = $id;
        $data['wuliu_gongsi'] = I('wuliu_gongsi');
		/*
        if(true||$data['wuliu_gongsi']=='门店派送'){
            //生成派单任务
            $shop_id = I('shop_id');
            $ordernum = M('shop_orders')->where($map)->getField('ordernum');
            M('shop_orders')->where($map)->setField('dept_pai',$shop_id);//设置派送公司
            D('Addons://Uwork/WorkerOrder')->newWorker($shop_id,$ordernum);//新增派送任务
        }*/
        $data['wuliu_num'] = I('wuliu_num');
        $result = D ( 'Addons://Shop/Order')->sendOrder($map,$data);
        $this->ajaxReturn($result,'json');
    }
    //确认收货
    public function isGet(){
        $id = I('id');
        $map['id'] = $id;
        $map['openid'] = $_SESSION['openid'];
        $map['token'] = get_token();
        $result = D ( 'Addons://Shop/Order')->isGet($map,$data);
        $this->ajaxReturn($result,'json');
    }
   //验证余额度支付
     public function checkPayGold(){
         $total_price = I('total_price');//应支付的总金额
         $uid = $this->uid;
         $UserCenterDB =  D('Common/UserCenter');
         $UserCenterDB->init($uid);
         if($UserCenterDB->isSetSafeCode()){
             $data['safecode'] = true;
         }else{
             $data['safecode'] = false;
         }
         if($UserCenterDB->checkGoldEn($total_price)){
             $data['golden'] = true;
         }else{
             $data['golden'] = false;
         }
         $this->ajaxReturn($data,'JSON');
     }
  
}
