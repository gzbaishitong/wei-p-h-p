<?php

namespace Addons\shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺购物车控制器
 */
class BannerController extends BaseController{
    public $model;
    //初始化
    function _initialize() {
        $this->model = $this->getModel ( 'shop_banner' );
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
}
