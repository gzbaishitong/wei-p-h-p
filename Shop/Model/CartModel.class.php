<?php

namespace Addons\shop\Model;
use Think\Model;

/**
 * cart 购物车 模型
 */
class CartModel extends Model{
    private $token ;
    private $errormsg;
    private $count;
    
    
    public function __construct() {

    }
    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取购物车列表
    public function getList(){
        $key = 'shop_'.get_token();
        $list = cookie($key);
        if(is_array($list)){
            return $list;
        }else{
            return array();
        }
    }
    public function saveCart($data){
        $key = 'shop_'.get_token();
        cookie($key,$data);
    }
    //放入购物车
    public function inCart($id,$num=1) {
        if(empty($id)){
            return false;
        }else{
            
            //$map['id'] = $id;
            //$info = D ( 'Addons://Shop/Products' )->getInfo($map);
            //if(!$info) return false;
            //$key = 'shop_'.get_token();
            $cart = $this->getList();
            if(isset($cart[$id])){
                //如果商品已存在，数量+1
                $cart[$id] += $num; 
            }else{
                $cart[$id] = $num;
            }
            $count = count($cart);
            $this->saveCart($cart);//缓存数据
            return $count;
        }
    }
    //拿出购物车
    public function outCart($id) {
        if(empty($id)){
            return false;
        }else{
            $cart = $this->getList();
            if(isset($cart[$id])){
                if($cart[$id]>1){
                    $cart[$id] -= 1;
                }else{
                    unset($cart[$id]);
                }
            }
            $count = count($cart);
            $this->saveCart($cart);
            return $count;           
        }
        
    }
    //清楚购物车商品
    public function delCart($id){
        if(is_array($id)){
            $cart = $this->getList();
            foreach($id as $vo){
                unset($cart[$vo]);
            };
            $count = count($cart);
            $this->saveCart($cart);
            return $count;
        }else{
            return false;
        }
    }
    //清空购物车
    public function cleanCart(){
        $key = 'shop_'.get_token();
        cookie($key,null);
    }
    //改变商品数量
    public function editCart(){
        
    }
    
    //获取 (包含商品信息，及商品总计唉等信息
    public function cgetList(){
        $list = $this->getList();
        $data = array();
        foreach($list as $key=>$value){
            $map['id'] = $key;
            $info = D ( 'Addons://Shop/Products' )->getInfo($map);
            if($info){
                $info['head_img'] = get_cover_url($info['head_img']);
                $info['total_price'] = number_format($info['true_price']*$value,2,".","");
                $info['cartnum'] = $value;
                $data[] = $info;
            }else{
                //如果找不到此商品，则直接在购物车中清楚此商品记录
                $id[] = $key;
                $this->delCart($id);
            }
        }
        return $data;
    }
    //获取商品数量
    public function getCount(){
        $list = $this->getList();
        $num = count($list);
        return $num;
    }
}
