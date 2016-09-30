<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章分类模型
 */
class NewsTypeModel extends Model{
    protected $tableName = 'newstype';
    public function getList($map)//获取文章分类列表
    {
        $map['token']=get_token();
        $info=$this->where($map)->select();
        return $info;
    }
    public function getInfo($map)//获取单条文章信息
    {
        $map['token']=get_token();
        $info=$this->where($map)->find();
        return $info;
    }
}
