<?php

namespace Addons\Shop\Model;
use Think\Model;
//use Think\Page;

/**
 * cart 购物车 模型
 */
class ProductsModel extends Model{
    protected $tableName = 'shop_products';
    protected $errormsg;
    //初始化
    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取产品列表
    public function getList($map){
        $list = $this->where($map)->select();
        return $list;
    }
    
    //获取产品数量
    public function getCount($map){
        $count = $this->where($map)->count();
        return $count;
    }
    //获取商品详情
    public function getInfo($map) {
        $map['token'] = get_token();
        $info = $this->where($map)->find();
        return $info;
    }
    //商品销量增加
    public function sellNumInc($id,$num){
        if(empty($id)||empty($num)) return false;
        $map['id'] = $id;
        $this->where($map)->setInc('sellnum',$num);
    }
    //商品阅读数量+1
    public function  viewNumInc($id,$num){
        if(empty($id)||empty($num)) return false;
        $map['id'] = $id;
        $this->where($map)->setInc('view_num',$num);
    }
    
    //支付订单
    public function payOrder(){
        
    }
    
    //取消订单
    public  function removeOrder(){
        
    }
    //发货
    public function sendOrder() {
        
    }
    //收货
    public function sureOrder() {
        
    }
    
    /*
     * 获取商品列表  (前台显示 + 分页）
     * @order_type 显示类别   default:按时间降序排序   sellnum 销售量 降序排序   price  价格降序排序
     * 
     * @page 第几页
     * @pagenum 每页数量
     */

    public function cgetList($cate_id,$order_type = 'default',$map ='',$page = 1,$pagenum = 20){
        $map['token'] = get_token();
        //查询属于cate_id （包含其子分类的商品）
        if($cate_id != 'all'){
            $cate_id_list = M('shop_categories')->where('id="'.$cate_id.'" OR pid = "'.$cate_id.'"')->field('id')->select();
            if(!$cate_id_list) return false;
            $cate_id = "";
            foreach($cate_id_list as $vo){
                $cate_id .=','.$vo['id'];
            }
            $cate_id = ltrim($cate_id, ',');
            //查询商品并分类处理
            $map['cate_id'] = array('in',$cate_id);
        }
        $map['is_show'] = 1;//只显示上架商品  1上架  2 下架
        
        switch ($order_type) {
            case 'sellnum':
                $order = "sellnum desc";
                break;
            case 'price':
                $order = "true_price asc";
                break;
            default:
                $order = "cTime desc";
                break;
        }
        $pageinfo['count'] = $this->where($map)->count();
        $pageinfo['num'] = ceil( $pageinfo['count']/$pagenum);
        
        $result = $this->where($map)->order($order)->page($page,$pagenum)->select();
        $list['list'] = $result;
        $list['page'] = $pageinfo;
        
        return $list;
    }
     /*
     * 获取商品列表2   (前台显示 + 分页） 用于Uwork
     * @page 第几页
     * @pagenum 每页数量
     */
    public function ugetList($cate_id,$map ='',$page = 1,$pagenum = 20){
        $map['token'] = get_token();
        if($cate_id != 'all'){
            $cate_id_list = M('shop_categories')->where('id="'.$cate_id.'" OR pid = "'.$cate_id.'"')->field('id')->select();
            if(!$cate_id_list) return false;
            $cate_id = "";
            foreach($cate_id_list as $vo){
                $cate_id .=','.$vo['id'];
            }
            $cate_id = ltrim($cate_id, ',');
            //查询商品并分类处理
            $map['cate_id'] = array('in',$cate_id);
        }
        $map['is_show'] = 1;//只显示上架商品  1上架  2 下架
        
         $result = $this->where($map)->order('cTime desc')->page($page.',10')->select();
         $data['list'] = $result;
        //分页
        $count = $this->where($map)->count();
        $page = new \Think\Page($count,7);
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
        $data['page'] = $show;
        return $data;
    }
}
