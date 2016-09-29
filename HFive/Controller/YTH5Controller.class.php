<?php

namespace Addons\HFive\Controller;
use Home\Controller\AddonsController;


class YTH5Controller extends AddonsController{
      public function app2()
      {
          header('Content-Type: text/html; charset=utf-8');
          $signPackage=getjssdk();
          $this->assign('signPackage',$signPackage);
          $this->display();
      }
}