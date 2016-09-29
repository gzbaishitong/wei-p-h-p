<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;


class I7Controller extends AddonsController{
    public function index()
    {
        header('Content-Type: text/html; charset=utf-8');
        $this->display();
    }


    public function createimg()
    {
        $name = I('name');
        $length1=strlen($name);
        $rand=rand(10000,30000);
        $dst_path1 = 'http://addon.gzbaishitong.com/weiphp/Uploads/Download/i71.jpg';
        // $dst_path = 'http://addon.gzbaishitong.com/weiphp/Uploads/Download/i72.jpg';
//创建图片的实例
        // $dst = imagecreatefromstring(file_get_contents($dst_path));
        $dst1=imagecreatefromstring(file_get_contents($dst_path1));
//打上文字
        $font = 'STHeiti-Light.ttc';//字体
        $black = imagecolorallocate($dst1,109 , 112, 119);//字体颜色
     
                imagefttext($dst1, 18, 0, 170, 360, $black, $font, $rand);
                imagefttext($dst1, 30, 0, 230, 300, $black, $font, $name);
            
        
//输出图片
//                header('Content-Type: image/jpeg');
       $randnum=time().rand(0,9999);
		$img1='Uploads/Download/'.$randnum.'.jpg';
        imagejpeg($dst1,$img1);
        // $this->assign('img','Uploads/Download/i73.jpg');
        $this->assign('img1',$img1);
        $this->display();
 

    }
}