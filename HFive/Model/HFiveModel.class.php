<?php

namespace Addons\HFive\Model;
use Think\Model;

/**
 * HFive模型
 */
class HFiveModel extends Model{
   protected $tableName='hfiverecord';

    public function getInfo($name)
    {
        $HFiveMo=M('hfive');
        $map['name']=$name;
        $Info=$HFiveMo->where($map)->find();
        if($Info)
        {
            return $Info;
        }
        return false;
    }
    public function addrecord($openid,$name)
    {
           $Info=$this->getInfo($name);//h5信息
        $count=$this->getcount($openid);//当前h5分享总条数
        $data['token']=get_token();
        $data['addtime']=time();
        $data['lastid']=$Info['id'];
        $data['openid']=$openid;
        $query=$this->add($data);
        if($query)
        {
            return true;
        }
        return false;
    }

    public function getcount($openid)//计算总条数
    {
         $map['openid']=$openid;
        $count=$this->where($map)->count();
        return $count;
    }
    public function saveinfo($openid,$telphone,$name,$info)//保存信息
    {
        $MemMo=M('hfivemember');
        $HFiveMo=M('hfive');
        $map['name']=$name;
        $Info=$HFiveMo->where($map)->find();
        $map['openid']=$openid;
        $MemFind=$MemMo->where($map)->find();
        if($MemFind)
        {
            $data['isshare']=1;
            $data['addtime']=time();
            $data['subscribe']=$info['subscribe'];
            $query=$MemMo->where($map)->save($data);
        }
        else {
            $data['openid']=$openid;
            $data['addtime']=time();
            $data['token']=get_token();
            $data['lastid']=$Info['id'];
            $data['telphone']=$telphone;
            $query = $MemMo->add($data);
        }
        return $query;
    }
    public function getMemberInfo($openid)//获取用户信息
    {
        $MemMo=M('hfivemember');
        $map['openid']=$openid;
        $Info=$MemMo->where($map)->find();
        return $Info;
    }

}
