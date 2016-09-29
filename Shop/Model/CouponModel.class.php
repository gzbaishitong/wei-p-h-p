<?php

namespace Addons\shop\Model;
use Think\Model;

/**
 * 优惠券模型
 */
class CouponModel extends Model{
    protected $tableName = 'coupons';
    public function getList($id)//获得指定商品的电子券一张
    {
        $map['isuse']=0;
        $map['token']=get_token();
        $map['product_id']=$id;
        $list= $this->where($map)->order('id desc')->limit(1)->select();
        return $list;
    }

    public function getInfo($id)//获取指定优惠券信息
    {
        $map['id']=$id;
        $list=$this->where($map)->find();
        return $list;
    }

    public function isuse($id)//把优惠券改成已使用
    {
        $map['id']=$id;
        $data['isuse']=1;
        $query=$this->where($map)->save($data);
        if($query)
        {
            return true;
        }
        return false;
    }
}