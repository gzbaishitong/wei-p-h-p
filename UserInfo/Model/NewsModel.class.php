<?php

namespace Addons\UserInfo\Model;
use Think\Model;

/**
 * 文章模型
 */
class NewsModel extends Model{
    protected $tableName = 'news';
    public function getList($map)//获取文章列表
    {
        $map['token']=get_token();
        $info=$this->where($map)->order('id desc')->select();
        return $info;
    }

    public function getInfo($map)//获取单条文章信息
    {
        $map['token']=get_token();
        $info=$this->where($map)->find();
        return $info;
    }
    public function addscore($openid,$id,$method,$recommendedopenid)//文章新增积分(推荐人openid，文章id，方式，观看人openid)
    {
        //开始查询用户信息
        $UserMo=M('userinfo');
        $Usermap['openid']=$openid;
        $Usermap['token']=get_token();
        $UserFind=$UserMo->where($Usermap)->find();
        //结束查询用户信息


        //开始查询推荐人文章积分记录条数
        $localtime=date('Y-m-d',time());//当前日期
        $recordmap['newsid'] = $id;
        $recordmap['userid'] = $UserFind['id'];
        $recordmap['date'] = $localtime;
        $recordmap['token']=get_token();
        $recordmap['method']='分享给好友阅读文章';
//        if($recommendedopenid!='')
//        {
//            $recordmap['recommendedopenid']=$recommendedopenid;
//        }
//        else
//        {
//            $recordmap['recommendedopenid']=$openid;
//        }
        $count = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//每人每天文章转发次数

        //开始查询推荐人文章积分记录条数
        $localtime=date('Y-m-d',time());//当前日期
        $recordallmap['newsid'] = $id;
        $recordallmap['userid'] = $UserFind['id'];
        $recordallmap['token']=get_token();
        $recordallmap['method']='分享给好友阅读文章';
//        if($recommendedopenid!='')
//        {
//            $recordmap['recommendedopenid']=$recommendedopenid;
//        }
//        else
//        {
//            $recordmap['recommendedopenid']=$openid;
//        }
        $allcount = D('Addons://UserInfo/NewsRecord')->getcount($recordallmap);//每人每天文章转发次数
//结束查询推荐人文章积分记录条数

        //开始查询观看人文章积分记录条数
        $recordmaps['newsid'] = $id;
        $recordmaps['userid'] = $UserFind['id'];
        if($recommendedopenid!='')
        {
            $recordmaps['recommendedopenid']=$recommendedopenid;
        }
        else
        {
            $recordmaps['recommendedopenid']=$openid;
        }
        $recordmaps['token']=get_token();
        $recordmaps['method']='阅读文章';
        $recommendedcount = D('Addons://UserInfo/NewsRecord')->getcount($recordmaps);//观看人每日观看次数

//结束查询观看人文章积分记录条数

        //开始查询单条文章信息
        $map['id']=$id;
        $Info=$this->where($map)->find();
        //结束查询单条文章信息

        $readmap['userid']=$UserFind['id'];
        $readmap['newsid']=$id;
        $readmap['method']='阅读文章';
        $readmap['token']=get_token();
        $readcount=D('Addons://UserInfo/NewsRecord')->getcount($readmap);//文章阅读积分次数
        if ($Info['isaddscore'] == 1) {
            if ($recommendedcount < 1) {
                if ($method == 'r') {//阅读文章
                    if ($Info['readscore'] != 0) {
                        if ($readcount < 1) {
                            $userData['score'] = $UserFind['score'] + $Info['readscore'];
                            $query = $UserMo->where($Usermap)->save($userData);
                            if ($query) {
                                D('Addons://UserInfo/NewsRecord')->addscorerecord('阅读文章', $UserFind, $Info,$openid,$Info['readscore']);
                            }
                        }
                    }
                } else if ($method == 'sf')//分享到朋友圈
                {
                    if ($Info['sharecounttotal'] != 0) {
                        if ($allcount < $Info['sharecounttotal']) {
//                            $recordmap['newsid'] = $id;
//                            $recordmap['userid'] = $UserFind['id'];
//                            $recordmap['date'] = $localtime;
//                            $count = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//每人每天文章转发次数
                            if ($Info['sharecountday'] != 0) {
                                if ($count < $Info['sharecountday']) {
                                    $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                    $query = $UserMo->where($Usermap)->save($userData);
                                    if ($query) {
                                        D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                        return true;
                                    }
                                }
                            } else {
                                $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                $query = $UserMo->where($Usermap)->save($userData);
                                if ($query) {
                                    D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                    return true;
                                }
                            }

                        }
                    } else {
//                        $recordmap['newsid'] = $id;
//                        $recordmap['userid'] = $UserFind['id'];
//                        $recordmap['date'] = $localtime;
//                        $count = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//每人每天文章转发次数
                        if ($Info['sharecountday'] != 0) {
                            if ($count < $Info['sharecountday']) {
                                $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                $query = $UserMo->where($Usermap)->save($userData);
                                if ($query) {
                                    D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                    return true;
                                }
                            }
                        } else {
                            $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                            $query = $UserMo->where($Usermap)->save($userData);
                            if ($query) {
                                D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                return true;
                            }
                        }
                    }
                } else {
                    if ($Info['issharefriend'] == 0) {
                        if ($Info['sharecounttotal'] != 0) {
                            if ($count < $Info['sharecounttotal']) {
//                                $recordmap['newsid'] = $id;
//                                $recordmap['userid'] = $UserFind['id'];
//                                $recordmap['date'] = $localtime;
//                                $count = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//每人每天文章转发次数
                                if ($Info['sharecountday'] != 0) {
                                    if ($count < $Info['sharecountday']) {
                                        $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                        $query = $UserMo->where($Usermap)->save($userData);
                                        if ($query) {
                                            D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                            return true;
                                        }
                                    }
                                } else {
                                    $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                    $query = $UserMo->where($Usermap)->save($userData);
                                    if ($query) {
                                        D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                        return true;
                                    }
                                }

                            }
                        } else {
//                            $recordmap['newsid'] = $id;
//                            $recordmap['userid'] = $UserFind['id'];
//                            $recordmap['date'] = $localtime;
//                            $count = D('Addons://UserInfo/NewsRecord')->getcount($recordmap);//每人每天文章转发次数
                            if ($Info['sharecountday'] != 0) {
                                if ($count < $Info['sharecountday']) {
                                    $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                    $query = $UserMo->where($Usermap)->save($userData);
                                    if ($query) {
                                        D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                        return true;
                                    }
                                }
                            } else {
                                $userData['score'] = $UserFind['score'] + $Info['sharescore'];
                                $query = $UserMo->where($Usermap)->save($userData);
                                if ($query) {
                                    D('Addons://UserInfo/NewsRecord')->addscorerecord('分享给好友阅读文章', $UserFind, $Info,$recommendedopenid, $Info['sharescore']);
                                    return true;
                                }
                            }
                        }
                    }
                }
                //开始判断是否提升会员升级
                $UserFind = $UserMo->where($Usermap)->find();//当前用户信息
                $MemberList = D('Addons://UserInfo/MemberGrade')->getList();//会员等级信息
                if ($UserFind['score'] >= $MemberList['2']['score']) {
                    $data['membergrade'] = $MemberList['2']['name'];
                    $query = D('Addons://UserInfo/UserInfo')->edituser($openid, $data);//提升会员等级
                } else if ($UserFind['score'] >= $MemberList['1']['score']) {
                    $data['membergrade'] = $MemberList['1']['name'];
                    $query = D('Addons://UserInfo/UserInfo')->edituser($openid, $data);//提升会员等级
                }
                //结束判断是否提升会员升级
            }
        }
    }
    public function addreadcount($id)//增加阅读量
    {
        $map['id']=$id;
        $info= $this->getInfo($map);
        $data['count']=$info['count']+1;
        $query=$this->where($map)->save($data);
    }


}
