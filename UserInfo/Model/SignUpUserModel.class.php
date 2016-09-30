<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章分类模型
 */
class SignUpUserModel extends Model{
    protected $tableName = 'signupuser';


    public  function adduser($data)//获取活动信息
    {
        $info=$this->add($data);
        return $info;
    }

    public function getInfo($openid)
    {
        $map['openid']=$openid;
        $info=$this->where($map)->find();
        return $info;
    }

    public function getOrderInfo($map)
    {
        $info=$this->where($map)->find();
        return $info;
    }

    public function updateinfo($map,$data)
    {
       $this->where($map)->save($data);
    }

    public function getsurecount($id)//获取已报名人数
    {
        $map['typeid']=$id;
        $map['ispay']=1;
        $count=$this->where($map)->count();
        return $count;
    }

}
