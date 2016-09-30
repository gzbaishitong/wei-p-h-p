<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章记录模型
 */
class NewsRecordModel extends Model{
    protected $tableName = 'newsrecord';
    public function getcount($map)//获取用户文章积分记录条数
    {
        $map['token']=get_token();
        $count=$this->where($map)->count();
        return $count;
    }
    public function addscorerecord($method,$userinfo,$newsinfo,$recommendedopenid,$score)//新增文章积分记录
    {
        $data['nickname']=$userinfo['nickname'];
        $data['score']=$score;
        $data['userid']=$userinfo['id'];
        $data['method']=$method;
        $data['recommendedopenid']=$recommendedopenid;
        $data['date']=date('Y-m-d',time());
        $data['newsid']=$newsinfo['id'];
        $data['addtime']=time();
        $data['title']=$newsinfo['title'];
        $data['token']=$userinfo['token'];
        $this->add($data);
    }

    public function getList($id,$count)
    {
        $map['userid']=$id;
        if($count!='') {
            $List = $this->where($map)->order('addtime desc')->limit($count)->select();
        }
        else
        {
            $List = $this->where($map)->order('addtime desc')->select();
        }
        return $List;
    }


}
