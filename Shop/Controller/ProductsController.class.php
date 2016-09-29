<?php

namespace Addons\shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺订单控制器控制器
 * 
 */
class ProductsController extends BaseController{
    public $model;
    //初始化
    function _initialize() {
        $this->model = $this->getModel ( 'shop_products' );
        parent::_initialize ();
    }
    //列表
    public function lists() {
        $map['token'] = get_token();
        $cate_list = D ( 'Addons://Shop/Categories' )->cgetList($map);
        $all = array(array('id'=>'','name'=>'全部商品'));
        $cate_list = array_merge($all,$cate_list);
        
        $cate_id = I('catez_id')?I('catez_id'):'';
        if($cate_id){
            $map['cate_id'] = I('catez_id');
            session ( 'common_condition', $map );
        }
       
        foreach($cate_list as &$vo){
            if($vo['id'] == $cate_id){
                $vo['is_checked'] = true;
            }
        }
        
         $this->assign('cate_list',$cate_list);
        parent::lists($this->model);
        /*
        $productsDB = D ( 'Addons://Shop/Products' );
        // 解析列表规则
        $list_data = $this->_list_grid ( $this->model );
        $fields = $list_data ['fields'];
        // 搜索条件
        $map = $this->_search_map ( $this->model, $fields );
        $list_data ['list_data'] = $productsDB->getList( $map );
        $this->assign ( $list_data );
        $this->display ();
         * 
         */
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
    //预览商品
    public function preview(){
        $id = I('id');
        $url = addons_url('Shop://Index/productinfo',array('id'=>$id));
        $this->mobilePreview($url);
    }
    
}
