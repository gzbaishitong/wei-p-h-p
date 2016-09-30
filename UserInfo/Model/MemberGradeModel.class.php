<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 会员等级模型
 */
class MemberGradeModel extends Model{
    protected $tableName = 'membergrade';
   public function getList()
   {
       $info=$this->select();
       return $info;
   }

    public function getInfo($map)
    {
             $info=$this->where($map)->find();
        return $info;
    }




}
