<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 签到模型
 */
class AcctivityModel extends Model{
    protected $tableName = 'acctivity';
    public function getInfo($typeid)//获取日常签到信息
    {
        $map['typeid']=$typeid;
        $map['token']=get_token();
        $info=$this->where($map)->find();
        return $info;
    }

    public function reduceprize($info,$prize)//减少奖品数量
    {
        $info[$prize]-=1;
        $this->save($info);
    }
}
