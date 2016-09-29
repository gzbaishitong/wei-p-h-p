<?php

namespace Addons\Shop\Model;
use Think\Model;

/**
 *  购物车 分类模型 
 */
class BannerModel extends Model{
    protected $tableName = 'shop_banner';

    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取分类列表
    public function getList($map){
        $map['is_show'] = 1;//只读取显示的数据
        $map['type']='商城';
        $list = $this->where ( $map )->order('sort asc')->select ();
        return $list;
    }
    //获取单个分类
    public function getInfo($map){
        //$info = $this->where($map)->find();
        //return $info;
    }
    //增加商品
    
    //删除商品
    public function del() {
        
    }
    //修改商品
    public function edit(){
        
    }
}
