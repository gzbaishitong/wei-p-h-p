<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 任务列表模型
 */
class DutyModel extends Model{
    protected $tableName = 'dutylist';

   public function getList()//主页获取当天任务
   {
       $localtime=time();
       $info=$this->where("$localtime>=begintime and $localtime<endtime")->find();
       return $info;
   }



    public function getInfo($id)//任务信息
    {
        $map['token']=get_token();
        $map['id']=$id;
        $Info=$this->where($map)->find();
        return $Info;
    }




}
