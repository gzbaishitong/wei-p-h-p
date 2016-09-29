<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;


class TigerController extends BaseController{
    function _initialize()
    {
        parent::_initialize();
    }
    public function index()
    {
//        $openid=$_SESSION['openid'];
//        $OptionMo=M('tigerprize');//选项模型
//        $PrizeMo=M('tigerprizerecord');//中奖模型
//        $ShareMo=M('tigersharerecord');//分享记录模型
//        $RecordMo=M('tigerrecord');//抽奖记录模型
//        $OptionList=$OptionMo->order('probability asc')->select();//选项列表
//        $UserMo=M('tigeruser');//用户模型
//        $map['openid']=$openid;
//        $UserInfo=$UserMo->where($map)->find();//用户信息
//        //开始新增用户信息
//        if(!$UserInfo)
//        {
//            $UserData['openid']=$openid;
//            $UserData['token']=get_token();
//            $UserData['headimgurl']=$_SESSION['userinfo']['headimgurl'];
//            $UserData['nickname']=$_SESSION['userinfo']['nickname'];
//            $UserMo->add($UserData);
//        }
//
//
//        //结束新增用户信息
//        if(IS_AJAX)
//        {
//
//            $localtime=date('Y-m-d',time());//当前日期
//            $RecordCount=$RecordMo->where("openid='$openid' AND date='$localtime'")->count();//当天抽奖次数
//            $PrizeCount=$RecordMo->where("openid='$openid' AND date='$localtime'")->count();//当前中奖次数
//            $ShareCount=$ShareMo->where("openid='$openid' AND date='$localtime'")->count();//当天分享次数
//            if($ShareCount==1)//如果分享
//            {
//                if(($RecordCount+$PrizeCount)>=3)
//                {
//                     $this->error('请明天再来吧');
//                }
//            }
//            else
//            {
//                if(($RecordCount+$PrizeCount)>=2)
//                {
//                    $this->error('请明天再来吧');
//                }
//            }
//            $rand=rand(1,10000);
//            $openid=$_SESSION['openid'];
//            $map['openid']=$openid;
//            $UserInfo=$UserMo->where($map)->find();//用户信息
//            $OptionList=$OptionMo->order('probability asc')->select();//选项列表
//            $OptionMaxid=$OptionMo->max('id');//选项最大id
//            $OptionMinid=$OptionMo->min('id');//选项最小id
//            $Optionid=rand($OptionMinid,$OptionMaxid);//选项id
//            $OptionInfo=$OptionMo->where("id='$Optionid'")->find();//选项信息
//              if($rand<=$OptionInfo['probability'])//如果中奖
//              {
//                  $PrizeData['addtime']=time();
//                  $PrizeData['date']=date('Y-m-d',time());
//                  $PrizeData['prize']=$val['desc'];
//                  $PrizeData['openid']=$openid;
//                  $PrizeData['nickname']=$UserInfo['nickname'];
//                  $PrizeMo->add($PrizeData);
//                $this->success($OptionInfo['id']);
//              }
//                else//没中奖
//                {
//                    $RecordData['token']=get_token();
//                    $RecordData['date']=date('Y-m-d',time());
//                    $RecordData['addtime']=time();
//                    $RecordData['openid']=$openid;
//                    $RecordData['nickname']=$UserInfo['nickname'];
//                    $RecordMo->add($RecordData);
//                    $this->error($val['id']);
//                }
//        }
        $map['openid']=$_SESSION['openid'];
        $count=M('tigerrecord')->where($map)->count();
        $this->assign('count',$count);
        if(IS_AJAX)
        {
$data['openid']=$_SESSION['openid'];
         $query=   M('tigerrecord')->add($data);
            if($count<1) {
                if ($query) {
                    $this->success();
                }
            }

        }
        $signPackage=getjssdk();
        $this->assign('nickname',$_SESSION['userinfo']['nickname']);
        $this->assign('signPackage',$signPackage);
//        $this->assign('OptionList',$OptionList);
        $this->display();
    }
}