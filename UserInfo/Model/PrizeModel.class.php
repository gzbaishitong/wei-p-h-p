<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 中奖模型
 */
class PrizeModel extends Model{
    protected $tableName = 'qiandaoprize';
    public function addrecord($info,$prize,$acinfo)//新增中奖纪录
    {
        $data['actype']=$acinfo['name'];
         $data['prize']=$prize;
        $data['userid']=$info['id'];
        $data['nickname']=$info['nickname'];
        $data['token']=get_token();
        $data['addtime']=time();
        $data['date']=date('Y-m-d',time());
        $query=$this->add($data);
    }
}
