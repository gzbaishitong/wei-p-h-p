<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;


class CouplesController extends AddonsController{
    public function index()
    {
        session('token','gh_719e0f5b8105');
        header('Content-Type: text/html; charset=utf-8');
        $signPackage=getjssdk();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }

    public function index1()//汉堡视图1
    {
        session('token','gh_d15476629f4b');
        $signPackage=getjssdk();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }

    public function index2()//汉堡视图2
    {
        $this->display();
    }
}