<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章分类模型
 */
class ShopBannerModel extends Model{
    protected $tableName = 'shop_banner';
    public function getList($type)//获取幻灯片列表
    {
        $map['type']=$type;
        $map['token']=get_token();
        $info=$this->where($map)->select();
        return $info;
    }

}
