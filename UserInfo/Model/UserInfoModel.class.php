<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 会员模型
 */
class UserInfoModel extends Model{
    protected $tableName = 'userinfo';
    public function getInfo($map)//获取用户信息
    {
        $map['token']=get_token();
        $mapp['istel']=1;
        $info=$this->where($map)->find();
        return $info;
    }

    public function adduser($map,$data)
    {
        if(empty($map)) {
            $result = $this->add($data);
        }
        else
        {
            $map['token']=get_token();
            $result = $this->where($map)->save($data);
        }
        return $result;
    }

    public function deluser($map)//删除用户信息
    {
        $map['token']=get_token();
        $result=$this->where($map)->delete();
    }

    public  function saveuserinfo($openid,$info)//自动保存微信用户信息
    {
        $Data['nickname']=$info['nickname'];
        $Data['headimgurl']=$info['headimgurl'];
        $token=get_token();
        $result=$this->where("openid='$openid' AND token='$token'")->save($Data);
    }

    public function addscore($openid,$score)//用户新增积分
    {
        $map['openid']=$openid;
        $map['token']=get_token();
        $info=$this->where($map)->find();
        $info['score']=$info['score']+$score;
        $query=  $this->save($info);
//        return $query;
        //开始判断是否提升会员升级
        $UserFind=$this->where($map)->find();//当前用户信息
        $MemberList=D('Addons://UserInfo/MemberGrade')->getList();//会员等级信息
        if($UserFind['score']>=$MemberList['2']['score'])
        {
            $datas['membergrade']=$MemberList['2']['name'];
            $query=D('Addons://UserInfo/UserInfo')->edituser($openid,$datas);//提升会员等级
        }
        else if($UserFind['score']>=$MemberList['1']['score'])
        {
            $datas['membergrade']=$MemberList['1']['name'];
            $query=D('Addons://UserInfo/UserInfo')->edituser($openid,$datas);//提升会员等级
        }
        //结束判断是否提升会员升级
    }

    public function edituser($openid,$data)//修改会员信息
    {
        $map['token']=get_token();
        $map['openid']=$openid;
        $query=$this->where($map)->save($data);
    }
}
