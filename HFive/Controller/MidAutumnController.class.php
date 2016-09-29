<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;

//中秋生成器
class MidAutumnController extends AddonsController{
    public function index()
    {
        $this->display();
    }

    public function createimg()
    {
        $img=I('fimg');
        $name=I('fname');
        $male=I('male');//男星
        $female=I('female');//女星
        switch($male)
        {
            case 0:
                $male='每逢中秋佳节倍思亲,好想我家宝贝';
                $malename='胡歌';
                break;
            case 1:
                $male='中秋节快乐~宝贝记得早点回来哦~';
                $malename='陈伟霆';
                break;
            case 2:
                $male='亲爱的,我把月亮摘给你独赏好不好';
                $malename='王思聪';
                break;
            case 3:
                $male='中秋快乐~今晚我只想好好看着你~';
                $malename='杨洋';
                break;
            case 4:
                $male='宝贝~想吃鲜肉馅的月(yi)饼(fan)吗?';
                $malename='吴亦凡';
                break;
            case 5:
                $male='撒浪嘿~中秋是中国的,但你是我的';
                $malename='宋仲基';
                break;
        }
        switch($female)
        {
            case 0:
                $female='中秋快乐~每一天都要照顾好自己！';
                $femalename='范冰冰';
                break;
            case 1:
                $female='和我一样集美貌才华于一身的女子';
                $femalename='Papi酱';
                break;
            case 2:
                $female='宝贝~吃月饼也要记得来吃人家哦~';
                $femalename='小S';
                break;
            case 3:
                $female='祝宝贝中秋团圆~记得多吃月饼哦~';
                $femalename='Angelababy';
                break;
            case 5:
                $female='美好时光从我的祝福开始:中秋快乐';
                $femalename='赵丽颖';
                break;
        }
        $male=$male;
        $female=$female;
        $img=explode(',',$img);
        $rand=time().rand(1,9999);
        $path='Uploads/Download/MidAutumn/'.$rand.'.jpg';
        file_put_contents($path,base64_decode($img[1]));
        $dst_path ="http://addon.rtda.cn/weiphp/".$path;
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $font = 'STHeiti-Light.ttc';//字体
        $black = imagecolorallocate($dst, 0 , 0, 0);//字体颜色
        $pink=imagecolorallocate($dst, 97 , 143, 169);//字体颜色
        $pinks=imagecolorallocate($dst, 108 , 107, 113);//字体颜色
        imagefttext($dst, 16, 0, 380, 202, $pink, $font, '@'.$name);
        imagefttext($dst, 20, 0, 110, 622, $pinks, $font, $malename);
        imagefttext($dst, 20, 0, 110, 782, $pinks, $font, $femalename);
        imagefttext($dst, 18, 0, 110, 947, $pinks, $font, $name);
        imagefttext($dst, 18, 0, 108, 672, $black, $font, $male);
        imagefttext($dst, 16, 0, 480, 672, $pink, $font, '@'.$name);
        imagefttext($dst, 18, 0, 108, 832, $black, $font, $female);
        imagefttext($dst, 16, 0, 480, 832, $pink, $font, '@'.$name);
        imagejpeg($dst,$path);
        $this->assign('img',$path);
        $this->display();
    }
}