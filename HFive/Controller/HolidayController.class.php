<?php

namespace Addons\HFive\Controller;

use Home\Controller\AddonsController;

header("Content-type:text/html;charset=utf-8");
//国庆生成器
class HolidayController extends AddonsController
{
    public function index()
    {
        $this->display();
    }

    public function createimg()
    {
        $name = I('name');//公司名字
        $length = strlen($name);

        if ($length >= 17 & $length < 21) {
            $nameT = $name;
            $sizeT = 50;
            $xT = 140;
            $yT = 130;
            $nameL = $name;
            $sizeL = 25;
            $xL = 333;
            $yL = 790;
        } elseif ($length >= 21 & $length < 24) {
            $nameT = $name;
            $sizeT = 50;
            $xT = 120;
            $yT = 130;
            $nameL = $name;
            $sizeL = 23;
            $xL = 333;
            $yL = 790;
        } elseif ($length >= 24 & $length < 27) {
            $nameT = $name;
            $sizeT = 50;
            $xT = 85;
            $yT = 130;
            $nameL = $name;
            $sizeL = 23;
            $xL = 320;
            $yL = 790;
        } elseif ($length >= 27 & $length < 30) {
            $nameT = $name;
            $sizeT = 50;
            $xT = 50;
            $yT = 140;
            $nameL = $name;
            $sizeL = 20;
            $xL = 330;
            $yL = 790;
        } elseif ($length >= 30 & $length < 33) {
            $nameT = $name;
            $sizeT = 40;
            $xT = 80;
            $yT = 140;
            $nameL = $name;
            $sizeL = 16;
            $xL = 330;
            $yL = 790;
        } elseif ($length >= 33 & $length < 36) {
            $nameT = $name;
            $sizeT = 35;
            $xT = 88;
            $yT = 140;
            $nameL = $name;
            $sizeL = 14;
            $xL = 328;
            $yL = 790;
        } elseif ($length >= 36 & $length < 39) {
            $nameT = $name;
            $sizeT = 30;
            $xT = 105;
            $yT = 140;
            $nameL = $name;
            $sizeL = 14;
            $xL = 318;
            $yL = 790;
        } elseif ($length >= 39 & $length < 42) {
            $nameT = $name;
            $sizeT = 30;
            $xT = 90;
            $yT = 140;
            $nameL = $name;
            $sizeL = 14;
            $xL = 310;
            $yL = 790;
        } elseif ($length >= 42 & $length < 45) {
            $nameT = $name;
            $sizeT = 29;
            $xT = 80;
            $yT = 140;
            $nameL = $name;
            $sizeL = 13;
            $xL = 310;
            $yL = 790;
        }

        $rand = time() . rand(1, 9999);//产生随机数
        $bottom = 'Uploads\Download\Holiday\qbg.jpg';
        $path = 'Uploads/Download/Holiday/' . $rand . '.jpg';//保存的路径
        $dst = imagecreatefromstring(file_get_contents($bottom));//将字符串中的图像流新建一图像
        $font = 'STHeiti-Light.ttc';//字体
        $black = imagecolorallocate($dst, 0, 0, 0);//字体颜色
        imagefttext($dst, $sizeT, 0, $xT, $yT, $black, $font, $nameT);//将文本写入图像
        imagefttext($dst, $sizeL, 0, $xL, $yL, $black, $font, $nameL);//将文本写入图像
        imagejpeg($dst, $path);
        $this->assign('img', $path);
        $this->display();
    }


    public function creatwatermark($name, $rand)//生成水印
    {
        @$hos = iconv("GBK", "UTF-8", $name);
        if (!isset($hos))
            exit;

        $im = ImageCreate(150, 150);
        $gray = ImageColorResolveAlpha($im, 200, 200, 200, 127);
        $red = ImageColorAllocate($im, 230, 150, 150);

        for ($i = 0; $i < 6; $i++)
            ImageArc($im, 75, 75, 148 - $i, 148 - $i, 0, 360, $red);

        $stock = 'STHeiti-Light.ttc';//字体;
        $point = "★";
        $size = 30;
        ImageTTFText($im, $size, 0, 72 - $size / 2, 72 + $size / 2, $red, $stock, $point);

        $a = 75;
        $b = -75;//中心点坐标
        $r = 65;
        $m = 40;//半径，角度
        $size = 16;//字体大小
        $r = $r - $size;

        $word = array();
        $max = 18;
        $count = mb_strlen($hos, 'utf8');
        if ($count > $max) $count = $max;
        if ($count > 12)
            $m = floor(360 / $count);
        else if ($count > 5)
            $m -= $count;

        for ($i = 0; $i < $count; $i++)
            $word[] = mb_substr($hos, $i, 1, 'utf8');

        $j = floor($count / 2);
        if ($j != $count / 2) {
            for ($i = $j; $i >= 0; $i--) {
                $arc = $m * ($j - $i) + $size / 2;
                $x = round($r * cos((90 + $arc) * M_PI / 180)) + $a;
                $y = -1 * (round($r * sin((90 + $arc) * M_PI / 180)) + $b);
                if ($arc < 10) $arc = 0;
                ImageTTFText($im, $size, $arc, $x, $y, $red, $stock, $word[$i]);
                $arc = $m * ($j - $i) - $size / 2;
                $x = round($r * cos((90 - $arc) * M_PI / 180)) + $a;
                $y = -1 * (round($r * sin((90 - $arc) * M_PI / 180)) + $b);
                if ($arc < 10) $arc = 0;
                ImageTTFText($im, $size, -$arc, $x, $y, $red, $stock, $word[$j + $j - $i]);
            }
        } else {
            $j = $j - 1;
            for ($i = $j; $i >= 0; $i--) {
                $arc = $m / 2 + $m * ($j - $i) + $size / 2;
                $x = round($r * cos((90 + $arc) * M_PI / 180)) + $a;
                $y = -1 * (round($r * sin((90 + $arc) * M_PI / 180)) + $b);
                ImageTTFText($im, $size, $arc, $x, $y, $red, $stock, $word[$i]);
                $arc = $m / 2 + $m * ($j - $i) - $size / 2;
                $x = round($r * cos((90 - $arc) * M_PI / 180)) + $a;
                $y = -1 * (round($r * sin((90 - $arc) * M_PI / 180)) + $b);
                ImageTTFText($im, $size, -$arc, $x, $y, $red, $stock, $word[$j + $j + 1 - $i]);
            }
        }
        header('Content-Type:image/png');
        $path='Uploads/Download/Holiday/watermark/' . $rand . '.jpg';
ImagePNG($im);
        return $path;
    }
}







