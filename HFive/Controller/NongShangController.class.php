<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;


class NongShangController extends AddonsController{
    public function index()
    {
        session('token','gh_4fc719089612');
        header('Content-Type: text/html; charset=utf-8');
        $signPackage=getjssdk();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }
}