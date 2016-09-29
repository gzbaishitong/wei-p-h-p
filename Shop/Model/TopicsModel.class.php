<?php

namespace Addons\Shop\Model;
use Think\Model;
//use Think\Page;

/**
 * cart 购物车 模型
 */
class TopicsModel extends Model{
    protected $tableName = 'shop_topic';
    protected $errormsg;
    //初始化
    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取专题列表
    public function getList($map){
        $map['token'] = get_token();//???在哪里加入tokne呢？
        $list = $this->where($map)->order('sort asc')->select();
        return $list;
    }
    //获取专题信息
    public function getInfo($map) {
        $map['token'] = get_token();
        $info = $this->where($map)->find();
        return $info;
    }
    
    //获取所有信息 (包含自商品
    public function getAllInfo($map){
        $info = $this->getInfo($map);
        if($info['products_id']){
            $info['products_info'] = $this->haveProducts($info['products_id']);
        }else{
            $info['products_info'] = array();
        }
        return $info;
    }
    
    //获取所含商品
    public function haveProducts($products_id){
        //获取已选择的商品数据
        $select_data = array();
        $p_id = explode(',', $products_id);
        foreach($p_id as $vo){
            $map['id'] = $vo;
            $result= D('Addons://Shop/Products')->getInfo($map);
            if(!$result) continue;
            $select_data[] = $result;
        }
        return $select_data;
    }
   
    //修改所含商品
    public function saveProducts($map,$data){
        return $this->where($map)->save($data);
    }
}
