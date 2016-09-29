<?php

namespace Addons\shop\Controller;

use Addons\Shop\Controller\BaseController;
use Addons\UserInfo\UserInfoAddon;

/*
 * 商铺功能  首页(测试)
 * 
 */

class TestController extends BaseController
{
    private $error_msg = '';

    function _initialize()
    {
//        if (IS_AJAX) {
//            if (empty($_SESSION['openid'])) {
//                $this->error('身份验证失效,请重新从自定义菜单进入会员卡进行操作');
//            }
//        } else {
//            if (empty($_SESSION['openid'])) {
//                redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');
//            }
//        }
        parent::_initialize();
        //计算购物车商品数量
        $shopcart_count = D('Addons://Shop/Cart')->getCount();
        $this->assign('shopcart_count', $shopcart_count);
        //获取当前选择的方法 以高亮底部导航
        $footer_current = strtolower(_ACTION);
        $this->assign('footer_current', $footer_current);
        //echo $footer_current;exit;
        //获取是否含有订单
        $has_un_pay = D('Addons://Shop/Order')->hasUnPay();
        $this->assign('has_un_pay', $has_un_pay);
        //获取配置信息
        $shop_config = get_addon_config('Shop');
        $this->assign('shop_config', $shop_config);
    }

    //显示首页
    public function index()
    {
        $code = I('code');
        session('token','gh_4fc719089612');
        if ($code != "" ) {
            getopenid($this->appid, $this->secret, $code);
        }
        $openid = $_SESSION['openid'];
        $map3['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map3);//单条用户信息
        if(!$Info)
        {
            redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807f16d8a8046457&redirect_uri=http://addon.rtda.cn/weiphp/index.php?s=/addon/UserInfo/Index/index&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect');
        }
        $map['token'] = $this->use_token;
//        //显示店长推荐
//        $dept_id = session(get_token() . '_dept_shop');
//        if ($dept_id) {
//            //读取推荐商品
//            $reuslt = D('Addons://Uwork/Dept')->getShow($dept_id);
//            $map_show['id'] = array('in', $reuslt);
//            $product_show = D('Addons://Shop/Products')->cgetList('all', '', $map_show, 1, 10);
//            $this->assign('product_show', $product_show['list']);
//        }
//
        $page = I('p') ? I('p') : 1;
        $data = D('Addons://Shop/Products')->cgetList('all', '', $map, $page, 10);
        $page = $data['page'];
        $this->assign('page', $page);
        $data = $data['list'];
        if (!IS_AJAX) {
            //读取顶部幻灯片
            $banner_list = D('Addons://Shop/Banner')->getList($map);
            $this->assign('banner_list', $banner_list);
            // dump($banner_list);exit;
            //读取活动页
            $map1['token'] = $this->use_token;
            $map1['is_show'] = 1;
            $topic_list = D('Addons://Shop/Topics')->getList($map1);
            $this->assign('topic_list', $topic_list);
            //读取商品数据
            //商品兑换记录开始
            $OrderMo=M('shop_orders');
            $UserMo=M('userinfo');
            $ordermap['payStatus']=2;
            $BuyRecord=$OrderMo->where($ordermap)->order('payTime desc')->limit(5)->Field('title,openid')->select();
            $buyarray=array();
            foreach($BuyRecord as $key=>$val)
            {
                $usermap['openid']=$val['openid'];
                $nickname=$UserMo->where($usermap)->getField('nickname');
                if(empty($nickname))
                {
                    $nickname="xxx";
                }
                $buyarray[$key]['nickname']=$nickname;
                $buyarray[$key]['title']=$val['title'];
            }
//            $buyarray=D('Addons://Shop/Order')->getRecord(5);
            $this->assign('BuyRecord',$buyarray);
            //商品兑换记录结束
            $ordertype = I('ordertype');
            $scorelist=M('shop_products')->where("payType='0' AND is_show=1 AND seckilltime='' AND cate_id=5")->order('cTime desc')->select();//积分商品列表
            $moneylist=M('shop_products')->where("payType='1'  AND is_show=1 AND seckilltime='' AND cate_id=5")->select();//现金支付列表
            $secklist=M('shop_products')->where("seckilltime!='' AND is_show=1 AND cate_id=5")->select();//秒杀商品列表
            $this->assign('secklist',$secklist);
            $this->assign('scorelist',$scorelist);
            $this->assign('moneylist',$moneylist);
            //获取商品列表显示
            $this->assign('list', $data);
            $this->display();
        } else {
            //ajax 下拉刷新数据
            foreach ($data as &$vo) {
                $vo['url'] = U('productinfo', array('id' => $vo['id']));
                $vo['head_img'] = get_cover_url($vo['head_img']);
            }
            //AJAX刷新数据
            $this->ajaxReturn($data, 'json');
        }
    }


    //显示分类信息
    public function categories()
    {
        $map['token'] = $this->use_token;
        $list = D('Addons://Shop/Categories')->arrgetList($map);
        //dump($list);exit;
        //获取分类数据
        $this->assign('list', $list);
        $this->display();
    }

    //分类信息
    public function footer()
    {
        $map['token'] = $this->use_token;
        $data = D('Addons://Shop/Products')->cgetList(10, $map);
        //dump($data);exit;
        //echo _ACTION;
        //$this->display();
    }

    //搜索列表页
    public function searchlist()
    {
        $cate_id = 'all'; //获取所有商品
        $page = I('p') ? I('p') : 1;
        $ordertype = I('ordertype') ? I('ordertype') : 'default';


        //获取商品列表显示
        $map['token'] = $this->use_token;
        if (I('search_val') !== '') {
            $map['_string'] = "name like '%" . I('search_val') . "%'";
            $this->assign("search_val", I('search_val'));
        }
        $list = D('Addons://Shop/Products')->cgetList($cate_id, $ordertype, $map, $page);
        $data = $list['list'];
        $this->assign('pageinfo', $list['page']);

        if (IS_AJAX) {
            //对数据做格式处理
            foreach ($data as &$vo) {
                $vo['url'] = U('productinfo', array('id' => $vo['id']));
                $vo['head_img'] = get_cover_url($vo['head_img']);
            }
            //AJAX刷新数据
            $this->ajaxReturn($data, 'json');
        } else {
            $this->assign('ordertype', $ordertype);
            $this->assign('list', $data);
            $this->assign('cate_id', $cate_id);
            $this->display();
        }
    }


    //显示商品列表页
    public function productslist()
    {
        $cate_id = I('cate_id');
        $page = I('p') ? I('p') : 1;
        $ordertype = I('ordertype') ? I('ordertype') : 'default';


        //获取商品列表显示
        $map['token'] = $this->use_token;
        $list = D('Addons://Shop/Products')->cgetList($cate_id, $ordertype, $map, $page);
        $data = $list['list'];
        $this->assign('pageinfo', $list['page']);

        if (IS_AJAX) {
            //对数据做格式处理
            foreach ($data as &$vo) {
                $vo['url'] = U('productinfo', array('id' => $vo['id']));
                $vo['head_img'] = get_cover_url($vo['head_img']);
            }
            //AJAX刷新数据
            $this->ajaxReturn($data, 'json');
        } else {
            $this->assign('ordertype', $ordertype);
            $this->assign('list', $data);
            $this->assign('cate_id', $cate_id);
            $this->display();
        }
    }

    //显示商品详情页
    public function productinfo()
    {

        $id = I('id');
        $Dao=M();
        if (empty($id)) {
            return false;
        }
        $map['id'] = $id;
        $localtime=time();
        M('shop_orders')->where("product_id='$id' AND payStatus=1 AND endpaytime<'$localtime' AND payType!='积分' ")->delete();
//        $info = D('Addons://Shop/Products')->getInfo($map);
        $info=$Dao->query("select a.* ,b.address,b.telphone from wp_shop_products a JOIN wp_storeinfo b ON a.storeid=b.id WHERE a.id='$id'");
        D('Addons://Shop/Products')->viewNumInc($map['id'], 1);

        $this->assign('info', $info[0]);
        $this->assign('un_share', true);//为了避免触发文章的奖励信息，此处先紧急处理。回头统一优化
        $this->share($info);

        $this->display();
    }

    //显示购物车
    public function cart()
    {
        //获取数据
        $list = D('Addons://Shop/Cart')->cgetList();
        if (empty($list)) {
            //$this->display(emptycart);
            redirect(U('emptycart'));
        } else {
            $this->assign('list', $list);
            $this->display();
        }

    }

    //显示空购物车
    public function emptycart()
    {
        $this->display();
    }

    //活动页
    public function topic()
    {
        $id = I('id');
        if (!$id) return false;
        $map['id'] = $id;
        //获取想关id
        $allinfo = D('Addons://Shop/Topics')->getAllInfo($map);

        $this->assign('info', $allinfo);
        $this->display();
    }

    //订单页
    public function order()
    {

    }

    /*
     * 确认订单功能集
     */

    //我的订单
    public function myorder()
    {
        echo '尚未创建';
        exit;
        $this->display();
    }

    //确认订单
    public function sureorder()
    {
        $from = I('from') ? I('from') : "default";
        //如果是来自购物车的订单，生成订单后，需要删除购物车的相关内容
        $this->assign('from', $from);
        //判断是否会员信息
        $token = get_token();
        $openid = $_SESSION['openid'];
        if ($openid == -1 && (empty($GLOBALS['user']) || $GLOBALS['user']['status'] === 0)) {
            $this->error(您需要先关注或绑定会员信息);
        } else {
            //获取收货地址信息
            $map1['token'] = $token;
            $map1['openid'] = $openid;
            $address_list = D('Addons://Shop/Address')->getList($map1);

            $this->assign('address_list', $address_list);
            //获取允许的支付信息（待定）
            //dump($address_list);exit;
            //获取商品信息
            $id = I('id');
            if (!$id) {
                $this->error('没有对应的商品');
            }
            $id = explode(',', trim($id, ','));

            $products_list = array();
            $p_price = 0;//商品价格
            $r_p_price = 0;//可打折商品的价格
            foreach ($id as $vo) {
                $vo = explode('-', $vo);
                $map2['id'] = $vo[0];
                $result = D('Addons://Shop/Products')->getInfo($map2);
                if (!$result) continue;
                $result['num'] = $vo[1];

                $p_price += $result['true_price'] * $vo[1];
                //可打折商品
                if ($result['is_rate'] != 0) {
                    $r_p_price += $result['true_price'] * $vo[1];
                }
                $products_list[] = $result;
            }

            //计算费用
            $price['p_price'] = number_format($p_price, 2, ".", "");//商品金额
            $price['r_price'] = $this->getrprice($r_p_price);
            //减去折扣的优惠价
            $r_price = $price['p_price'] - $price['r_price'];

            $price['y_price'] = number_format($this->getyprice($r_price), 2, ".", "");//运费  待开发
            $price['total_price'] = $r_price + $price['y_price'];

            $price['total_price'] = number_format($price['total_price'], 2, ".", "");


            $this->assign('price', $price);
            $this->assign('products_list', $products_list);
        }
        $map['openid'] = $openid;
        $map['token']=get_token();
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        $CouponList= D('Addons://Shop/Coupon')->getList($Info['id']);
        if($products_list[0]['cate_id']!=4) {
            $this->assign('coupon', $CouponList);//优惠券列表
        }
        $this->assign('storeid',$result['storeid']);
        $this->assign('product_id',$result['id']);
        $token = md5(get_token());
        $this->assign('token', $token);
        //判断商品信息
        $this->display();
    }

    //订单列表页
    public function orderlist()
    {

        $type = I('type');
        if ($type != 'unpay' && $type != 'pay' && $type != 'over') {
            $type = 'unpay';
        }
        //读取订单列表
        switch ($type) {
            case 'unpay':
                //待支付订单  （逻辑是  选择微信支付 却为支付的订单）
                $map['payType'] = 1; //微信支付
                $map['payStatus'] = 1; //未支付
                break;
            case 'pay':
                //原来是已支付订单，现改成，已支付订单或者  未支付的货到付款订单 且未确认收货
                $map['wuliuStatus'] = array('neq', 3);
                $map['_string'] = "payType = 3 OR payStatus = 2";
                break;
            case 'over':
                //已确认收货
                $map['wuliuStatus'] = 3;
                break;
            default:
                return false;
                break;
        }
        $map['orderStatus'] = 1;
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        $list = D('Addons://Shop/Order')->getAllList($map);

        if ($type == 'unpay') {
            foreach ($list as &$vo_list) {
                //验证商品
                foreach ($vo_list['detail'] as $vo) {
                    $map['id'] = $vo['p_id'];
                    $pinfo = D('Addons://Shop/Products')->getInfo($map);
                    if ($pinfo['true_price'] != $vo['true_price'] || $pinfo['old_price'] != $vo['old_price']) {
                        $vo_list['can_use'] = 0;//订单失效
                    }
                }
            }
        }

        //dump($list);exit;
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->display();
    }

    public function orderdetail()
    {
        //此页面停用
        //$this->display();
    }
    /*
     * 用户功能集
     */
    //添加收货地址
    public function addaddress()
    {
        if (IS_AJAX) {
            //保存数据
            $data = $_POST;
            $data['token'] = get_token();
            $data['openid'] = $_SESSION['openid'];
            $result = D('Addons://Shop/Address')->addAddress($data);
            $this->ajaxReturn($result, 'json');
        } else {
            $this->display();
        }
    }

    //修改地址
    public function editaddress($id)
    {
        //获取收货地址信息
        if (IS_AJAX) {
            $data = $_POST;
            $data['token'] = get_token();
            $data['openid'] = $_SESSION['openid'];

            $result = D('Addons://Shop/Address')->editAddress($data);
            $this->ajaxReturn($result, 'json');
        } else {
            //获取收货地址信息
            $map['id'] = I('id');
            $map['token'] = get_token();
            //$map['openid'] = $openid;
            $address = D('Addons://Shop/Address')->getInfo($map);
            $this->assign('address', $address);
            $this->display();
        }

    }

    //删除地址
    public function deladdress()
    {
        if (IS_AJAX) {
            $id = I('id');
            $result = D('Addons://Shop/Address')->delAddress($id);
            $this->ajaxReturn($result, 'json');
        }
    }

    //地址管理
    public function address()
    {
        //获取收货地址信息
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        $address_list = D('Addons://Shop/Address')->getList($map);
        $this->assign('address_list', $address_list);

        $this->display();
    }

    //生成订单 (仅支持前端ajax）
    public function neworder()
    {
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        if(!$Info)
        {
            $result['status'] = false;
            $result['msg'] = '身份验证失效,请重新从自定义菜单进入会员卡进行操作';
            $this->ajaxReturn($result, 'json');
        }
        if (IS_AJAX) {
            $map1['id'] = I('address_id');
            $address_data = D('Addons://Shop/Address')->getInfo($map1);
            if (!$address_data) {
                $result['status'] = false;
                $result['msg'] = '请填写正确的收货地址';
                $this->ajaxReturn($result, 'json');
            }
            $product_id=I('product_id');
            $cate_id=I('cate_id');
            $coupon=I('coupon');
            $pay_type = I('pay_type');
            $remarks = I('remarks');
            $storeid=I('storeid');//门店id
            $products = I('products');
            $name=I('name');
            $goodsmap['id']=I('product_id');
            $goodsinfo= D('Addons://Shop/Products')->getInfo($goodsmap);//商品信息
            //解析参数
            $data = $this->depronum($products);
            //拼装参数
            $orderdata['name'] = $address_data['name'];
            $orderdata['phone'] = $address_data['phone'];
            $orderdata['province'] = $address_data['province'];
            $orderdata['city'] = $address_data['city'];
            $orderdata['area'] = $address_data['area'];
            $orderdata['address'] = $address_data['address'];
            $orderdata['remarks'] = $remarks;
            $orderdata['coupon']=$coupon;
            $orderdata['storeid']=$storeid;
            $orderdata['product_id']=I('product_id');
            $orderdata['endtime']=$goodsinfo['endtime'];

            $orderdata['p_price'] = $data['p_price'];
            $r_jian = $this->getrprice($data['r_p_price']);
            //减去折扣的优惠价
            $r_price = $orderdata['p_price'] - $r_jian;

            $orderdata['r_price'] = $r_jian;

            $orderdata['y_price'] = $this->getyprice($r_price);//运费待处理
            $orderdata['total_price'] = $r_price + $orderdata['y_price'];
            if($goodsinfo['dutyid']!=0)//如果有对应任务
            {
                $dutyinfo=D('Addons://UserInfo/Duty')->getInfo($goodsinfo['dutyid']);//任务信息
                $dutymap['openid'] = $openid;
                $dutymap['dutyid'] = $dutyinfo['id'];
                $dutymap['token'] = get_token();
                $dutycount = D('Addons://UserInfo/DutyRecord')->getcount($dutymap);
                if($dutycount<1)//如果完成任务
                {
                    $result['status'] = false;
                    $result['msg'] = '你需要完成任务才能购买此商品哦';
                    $this->ajaxReturn($result, 'json');
                }
            }
            if($goodsinfo['payType']==0) {
                if ($Info['score'] < $r_price + $orderdata['y_price']) {
                    $result['status'] = false;
                    $result['msg'] = '积分不足';
                    $this->ajaxReturn($result, 'json');
                }
            }
            $localtime=time();
            $begintime=$localtime-1;
            $endtime=$localtime+1;
            $list=M('shop_orders')->where("product_id='$product_id'")->select();
            foreach($list as $val)
            {
                if($val['cTime']>=$begintime&&$val['cTime']<$endtime)
                {
                    $result['status'] = false;
                    $result['msg'] = '当前购买人数过多请重新购买';
                    $this->ajaxReturn($result, 'json');
                }
            }
            $nopaycount=M('shop_orders')->where("product_id='$product_id' AND payStatus=1 AND endpaytime>'$localtime' ")->count();
            if($nopaycount>=$goodsinfo['inventory']&&$nopaycount!=0)
            {
                $result['status'] = false;
                $result['msg'] = '当前购买人数过多请重新购买';
                $this->ajaxReturn($result, 'json');
            }
            if(!empty($goodsinfo['seckilltime']))
            {
                if($goodsinfo['seckilltime']>time())
                {
                    $result['status'] = false;
                    $result['msg'] = '该商品还未开始秒杀哦';
                    $this->ajaxReturn($result, 'json');
                }
            }
            if($goodsinfo['inventory']<1)
            {
                $result['status'] = false;
                $result['msg'] = '库存不足';
                $this->ajaxReturn($result, 'json');
            }

            //开始查询该商品限购次数
            $OrderMap['product_id']=I('product_id');
            $OrderMap['payStatus']=2;
            $OrderMap['openid']=$openid;
            $count=M('shop_orders')->where($OrderMap)->count();
//结束查询该商品限购次数
            if($goodsinfo['buycount']!=0)
            {
                if($count>=$goodsinfo['buycount'])//如果超过限购次数
                {
                    $result['status'] = false;
                    $result['msg'] = '此商品每人只能购买'.$goodsinfo['buycount'].'次哦';
                    $this->ajaxReturn($result, 'json');
                }
            }
            $orderdata['payType'] = $pay_type;//支付方式
            if ($pay_type == 4) {
                //余额支付
                //判断密码是否正确
                $safecode = I('safecode');

                $result_pay = D('Common/UserCenter')->payGold($this->uid, $orderdata['total_price'], $safecode);
                if ($result_pay['status'] == false) {
                    $result['status'] = false;
                    $result['msg'] = $result_pay['msg'];
                    $this->ajaxReturn($result_pay, 'json');
                } else {
                    $orderdata['payStatus'] = 2;//已支付
                    $orderdata['payTime'] = time();
                }
            }
            if($cate_id==4)
            {
                $config=get_addon_config('Shop');
                $orderdata['addscore']=$config['scorebili']*($r_price + $orderdata['y_price']);
                $orderdata['endpaytime']=time()+380;
            }
            $orderdata['detail'] = $data['products_list'];
            $orderdata['title']=$name;
            $result = D('Addons://Shop/Order')->newOrder($orderdata);

            if ($result) {
                //删除相关的购物车内容 如果是购物车进来的话，生成订单后，则删除想过商品
                $from = I('from');
                if ($from == 'cart') {
                    foreach ($data['products_list'] as $vo) {
                        $id[] = $vo['id'];
                    }
                    D('Addons://Shop/Cart')->delCart($id);
                }
                $result['status'] = true;
                $this->ajaxReturn($result, 'json');
            } else {
                $result['status'] = false;
                $result['msg'] = "订单生成失败";
                $this->ajaxReturn($result, 'json');
            }
        }
    }

    //支付页面
    public function payorder()
    {
        $openid = $_SESSION['openid'];
        $map['openid'] = $openid;
        $Info = D('Addons://UserInfo/UserInfo')->getInfo($map);//单条用户信息
        //生成相关订单
        $id = I('id');//订单id
        if (!$id) $this->error('参数错误');
        $map1['id'] = $id;
        //$map['orderStatus'] = 1;//正常订单
        $orderinfo = D('Addons://Shop/Order')->getAllInfo($map1);
        //验证订单
        if (!$orderinfo) {
            $this->error('未找到此订单');
        } else if ($orderinfo['orderStatus'] != 1) {
            $this->error('此订单已关闭');
        } else if ($orderinfo['payType'] != 1) {
            $this->error('非在线支付订单');
        } else if ($orderinfo['payStatus'] > 1) {
            $this->error('此订单已支付过');
        }
        //验证商品
        foreach ($orderinfo['detail'] as $vo) {
            $map['id'] = $vo['p_id'];
            $pinfo = D('Addons://Shop/Products')->getInfo($map);
            if ($pinfo['true_price'] != $vo['true_price'] || $pinfo['old_price'] != $vo['old_price']) {
                $this->error('此订单已失效');
            }
        }


//        if($orderinfo['payType'] == 1){
//            try{
//                $apipay = $this->weipay($orderinfo);
//            } catch ( \Think\Exception $e) {
//                $this->error($e->getMessage());
//            }
//            $this->assign('apipay',$apipay);
//             //数据分享-JS-SDK版,需要认证后使用
//            $signPackage = $this->getjssdk();
//            if($signPackage){
//                //如果获得返回值,则进行后续动作
//                $this->assign('signPackage',$signPackage);
//            }else{
//                $this->error('未授权的支付请求，您需要认证服务号');
//            }
//        }
        if ($orderinfo['payType'] == 1) {
            $data['payTime'] = time();
            $map['id'] = $id;
            $iscanpay = D('Addons://Shop/Order')->iscanpay($Info, $map);//扣除积分
            if (is_numeric($iscanpay)) {
                $query= D('Addons://Shop/Order')->isPay($map, $data,'积分');
                if($query)
                {
                    $this->assign('info','true');
                }
                else
                {
                    $this->assign('info','false');
                }
            }
        }
        $this->assign('payprice',$iscanpay);//抵扣积分后付款积分
        $this->assign('orderinfo', $orderinfo);
        $this->display();
    }

    public function paymoney()//微信支付视图
    {
        //生成相关订单
        $id = I('id');//订单id
        if(!$id) $this->error('参数错误');
        $map1['id'] = $id;
        //$map['orderStatus'] = 1;//正常订单
        $orderinfo = D('Addons://Shop/Order')->getAllInfo($map1);
        //验证订单
        if(!$orderinfo){
            $this->error('未找到此订单');
        }else if($orderinfo['orderStatus']!=1){
            $this->error('此订单已关闭');
        }else if($orderinfo['payType']!=1){
            $this->error('非在线支付订单');
        }else if($orderinfo['payStatus'] > 1){
            $this->error('此订单已支付过');
        }
        //验证商品
        foreach($orderinfo['detail'] as $vo){
            $map['id'] = $vo['p_id'];
            $pinfo = D('Addons://Shop/Products')->getInfo($map);
            if($pinfo['true_price']!=$vo['true_price']||$pinfo['old_price']!=$vo['old_price']){
                $this->error('此订单已失效');
            }
        }


        if($orderinfo['payType'] == 1){
            try{
                $apipay = $this->weipay($orderinfo);
            } catch ( \Think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->assign('apipay',$apipay);
            //数据分享-JS-SDK版,需要认证后使用
            $signPackage = getjssdk();
            if($signPackage){
                //如果获得返回值,则进行后续动作
                $this->assign('signPackage',$signPackage);
            }else{
                $this->error('未授权的支付请求，您需要认证服务号');
            }
        }
        $this->assign('orderinfo',$orderinfo);
        $this->display();
    }

    //支付回调地址 (未生效)
    public function backPay()
    {
        $key = I('key');
        if ($key != 'fasdfsadfwxmcmnvfref') {
            return false;
        }
        //echo '222';
        $id = I('id');
        $map['id'] = $id;
        D('Addons://Shop/Order')->isPay($map);
    }

    public function closeorder()//超时关闭订单
    {
        $id=I('id');//订单id
        $map1['id'] = $id;
        $orderinfo = D('Addons://Shop/Order')->getAllInfo($map1);
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

    //支付验证地址 （支付回调失败的时候使用  注：当前默认情况下失败）
    public function searchPay()
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
                if($orderinfo['payStatus']==1) {
                    D('Addons://Shop/Order')->isPay($map, $data, '元');
                }
                echo 'SUCCESS';
            } else {
                echo 'SUCCESS';
                //支付失败
                $this->ajaxReturn(false, 'json');
            }
        }
    }
    public function ispay()//是否支付成功(paymoney回调)
    {
        $id=I('id');
        $map['id'] = $id;
        $orderinfo = D('Addons://Shop/Order')->getInfo($map);
        if (!$orderinfo) {
            $this->ajaxReturn(false, 'json');
        } else {
            //验证是否已支付
            $config = get_addon_config('Upay');
            $pay = new \Com\Weipay($config);
            $result = $pay->searchPay($orderinfo['ordernum']); //获得jsapi支付的必要参数
            if ($result['trade_state'] == 'SUCCESS') {
                $this->ajaxReturn(true, 'json');
            } else {
                //支付失败
                $this->ajaxReturn(false, 'json');
            }
        }
    }

    public function delorder()//30秒未支付自动删除订单
    {
        $id=I('id');//订单id
        $map['id']=$id;
        M('shop_orders')->where($map)->delete();
    }

    //临时的解决方案
    public function userCenter()
    {
        //echo $_SESSION['openid'];
        $openid = $_SESSION['openid'];
        //会员界面
        $url = addons_url("UserCenter://Index/userCenter", array('openid' => $openid));
        $html = file_get_contents($url);
        $this->assign('html', $html);
        $this->display();
    }

    private function weipay($orderinfo)
    {
        $config = get_addon_config('Upay');
        //组装数据
        $data['body'] = "[{$orderinfo['ordernum']}]";
        $data['out_trade_no'] = $orderinfo['ordernum'];
        $data['total_fee'] = $orderinfo['total_price'] * 100;
//        $data['notify_url'] = addons_url('Shop://Index/searchPay', array('id' => $orderinfo['id'], 'key' => 'fasdfsadfwxmcmnvfref'));//跳转程序
        $data['notify_url'] ='http://addon.rtda.cn/weiphp/index.php/addon/Shop/Index/searchPay';
        $pay = new \Com\Weipay($config, $data);
        $apipay = $pay->getParameters(); //获得jsapi支付的必要参数
        return $apipay;
    }

    //使用jssdk前需要使用的
    private function getjssdk()
    {
        //get_access_token();
        $jssdk = new \Com\jssdk();
        return $jssdk->getSignPackage();
    }

    //解析  商品于 数量 1-10  解析为  id 为1的商品  数量为10

    private function depronum($id)
    {
        $id = explode(',', trim($id, ','));
        if (!is_array($id)) return false;
        $products_list = array();
        $p_price = 0;//商品价格
        $r_p_price = 0;//可打折商品
        foreach ($id as $vo) {
            $vo = explode('-', $vo);
            $map2['id'] = $vo[0];
            $result = D('Addons://Shop/Products')->getInfo($map2);
            if (!$result) return false;
            if ($vo[1] < 1) return false;
            $result['num'] = $vo[1];
            $p_price += $result['true_price'] * $vo[1];
            //可打折商品
            if ($result['is_rate'] != 0) {
                $r_p_price += $result['true_price'] * $vo[1];
            }
            $products_list[] = $result;
        }
        $data['products_list'] = $products_list;
        $data['p_price'] = $p_price;
        $data['r_p_price'] = $r_p_price;
        return $data;
    }

    //获取运费  输入值 商品总金额
    private function getyprice($p_price = 0)
    {
        //获取配置信息里的基础运费和满免额度，满免则为0，不满免则为基础运费
        $config = getAddonConfig('Shop');
        if (is_numeric($config['y_price']) && is_numeric($config['my_price'])) {
            if ($config['my_price'] <= $p_price) {
                return 0;
            } else {
                return $config['y_price'];
            }
        } else if (is_numeric($config['y_price']) && !is_numeric($config['my_price'])) {
            return $config['y_price'];
        } else {
            return 0;
        }
    }

    //获取折扣价
    private function getrprice($p_price = 0)
    {
        $config = get_addon_config('Shop');
        if ($config['use_level'] == 1 && $p_price != 0) {
            $info = D('Common/UserCenter')->getUserInfo();
            if (is_numeric($info['level']['rate']) && $info['level']['rate'] > 0 && $info['level']['rate'] <= 100) {
                $r_price = $p_price * (100 - $info['level']['rate']) / 100;
                $r_price = number_format($r_price, 2, ".", "");
                return (int)$r_price;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    //分享模块
    private function  share($info)
    {
        //分享数据
        $sharedata['appId'] = '';//服务号可以填写appId
        $sharedata['imgUrl'] = get_cover_url($info['head_img']);
        $sharedata['link'] = addons_url('Shop://Index/productinfo', array(id => $info['id']));
        $sharedata['desc'] = $info['desc'];
        $sharedata['title'] = $info['name'];
        $this->assign('sharedata', $sharedata);

        //数据分享-JS-SDK版,需要认证后使用
        $jssdk = new \Com\jssdk();
        $signPackage = $jssdk->getSignPackage();
        if ($signPackage) {
            //如果获得返回值,则进行后续动作
            $this->assign('signPackage', $signPackage);
        }
    }

    public function test()
    {

        $result = D('Common/UserCenter')->payGold(1474, 10, 111);
        dump($result);
    }


    //二纬条码
    public function ercode()
    {
        $content = I('content');
        $img = create_qrcode($content);
        echo $img;
    }

    //订单二维码
    public function orderCode()
    {
        $ordernum = I('content');
        //echo $ordernum;
        $map['ordernum'] = $ordernum;
        $orderinfo = D('Addons://Shop/Order')->getAllList($map);
        $orderinfo = $orderinfo[0];
        $this->assign('orderinfo', $orderinfo);
        //dump($orderinfo);
        //获取订单详情
        $this->display();
    }

    public function verification()//核销视图
    {
        $openid=$_SESSION['openid'];
        $orderid=I('orderid');//订单id
        $map['id']=$orderid;
        $orderinfo=D('Addons://Shop/Order')->getInfo($map);//订单信息
        $goodsmap['id']=$orderinfo['product_id'];
        $info=D('Addons://Shop/Products')->getInfo($goodsmap);//商品信息
        if(!$info)
        {
            $this->error('此商品不存在');
        }
        if(IS_AJAX)
        {
            $code=I('code');
            $orderid=I('orderid');
            $ordermap['id']=$orderid;
            $info=D('Addons://Shop/Order')->getInfo($ordermap);//订单信息
            $storeinfo=D('Addons://Shop/Store')->getInfo($info['storeid']);//门店信息
            if($storeinfo['code']!=$code)
            {
                $this->error('兑换码错误');
            }
            D('Addons://Shop/Order')->isuse($orderid);//核销
            $this->success('兑换成功');
        }
        $this->assign('orderid',$orderid);
        $this->assign('openid',$openid);
        $this->assign('info',$info);
        $this->display();
    }

    public function productinfos()//核销商品信息视图
    {
        $orderid=I('orderid');
        $map['id']=$orderid;
        $Dao=M();
        $orderinfo=D('Addons://Shop/Order')->getInfo($map);//订单信息
        $id = $orderinfo['product_id'];//商品id
        if (empty($id)) {
            return false;
        }
        $map['id'] = $id;
//        $info = D('Addons://Shop/Products')->getInfo($map);
        $info=$Dao->query("select a.* ,b.address,b.telphone from wp_shop_products a JOIN wp_storeinfo b ON a.storeid=b.id WHERE a.id='$id'");
        D('Addons://Shop/Products')->viewNumInc($map['id'], 1);
        $this->assign('orderinfo',$orderinfo);
        $this->assign('info', $info[0]);
        $this->assign('un_share', true);//为了避免触发文章的奖励信息，此处先紧急处理。回头统一优化
        $this->assign('localtime',time());
        $this->share($info);
        $this->assign('orderid',$orderid);
        $this->display();
    }

    public function tests()
    {
        $diaoyong=new UserInfoAddon();
        var_dump("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode(0));
    }
}
