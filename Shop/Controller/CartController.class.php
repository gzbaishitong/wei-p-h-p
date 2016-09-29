<?php

namespace Addons\shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺购物车控制器
 */
class CartController extends BaseController{
    //购物车列表页
    public function lists(){
        //parent:
    }
    //商品放入购物车
    public function inCart(){
        $data = I('id');
        $data = explode('-', $data);
        $id= $data[0];
        $num = $data[1]?$data[1]:1;
        if(!is_numeric($id)||!is_numeric($num)) return false;
        
        $result = D('Addons://Shop/Cart')->inCart($id,$num);
        if(IS_AJAX){
            $this->ajaxReturn($result,'json');
        }else{
            return $result;
        }
        
    }
    //减购物车
    public function outCart(){
        $id = I('id');
        if(empty($id)){
            return false;
        }else{
             $result = D('Addons://Shop/Cart')->outCart($id);
             if(IS_AJAX){
                $this->ajaxReturn($result,'json');
            }else{
                return $result;
            }
        }
    }
    //删除购物车
    public function delCart(){
        $id = trim(I('id'),',');
        $id = explode(',', $id);
        if(empty($id)){
            return false;
        }else{
            $result = D('Addons://Shop/Cart')->delCart($id);
            if(IS_AJAX){
                $this->ajaxReturn($result,'json');
            }else{
                return $result;
            }   
        }
        
    }
    //清空购物车
    public function cleanCart(){
        D('Addons://Shop/Cart')->cleanCart();
        redirect(addons_url('Shop://Index/cart'));
    }
}
