<?php

namespace Addons\Shop\Model;
use Think\Model;
//use Think\Page;

/**
 * 收货地址 模型
 */
class AddressModel extends Model{
    protected $tableName = 'shop_address';
    protected $errormsg;
    //初始化
    public function getErrorMsg(){
        return $this->errormsg;
    }
    //获取收货地址列表
    public function getList($map){
        $list = $this->where($map)->select();
        return $list;
    }

    //获取详情
    public function getInfo($map) {
        //$map['token'] = get_token();
        $info = $this->where($map)->find();
        return $info;
    }
    
    //保存地址信息
    public function addAddress($data){
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        if($data['is_default'] == 1){
            //将其他的设置为2
            $this->where($map)->setField('is_default', 2);
        }
        $result = $this->add($data);
        return $result;
    }
    
    //修改地址信息
    public function editAddress($data){
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        if($data['is_default'] == 1){
            //将其他的设置为2
            $this->where($map)->setField('is_default', 2);
        }
        $result = $this->save($data);
        return $result;
    }
    
    //删除地址
   public function delAddress($id){
        $map['id'] = $id;
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        
        $result = $this->where($map)->delete();
        $this->setDefault();
        return $result;
   }
    
    //切换默认收货地址
    public function setDefault(){
        $map['token'] = get_token();
        $map['openid'] = $_SESSION['openid'];
        $map['is_default'] = 1;
        $result = $this->where($map)->find();
        if(!$result){
            $map['is_default'] = 2;
            $result = $this->where($map)->find();
            $this->where('id="'.$result['id'].'"')->setField('is_default',1);
        }
    }
}
