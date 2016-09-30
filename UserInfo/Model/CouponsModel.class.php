<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 优惠券模型
 */
class CouponsModel extends Model{
    protected $tableName = 'coupons';

    public function updatecoupons($info,$acinfo)//中奖新增
    {
        $map['isuse']=0;
        $map['type']=0;
        $map['userid']='';
        $map['token']=get_token();
        $maxid=$this->where($map)->max('id');//最大中奖优惠券id
        $data['userid']=$info['id'];
        $data['img']=$acinfo['secondimg'];
        $coumap['id']=$maxid;
        $query=$this->where($coumap)->save($data);
    }

    public function getList($id)//单个用户优惠券列表
    {
        $map['userid']=$id;
        $map['token']=get_token();
        $map['isuse']=0;
        $list=$this->where($map)->select();
        return $list;
    }

    public function getInfo($type)//随机获取单条优惠券信息
    {
        $map['token']=get_token();
        $map['type']=$type;
        $map['isuse']=0;
        $map['userid']='';
        $id=$this->where($map)->max('id');
        $map['id']=$id;
        $Info=$this->where($map)->find();
        return $Info;
    }

    public function isuse($id)//把优惠券改为已使用状态
    {
        $map['id']=$id;
        $map['token']=get_token();
        $data['isuse']=1;
        $this->where($map)->save($data);
    }


}
