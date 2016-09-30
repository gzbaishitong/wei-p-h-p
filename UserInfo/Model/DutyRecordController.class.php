<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 任务列表模型
 */
class DutyRecordModel extends Model{
    protected $tableName = 'dutyrecord';


    public function addrecord($data)//新增完成任务记录
    {
        $query=$this->add($data);
        return $query;
    }

    public function getcount($map)//获取单个用户记录条数
    {
           $count=$this->where($map)->count();
        return $count;
    }




}
