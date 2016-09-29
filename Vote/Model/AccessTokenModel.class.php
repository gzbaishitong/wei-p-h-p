<?php

namespace Addons\Vote\Model;

use Think\Model;

/**
 * access_token模型
 */
class AccessTokenModel extends Model {
    protected  $tableName='access_token';
    public function saveinfo($access_token,$method)
    {
         $data['access_token']=$access_token;
        $data['time']=time()+1800;
        $data['addtime']=time();
        $data['token']=get_token();
        if($method==0) {
            $this->add($data);
        }
        else
        {
            $map['token']=get_token();
            $Info=$this->where($map)->find();
            $Info['access_token']=$access_token;
            $Info['time']=time()+1800;
            $Info['addtime']=time();
            $this->save($Info);
        }
    }

    public function isvalid()//判断access_token是否有效
    {
        $localtime=time();
          $Info=$this->select();
        if(!$Info)//如果access_token为空
        {
            return 0;
        }
        if($Info['time']<$localtime)//如果access_token过期
        {
            return 2;
        }
        return 1;
    }

    public function getInfo()//获取当前access_token
    {
        $map['token']=get_token();
        $Info=$this->where($map)->find();
        return $Info;
    }
}
