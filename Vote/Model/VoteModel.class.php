<?php

namespace Addons\Vote\Model;

use Think\Model;
class VoteModel extends Model {
    protected $tableName='vote_option';
    public function getInfo($openid)//获取参赛用户投票选项
    {
        $map['openid1']=$openid;
        $map['openid2']=$openid;
        $map['_logic']='OR';
        $info=$this->where($map)->find();
        return $info;
    }
    public function getOption($opt_id)
    {
        $map['id']=$opt_id;
        $info=$this->where("id='$opt_id'")->find();
        return $info;
    }

    public function getList($len)
    {
        $list=$this->order('opt_count desc')->limit($len)->select();
        return $list;
    }

    public function saveinfo($voteid,$openid,$vote_id)//增加投票数
    {
        $data['headimgurl']=$_SESSION['userinfo']['headimgurl'];
        $data['nickname']=$_SESSION['userinfo']['nickname'];
        $data['openid'] = $openid;
        $data ["vote_id"] = $vote_id;
        $data ["token"] = get_token();
        $data ["options"] = $voteid;
        $data ["cTime"] = time();
        $data['date'] = date('Y-m-d', time());
        $query=M("vote_log")->add($data);
        $OptInfo=$this->getOption($voteid);
        $datas['opt_count']=$OptInfo['opt_count']+1;
        $query=$this->where("id='$voteid'")->save($datas);
        if($query)
        {
            return true;
        }
        return false;
    }


}