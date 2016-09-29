<?php

namespace Addons\shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺购物车控制器
 */
class TopicsController extends BaseController{
    public $model;
    //初始化
    function _initialize() {
        $this->model = $this->getModel ( 'shop_topic' );
        parent::_initialize ();
    }
    
    //购物车列表页
    public function lists(){
         parent::lists($this->model);
    }
    
    //新增
    public function add() {
        parent::add($this->model);
    }
    //删除
    public function del() {
        parent::del($this->model);
    }
    //改查
    public function edit(){
         parent::edit($this->model);
    }
    
    //所含商铺
    public function setproduct(){
        if(IS_AJAX){
            //获取过滤信息
            if(I('cate_id')&&I('cate_id')!='all') $map['cate_id'] = I('cate_id');//分类过滤
            if(I('search')) $map['_string'] = 'number like "%'.I('search').'%" OR name like "%'.I('search').'%"';
            
            //读取ajax获取的数据
            $map['token'] = get_token();
            $list_data = D('Addons://Shop/Products')->getList($map);
            //数据处理
            foreach($list_data as &$vo){
                $vo['head_img'] = get_img_html($vo['head_img']);
            }
            
            $this->ajaxReturn($list_data,'JSON');
        }else{
            $id = I('id');
            if(!$id) return false;
            $map['token'] = get_token();
            //获取分类信息
            $cate_list = D('Addons://Shop/Categories')->cgetList($map);
            //dump($cate);exit;
            $this->assign('cate_list',$cate_list);

            //获取当前专题的信息
            $map1['id'] = $id;
            $info = D('Addons://Shop/Topics')->getInfo($map1);
            if($info['products_id']!==''){
                //获取已选择的商品数据
                $select_data = array();
                $p_id = explode(',', $info['products_id']);
                foreach($p_id as $vo){
                    $map_vo['id'] = $vo;
                    $result= D('Addons://Shop/Products')->getInfo($map_vo);
                    if(!$result) continue;
                    $select_data[] = $result;
                }
            }
            //读取商品数据
            $list_data = D('Addons://Shop/Products')->getList($map);
            $this->assign('list_data',$list_data);
            $this->assign('select_data',$select_data);
            $this->assign('id',$id);
            $this->display();
        }
    }
    
    //保存专题产品
    public function saveproduct(){
        $t_id = I('t_id');//专题id
        $p_id = I('p_id')?I('p_id'):"";//选择的产品id
        if(IS_AJAX){
            //保存对应的参数
            $map['id'] = $t_id;
            $data['products_id'] = trim($p_id,',');
            $result = D('Addons://Shop/Topics')->saveProducts($map,$data);
            $this->ajaxReturn($result,'json');
        }
    }
}
