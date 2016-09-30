<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章分类模型
 */
class SignUpModel extends Model{
    protected $tableName = 'signup';
    public function getList()//获取活动列表
    {
        $map['token']=get_token();
        $info=$this->where($map)->select();
        return $info;
    }

    public  function getInfo($id)//获取活动信息
    {
        $map['id']=$id;
        $info=$this->where($map)->find();
        return $info;
    }

    public function getTop($limit)
    {
        $map['token']=get_token();
        $info=$this->where($map)->order('begintime desc')->limit($limit)->select();
        return $info;
    }



}
