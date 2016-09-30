<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 红包记录模型
 */
class RedBagModel extends Model{
    protected $tableName = 'redbagrecord';
   public function getcount($openid)
   {
      $map['openid']=$openid;
       $count=$this->where($map)->count();
       return $count;
   }

    public function addrecord($data)
    {
        $this->add($data);
    }

    public function getList()
    {
        $list=$this->select();
        return $list;
    }
}
