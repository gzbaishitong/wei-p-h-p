<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 签到记录模型
 */
class ActivityRecordModel extends Model{
    protected $tableName = 'activityrecord';
    public function getcount($userid,$primaryid)//获取单条用户当天签到记录条数
    {
       $map['userid']=$userid;
        $map['date']=date('Y-m-d',time());
        $map['primaryid']=$primaryid;
        $map['token']=get_token();
        $count=$this->where($map)->count();
        return $count;
    }

    public function getallcount($userid,$primaryid)//获取单条用户签到总记录条数
    {
        $map['userid']=$userid;
        $map['token']=get_token();
        $map['primaryid']=$primaryid;
        $count=$this->where($map)->count();
        return $count;
    }
   public function getList($userid,$primaryid)//获取用户最新签到数据
   {
       $map['userid']=$userid;
       $map['token']=get_token();
       $map['primaryid']=$primaryid;
       $id=$this->where($map)->max('id');
       $map['id']=$id;
       $Info=$this->where($map)->find();
//       $localtime=strtotime(date('Y-m-d',time()));//当前日期
       return $Info;
   }
    public function addrecord($info,$acinfo,$score)//新增签到记录
    {
        //连续签到天数加1
        $UserMo=M('userinfo');
        $SignInfo=$this->getList($info['id'],$acinfo['id']);//用户最新签到数据
        $localtime=strtotime(date('Y-m-d',time()));//当前日期
        if(($localtime-strtotime($SignInfo['date']))>24*60*60)//当不是连续签到时
        {
            $UserData['signcount']=1;
        }
        else
        {
            $UserData['signcount']=$info['signcount']+1;
        }
        $map['id']=$info['id'];
        $UserMo->where($map)->save($UserData);
        //结束连续签到人数加1
        $data['actype']=$acinfo['name'];
        $data['score']=$score;
        $data['nickname']=$info['nickname'];
        $data['date']=date('Y-m-d',time());
        $data['token']=get_token();
        $data['addtime']=time();
        $data['userid']=$info['id'];
        $data['primaryid']=$acinfo['id'];
        $query=$this->add($data);
        return $query;
    }

    public function getRecord($id,$count)//活动积分记录
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
