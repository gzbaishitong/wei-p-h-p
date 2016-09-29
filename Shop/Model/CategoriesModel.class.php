<?php

namespace Addons\Shop\Model;
use Think\Model;

/**
 *  购物车 分类模型 
 */
class CategoriesModel extends Model{
    protected $tableName = 'shop_categories';

    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取分类列表
    public function getList($map){
        $list = $this->where ( $map ) ->order('sort asc')->select ();
        return $list;
    }
    //获取单个分类
    public function getInfo($map){
        $info = $this->where($map)->find();
        return $info;
    }
    //增加商品
    
    //删除商品
    public function del() {
        
    }
    //修改商品
    public function edit(){
        
    }
    
    //获取分级后的分类信息 (仅支持二级分类） 用于后台显示
    public function cgetList($map){
        $map['token'] = get_token();
        $list = $this->getList($map);
        foreach($list as $key=>$vo){
            if($vo['pid'] != 0) continue;
            $one_arr[$vo['id']] = $vo;
            unset($list[$key]);
        }
        foreach ( $one_arr as $p ) {
            $data [] = $p;

            $two_arr = array ();
            foreach ( $list as $key => $l ) {
                    if ($l ['pid'] != $p ['id'])
                            continue;
                    $l ['name'] = '├──' . $l ['name'];
                    $two_arr [] = $l;
                    unset ( $list [$key] );
            }
            $data = array_merge ( $data, $two_arr );
        }
        return $data;
    }
    
    //获取分级后的分类信息 (仅支持二级分类)用于前台显示
    public function arrgetList($map){
        $map['is_show'] = 1;//前台仅显示允许显示的分类！
        $list = $this->getList($map);
        //循环一级分类
        foreach($list as $key=>$vo){
          if($vo['pid'] != 0) continue;
          $one_arr[$vo['id']] = $vo;
          unset($list[$key]);
        }
        //循环二级分类
        foreach ( $one_arr as &$p ) {
            foreach ( $list as $key => $l ) {
                    if ($l ['pid'] != $p ['id'])
                            continue;
                    $l['url'] = addons_url('Shop://Index/productslist',array('cate_id'=>$l['id']));
                    $p['child'][] = $l;
                    unset ( $list [$key] );
            }
            //$data = array_merge ( $data, $two_arr );
        }
        //处理分类，给分类加上全部功能
        foreach($one_arr as &$vo){
            if(isset($vo['child'])){
                $all[0] = array('id'=>$vo['id'],'name'=>'全部','url'=> addons_url('Shop://Index/productslist',array('cate_id'=>$vo['id'])));
                $vo['child'] = array_merge($all,$vo['child']);
            }else{
                $vo['url'] = addons_url('Shop://Index/productslist',array('cate_id'=>$vo['id']));
            }
        }
        return $one_arr;
    }
}
