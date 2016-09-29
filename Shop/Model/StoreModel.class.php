<?php

namespace Addons\shop\Model;
use Think\Model;

/**
 * cart 购物车 模型
 */
class StoreModel extends Model{

    protected $tableName = 'storeinfo';

    public function getInfo($id){
        $map['id']=$id;
        $Info=$this->where($map)->find();
        return $Info;
    }


}
